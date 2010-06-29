<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: profile.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

gbimport ( "gobingoo.controller" );

class ListbingoControllerProfile extends GController {
	function __construct($config = array()) {
		parent::__construct ( $config );
	
	}
	
	function display() {
		global $option, $listitemid;
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
		
		
		$user = JFactory::getUser();
		$user->editlink="";
		if ($user->guest) {
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&Itemid=$listitemid&task=profile&time=" . rand ( 10000, 999999 ), false ) );
			
			$link = JRoute::_ ( "index.php?option=com_user&view=login&Itemid=$listitemid&return=$returnurl&time=" . rand ( 10000, 999999 ), false );
			$msg = JText::_ ( "LOGIN_TO_EDIT_PROFILE" );
			GApplication::redirect ( $link, $msg, "error" );
		}
		else
		{
			
			GApplication::triggerEvent('onEditProfileRequest',array(&$user,&$params));
			if(!empty($user->editlink))
			{
				GApplication::redirect($user->editlink);
			}
		}
		
		JRequest::setVar ( 'view', 'profile' );
		
		$this->item_type = 'Default';
		
		parent::display ();
	}
	
	/**
	 * Publish Method
	 * @return unknown_type
	 */
	function publish() {
		global $mainframe, $option, $listitemid;
		$tasks = explode ( ".", JRequest::getCmd ( "task" ) );
		$task = $tasks [1];
		
		$user = JFactory::getUser ();
		$cid = $user->get ( 'id' );
		$model = $this->getModel ( 'profile' );
		
		if ($model->publish ( $task, $cid )) {
			switch ($task) {
				case 'publish' :
					$msg = JText::_ ( "PUBLISHED_SUCCESS" );
					break;
				default :
					$msg = JText::_ ( "UNPUBLISHED_SUCCESS" );
					break;
			}
		}
		
		$link = JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false );
		GApplication::redirect ( $link, $msg );
	}
	/**
	 * Unpublish Method
	 * @return unknown_type
	 */
	
	function edit() {
		if (JRequest::getCmd ( 'view' ) == '') {
			JRequest::setVar ( 'view', 'profile' );
		}
		$this->item_type = 'Default';
		parent::display ();
	}
	
	function save() {
		global $mainframe, $option, $listitemid;
		
		if (! JRequest::checkToken ()) {
			throw new Exception ( "Invalid Token" );
		}
		
		$post = JRequest::get ( 'post' );
		$files = JRequest::get ( 'files' );
		$configmodel = gbimport ( 'listbingo.model.configuration' );
		$params = $configmodel->getParams ();
		$tasks = explode ( ".", JRequest::getCmd ( "task" ) );
		$task = array_pop ( $tasks );
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		$post ['user_id'] = $userid;
		if ($userid) {
			try {
				$model = gbimport ( 'listbingo.model.profile' );
				
				$model->save ( $post, $files ['image'], $params );
				switch ($task) {
					case 'save' :
						
						$link = JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false );
						$msg = JText::_ ( "SAVED" );
						$msgtype = "success";
						break;
					default :
						$link = JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false );
						$msg = JText::_ ( "APPLIED" );
						$msgtype = "success";
						break;
				
				}
			
			} catch ( DataException $e ) {
				$link = JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false );
				$msg = $e->getMessage ();
				$msgtype = "error";
			}
		} else {
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false ) );
			$link = JRoute::_ ( "index.php?option=com_user&view=login&return=$returnurl&Itemid=$listitemid", false );
			$msg = JText::_ ( "LOGIN_TO_EDIT_YOUR_PROFILE" );
			$msgtype = "error";
		}
		
		GApplication::redirect ( $link, $msg, $msgtype );
	}
	
	function removeImage() {
		global $mainframe, $option, $listitemid;
		
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		if ($userid) {
			
			$table = JTable::getInstance ( 'profile' );
			
			$table->removeImage ( $userid );
			$link = JRoute::_ ( "index.php?option=$option&view=profile&Itemid=$listitemid", false );
			$msg = JText::_ ( 'IMAGE_DELETED' );
			GApplication::redirect ( $link, $msg );
		} else {
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&task=profile&Itemid=$listitemid", false ) );
			$link = JRoute::_ ( "index.php?option=com_user&view=login&return=$returnurl&Itemid=$listitemid", false );
			$msg = JText::_ ( "LOGIN_TO_DELETE_YOUR_PICTURE" );
		}
	
	}

}
?>