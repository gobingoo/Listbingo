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
class ListbingoViewMyads extends GTemplate {
	
	function display($tpl = null) {
		
		global $mainframe, $option, $listitemid;
		
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		
		if (! $userid) {
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&task=myads&Itemid=$listitemid", false ) );
			$link = JRoute::_ ( "index.php?option=com_user&view=login&return=$returnurl&Itemid=$listitemid&time=" . time (), false );
			$msg = JText::_ ( "PLEASE_LOGIN" );
			GApplication::redirect ( $link, $msg, "error" );
		} else {
			$configmodel = gbimport ( "listbingo.model.configuration" );
			$regionmodel = gbimport ( "listbingo.model.region" );
			
			$params = $configmodel->getParams ();
			
			$filter = new stdClass ();
			
			$filter->limit = JRequest::getVar ( 'limit', $params->get ( 'ads_per_page', 10 ) );
			$filter->limitstart = JRequest::getVar ( 'limitstart', 0 );
			
			$filter->regiontitle = $regionmodel->getRegionTitle ( $params );
			
			$filter->order = $mainframe->getUserStateFromRequest ( $option . 'myadfilter_order', 'filter_order', 'p.ordering', 'cmd' );
			$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'myadfilter_order_Dir', 'filter_order_Dir', '', 'word' );
			$filter->params = $params;
			$filter->userid = $userid;
			$filter->checkExpiryDate = 0;
			

			$filter->searchtxt = JRequest::getVar ( 'q', "" );
			$filter->catid = JRequest::getVar ( 'category_id', "" );
			$filter->status = JRequest::getVar ( 'status', - 1 );
			$filter->access = ( int ) $user->get ( 'aid', 0 );
			
			$model = gbimport ( "listbingo.model.ad" );
			$rows = $model->getUserAds ( true, $filter );
			
			$total = $model->getUserAdsCount ( true, $filter );
			jimport ( 'joomla.html.pagination' );
			
			$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
			
			$lists = array ();
			
			$myadstatus = $mainframe->getUserStateFromRequest ( $option . 'myadstatus', 'status', JRequest::getInt ( 'status', 1 ), 'cmd' );
			$myadcategory = $mainframe->getUserStateFromRequest ( $option . 'myadcategory', 'category_id', JRequest::getInt ( 'category_id', "" ), 'cmd' );
			
			$status = array ();
			$status [] = JHTML::_ ( 'select.option', '-1', JText::_ ( 'ALL' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'SUSPENDED' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'CLOSED' ), 'id', 'title' );
			
			$lists ['status'] = JHTML::_ ( 'select.genericlist', $status, 'status', null, 'id', 'title', $filter->status );
			
			$catmodel = gbimport ( "listbingo.model.category" );
			
			$catfilter = new stdClass ();
			$catfilter->id = 0;
			$catfilter->parent_id = 0;
			
			$cat_list = $catmodel->getTreeForSelect ( true, $catfilter );
			$categories = array ();
			$categories [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Category' ), 'value', 'text' );
			foreach ( $cat_list as $cat ) {
				
				$xtreename = str_replace ( ".", "", $cat->treename );
				$xtreename = str_replace ( "&nbsp;", "-", $xtreename );
				$xtreename = str_replace ( "<sup>|_</sup>", "", $xtreename );
				$categories [] = JHTML::_ ( 'select.option', $cat->value, JText::_ ( $xtreename ), 'value', 'text' );
			}
			$lists ['categories'] = JHTML::_ ( 'select.genericlist', $categories, 'category_id', 'class="inputbox" ', 'value', 'text', $filter->catid );
			
			
			
			foreach ( $rows as &$row ) {
			 $row->title= JFilterOutput::cleanText ( $row->title );
			  $row->id= JFilterOutput::cleanText ( $row->id );
				
				$row->address1= JFilterOutput::cleanText ( $row->address1);
				$row->address2=JFilterOutput::cleanText ( $row->address2);
				$row->price=JFilterOutput::cleanText ( $row->price);
			}
			
			
			JFilterOutput::objectHTMLSafe ( $pagenav );
			JFilterOutput::objectHTMLSafe ( $lists );
			JFilterOutput::objectHTMLSafe ( $params );			
			JFilterOutput::objectHTMLSafe ( $filter );
			
			GApplication::triggerEvent ( 'onBeforeListDisplay', array (&$rows, &$params ) );
			
			$this->assignRef ( 'rows', $rows );
			$this->assignRef ( 'pagination', $pagenav );
			$this->assignRef ( 'filter', $filter );
			$this->assignRef ( 'params', $params );
			$this->assignRef ( 'lists', $lists );

			
			parent::display ( $tpl );
			GApplication::triggerEvent ( 'onAfterListDisplay', array (&$rows, &$params ) );
		}
	
	}

}
?>