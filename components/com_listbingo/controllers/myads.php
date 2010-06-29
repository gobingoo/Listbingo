<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ads.php 2010-01-10 00:57:37 svn $
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

gbimport ( "gobingoo.controller" );

class ListbingoControllerMyAds extends GController {
	
	var $myviews = array ();
	
	function __construct($config = array()) {
		parent::__construct ( $config );
		$this->myviews = array ('myads' );
	
	}
	
	function display() {
		$currentview = JRequest::getCmd ( 'view' );
		
		JRequest::setVar ( 'view', 'myads' );
		
		$this->item_type = 'Default';
		
		parent::display ();
	}
	
	function view() {
		
		$currentview = JRequest::getCmd ( 'view' );
		
		if (! in_array ( $currentview, $this->myviews )) {
			JRequest::setVar ( 'view', 'myads' );
		}
		$this->item_type = 'Default';
		parent::display ();
	
	}
	
	function search() {
		
		global $mainframe, $option;
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$countrymodel = gbimport ( "listbingo.model.country" );
		$regionmodel = gbimport ( "listbingo.model.region" );
		
		//Import required libararies
		

		gbimport ( "gobingoo.currency" );
		
		$filter = new stdClass ();
		$filter->params = $params;
		
		$filter->searchtxt = JRequest::getVar ( 'searchtxt', '' );
		
		$regionObj = $regionmodel->findAndSetRegion ( $filter->searchtxt );
		
		$country = $countrymodel->getCurrentCountry ( $params );
		$region = $regionmodel->getCurrentRegion ( $params );
		
		if ($regionObj) {
			$regiontitle = $regionObj->title;
			$filter->searchtxt = $params->get ( 'search_text_default', 'sale' );
		} else {
			$regiontitle = $regionmodel->getRegionTitle ( $params );
		}
		
		$regiontitle = $regionmodel->getRegionTitle ( $params );
		
		$filter->limit = JRequest::getInt ( 'limit', $mainframe->getCfg ( 'list_limit' ) );
		$filter->limitstart = JRequest::getInt ( 'limitstart', 0 );
		
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'listfilter_order_Dir', 'dir', 'a.ordering', 'word' );
		
/*		switch ($order) {
			case 'latest' :
				$filter->order = "a.created_date";
				break;
			
			case 'state' :
				$filter->order = "r.title";
				break;
		
		}*/
		$model = gbimport ( "listbingo.model.ad" );
		$filter->country = $country;
		$filter->region = $region;
		$filter->regiontitle = $regiontitle;
		//var_dump($filter);exit;
		

		$rows = $model->getListWithInfobar ( true, $filter );
		
		$total = $model->getListCountForSearch ( true, $filter );
		jimport ( 'joomla.html.pagination' );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		GApplication::triggerEvent ( 'onBeforeListDisplay', array (&$rows, &$params ) );
		$view = $this->getView ( 'ads', 'html' );
		
		$view->assignRef ( 'rows', $rows );
		$view->assignRef ( 'pagination', $pagenav );
		$view->assignRef ( 'filter', $filter );
		$view->assignRef ( 'params', $params );
		$view->searchDisplay ();
		GApplication::triggerEvent ( 'onAfterListDisplay', array (&$rows, &$params ) );
	
	}

}
?>