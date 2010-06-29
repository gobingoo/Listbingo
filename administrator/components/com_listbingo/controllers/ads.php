<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ads.php 2010-01-10 00:57:37 svn $
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

class ListbingoControllerAds extends GController {
	
	function __construct($config = array()) {
		parent::__construct ( $config );
		$this->registerTask ( 'add', 'edit' );
		$this->registerTask ( 'unpublish', 'publish' );
		$this->registerTask ( 'apply', 'save' );
		$this->registerTask ( 'orderup', 'order' );
		$this->registerTask ( 'orderdown', 'order' );
	
	}
	
	function display() {
		if (JRequest::getCmd ( 'view' ) == '') {
			JRequest::setVar ( 'view', 'ads' );
		}
		$this->item_type = 'Default';
		parent::display ();
	}
	
	function cancel() {
		global $option, $mainframe;
		
		$mainframe->setUserState ( $option . 'admin_globalad_id', "" );
		$mainframe->setUserState ( $option . 'admin_title', "" );
		$mainframe->setUserState ( $option . 'admin_alias', "" );
		$mainframe->setUserState ( $option . 'admin_status', "" );
		$mainframe->setUserState ( $option . 'admin_pricetype', "" );
		$mainframe->setUserState ( $option . 'admin_currencycode', "" );
		$mainframe->setUserState ( $option . 'admin_currency', "" );
		$mainframe->setUserState ( $option . 'admin_price', "" );
		$mainframe->setUserState ( $option . 'admin_expiry_date', "" );
		$mainframe->setUserState ( $option . 'admin_description', "" );
		$mainframe->setUserState ( $option . 'admin_country_id', "" );
		$mainframe->setUserState ( $option . 'admin_address2', "" );
		$mainframe->setUserState ( $option . 'admin_zipcode', "" );
		$mainframe->setUserState ( $option . 'admin_address1', "" );
		$mainframe->setUserState ( $option . 'admin_category_id', "" );
		$mainframe->setUserState ( $option . 'admin_tags', "" );
		$mainframe->setUserState ( $option . 'admin_metadesc', "" );
		
		$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
		GApplication::redirect ( $link );
	}
	
	/**
	 * Publish Method
	 * @return unknown_type
	 */
	function publish() {
		global $mainframe, $option;
		$tasks = explode ( ".", JRequest::getCmd ( "task" ) );
		$task = $tasks [1];
		
		$cid = JRequest::getVar ( 'cid', array (), '', 'array' );
		$model = $this->getModel ( 'ad' );
		
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
		
		$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
		GApplication::redirect ( $link, $msg );
	}
	/**
	 * Unpublish Method
	 * @return unknown_type
	 */
	
	function edit() {
		if (JRequest::getCmd ( 'view' ) == '') {
			JRequest::setVar ( 'view', 'ad' );
		}
		$this->item_type = 'Default';
		parent::display ();
	}
	
	function save() {
		if (! JRequest::checkToken ()) {
			throw new TokenException ( "Invalid Token" );
		}
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		global $mainframe, $option;
		$post = JRequest::get ( 'post' );
		
		$edit = isset ( $post ['id'] ) ? $post ['id'] : 0;
		
		$imageids = "";
		if (isset ( $post ['publishimage'] ) && count ( $post ['publishimage'] ) > 0) {
			$imageids = implode ( ",", $post ['publishimage'] );
		}
		$deleteimage = "";
		
		if (isset ( $post ['deleteimage'] ) && count ( $post ['deleteimage'] ) > 0) {
			$delimageids = implode ( ",", $post ['deleteimage'] );
		}
		
		$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );
		
		$tasks = explode ( ".", JRequest::getCmd ( "task" ) );
		$task = array_pop ( $tasks );
		
		$images = JRequest::get ( 'files' );
		// Support for Attachment Element
		$attachments = isset ( $images ['field'] ) ? $images ['field'] : array ();
		
		$images = isset ( $images ['images'] ) ? $images ['images'] : array ();
		$fields = JRequest::getVar ( 'field', array () );
		$availableattach = JRequest::getVar ( 'available_attach', array () );
		
		if (! $post ['user_id']) {
			$u = JFactory::getUser ();
			$post ['user_id'] = $u->get ( 'id' );
		}
		
		$mainframe->setUserState ( $option . 'admin_globalad_id', $post ['globalad_id'] );
		$mainframe->setUserState ( $option . 'admin_title', $post ['title'] );
		$mainframe->setUserState ( $option . 'admin_alias', $post ['alias'] );
		$mainframe->setUserState ( $option . 'admin_status', $post ['status'] );
		$mainframe->setUserState ( $option . 'admin_pricetype', $post ['pricetype'] );
		$mainframe->setUserState ( $option . 'admin_currency', $post ['currency'] );
		
		$mainframe->setUserState ( $option . 'admin_price', $post ['price'] );
		$mainframe->setUserState ( $option . 'admin_expiry_date', $post ['expiry_date'] );
		$mainframe->setUserState ( $option . 'admin_description', $post ['description'] );
		$mainframe->setUserState ( $option . 'admin_country_id', $post ['country_id'] );
		$mainframe->setUserState ( $option . 'admin_address2', $post ['address2'] );
		$mainframe->setUserState ( $option . 'admin_zipcode', $post ['zipcode'] );
		$mainframe->setUserState ( $option . 'admin_address1', $post ['address1'] );
		$mainframe->setUserState ( $option . 'admin_category_id', $post ['category_id'] );
		$mainframe->setUserState ( $option . 'admin_tags', isset ( $post ['tags'] ) ? $post ['tags'] : '' );
		$mainframe->setUserState ( $option . 'admin_metadesc', isset ( $post ['metadesc'] ) ? $post ['metadesc'] : '' );
		
		try {
			GApplication::triggerEvent ( "onBeforFormProcess", array (&$post ) );
			GApplication::triggerEvent ( "onAdminBeforeAdSave", array (&$post, &$images, &$fields , &$params) );
			$model = $this->getModel ( 'ad' );
			
			//Check for status updates
			$oldadid = JRequest::getInt ( 'id', 0 );
			$oldad = null;
			if ($oldadid) {
				$oldad = $model->load ( $oldadid );
			}
			$fields ['attachments'] = $attachments;
			$fields ['available_attachments'] = $availableattach;
			
			$id = $model->save ( $post, $images, $fields );
			
			$currentad = $model->load ( $id );
			if (! empty ( $imageids )) {
				$model->publishImages ( $id, $imageids );
			}
			
			if (! empty ( $delimageids )) {
				$model->deleteImages ( $id, $delimageids, $params );
			}
			
			$post ['id'] = $id;
			$post['edit'] = $edit;
			
			switch ($task) {
				case 'save' :
					$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
					$msg = JText::_ ( "SAVED" );
					break;
				default :
					$link = JRoute::_ ( "index.php?option=$option&task=ads.edit&cid[]=" . $id, false );
					$msg = JText::_ ( "APPLIED" );
					break;
			
			}
			
			if (is_object ( $oldad )) {
				if ($oldad->status != 2 && $currentad->status == 2) {
					GApplication::triggerEvent ( "onAdSuspended", array (&$currentad, &$params ) );
				}
				
				if ($oldad->status != 1 && $currentad->status == 1) {
					GApplication::triggerEvent ( "onAdResumed", array (&$currentad, &$params ) );
				}
			}
			
			$mainframe->setUserState ( $option . 'admin_globalad_id', "" );
			$mainframe->setUserState ( $option . 'admin_title', "" );
			$mainframe->setUserState ( $option . 'admin_alias', "" );
			$mainframe->setUserState ( $option . 'admin_status', "" );
			$mainframe->setUserState ( $option . 'admin_pricetype', "" );
			$mainframe->setUserState ( $option . 'admin_currencycode', "" );
			$mainframe->setUserState ( $option . 'admin_currency', "" );
			$mainframe->setUserState ( $option . 'admin_price', "" );
			$mainframe->setUserState ( $option . 'admin_expiry_date', "" );
			$mainframe->setUserState ( $option . 'admin_description', "" );
			$mainframe->setUserState ( $option . 'admin_country_id', "" );
			$mainframe->setUserState ( $option . 'admin_address2', "" );
			$mainframe->setUserState ( $option . 'admin_zipcode', "" );
			$mainframe->setUserState ( $option . 'admin_address1', "" );
			$mainframe->setUserState ( $option . 'admin_category_id', "" );
			$mainframe->setUserState ( $option . 'admin_tags', "" );
			$mainframe->setUserState ( $option . 'admin_metadesc', "" );

			
			GApplication::triggerEvent ( "onAdminAfterAdSave", array ($currentad, &$params, $post ) );
		} catch ( DataException $e ) {
			$link = JRoute::_ ( "index.php?option=$option&task=ads.edit&cid[]=" . $post ['id'], false );
			$msg = $e->getMessage ();
		}
		
		GApplication::redirect ( $link, $msg );
	}
	
	function remove() {
		global $mainframe, $option;
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		try {
			$model = $this->getModel ( 'ad' );
			
			$model->remove ( $cid );
			$msg = JText::_ ( 'DELETED' );
		} catch ( DataException $e ) {
			$msg = $e->getMessage ();
		}
		
		$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
		GApplication::redirect ( $link, $msg );
	
	}
	
	function saveorder() {
		global $mainframe, $option;
		
		$error = "info";
		$cid = JRequest::getVar ( 'cid', array (), '', 'array' );
		
		$total = count ( $cid );
		$order = JRequest::getVar ( 'order', array (0 ), 'post', 'array' );
		JArrayHelper::toInteger ( $order, array (0 ) );
		$model = $this->getModel ( 'ad' );
		$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
		try {
			$model->saveorder ( $cid, $order, $total );
			$msg = JText::_ ( "ORDER_SAVED" );
		} catch ( DataException $e ) {
			$error = "error";
			$msg = $e->getMessage ();
		}
		GApplication::redirect ( $link, $msg );
	
	}
	
	function order() {
		global $mainframe, $option;
		
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$tasks = explode ( ".", JRequest::getCmd ( "task" ) );
		$task = $tasks [1];
		
		$cid = JRequest::getVar ( 'cid', array (), '', 'array' );
		$model = $this->getModel ( 'ad' );
		
		if ($model->order ( $task, $id )) {
			switch ($task) {
				case 'orderdown' :
					$msg = JText::_ ( "ORDER_DOWN" );
					break;
				default :
					$msg = JText::_ ( "ORDERUP" );
					break;
			}
		}
		
		$link = JRoute::_ ( "index.php?option=$option&task=ads", false );
		GApplication::redirect ( $link, $msg );
	}
	
	function removeImage() {
		global $mainframe, $option;
		
		$adid = JRequest::getInt ( 'adid', 0 );
		$iid = JRequest::getInt ( 'iid', 0 );
		
		$imgtable = JTable::getInstance ( 'adimage' );
		
		$imgtable->removeImage ( $iid );
		
		$link = JRoute::_ ( "index.php?option=$option&task=ads.edit&cid[]=$adid", false );
		$msg = JText::_ ( 'Images Deleted Successfully' );
		GApplication::redirect ( $link, $msg );
	
	}
}
?>