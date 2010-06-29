<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
 * @author gobingoo.com
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * @code Bruce
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

gbimport ( "gobingoo.template" );

/**
 * HTML View class for the Listbingo component
 */
class ListbingoViewProfile extends GTemplate {
	function display($tpl = null) {
		
		global $mainframe, $option, $listitemid;
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$cmodel = gbimport ( "listbingo.model.country" );
		$regionsmodel = gbimport ( "listbingo.model.region" );
		$model = gbimport ( "listbingo.model.profile" );
		$params = $configmodel->getParams ();
		
		$lists = array ();
		
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		
		//$model->getProfile($userid,$params);
		

		if ($user->guest) {
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid&time=" . time (), false ) );
			
			$link = JRoute::_ ( "index.php?option=com_user&view=login&return=$returnurl&Itemid=$listitemid&time=" . time (), false );
			$msg = JText::_ ( "LOGIN_TO_EDIT_PROFILE" );
			GApplication::redirect ( $link, $msg, "error" );
		}
		
		$row = $model->loadProfile ( $userid, $params );
		
		if (count ( $row ) > 0) {
			$selectedcountry = $row->country_id;
		} else {
			$selectedcountry = 0;
		}
		$countries1 = array ();
		$countries1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Country' ), 'value', 'text' );
		
		$countries2 = $cmodel->getListForSelect ( true );
		$countries = array_merge ( $countries1, $countries2 );
		$lists ['countries'] = JHTML::_ ( 'select.genericlist', $countries, 'country_id', 'class="selectinputbox required" size="1"', 'value', 'text', $selectedcountry );
		
		GApplication::triggerEvent ( 'onAdEdit', array (&$row ) );
		
		$edit = false;
		
		if ($userid) {
			$edit = true;
		}
		
		$baseurl = JUri::root ();
		$basepath = JPATH_ROOT;
		
		$suffix = $params->get ( $params->get ( 'listlayout_thumbnail' ) );
		$noimage = JUri::root () . $params->get ( 'path_default_profile_noimage' );
		
		$delimagelink = "";
		
		if (! file_exists ( $basepath . $row->image . $params->get ( 'suffix_profile_image' ) . "." . $row->extension )) {
			if ($params->get ( 'profile_enable_gravatar' )) {
				$hashemail = md5 ( $row->email );
				$imgurl = "http://www.gravatar.com/avatar/" . $hashemail . "?s=75";
			}
		
		} else {
			if ($row->image != "") {
				$dellink = JRoute::_ ( 'index.php?option=' . $option . '&task=profile.removeImage&time=' . time () );
				$delimagelink .= "<a href=\"$dellink\">" . JText::_ ( 'REMOVE' ) . "</a>";
			
			} else {
				$delimagelink .= "<a>" . $row->name . "</a>";
			
			}
			$imgurl = $baseurl . $row->image . $params->get ( 'suffix_profile_image' ) . "." . $row->extension;
		}
		
		
		// Load the form validation behavior
		JHTML::_ ( 'behavior.formvalidation' );
		
		$this->assignRef ( "profile", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( 'params', $params );
		$this->assignRef ( 'lists', $lists );
		$this->assignRef ( 'imgurl', $imgurl );
		$this->assignRef ( 'delimagelink', $delimagelink );
		parent::display ( $tpl );
	}
}
?>