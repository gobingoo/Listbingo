<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
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

// Import Joomla! libraries
gbimport ( "gobingoo.view" );
class ListbingoViewAds extends GView {
	function display($tpl = null) {
		global $mainframe, $option;
		
		$cmodel = gbimport ( "listbingo.model.country" );
		$catmodel = gbimport ( "listbingo.model.category" );
		
		$filter = new stdClass ();
		
		$filter->newpost = 0;
		//echo JRequest::getInt('new',0);exit;
		if (JRequest::getInt ( 'new', 0 )) {
			$filter->newpost = 1;
		} else {
			$filter->newpost = 0;
		}
		
		$filter->limit = $mainframe->getUserStateFromRequest ( $option . 'adslimit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'cmd' );
		$filter->limitstart = $mainframe->getUserStateFromRequest ( $option . 'adslimitstart', 'limitstart', JRequest::getVar ( 'limitstart', 0 ), 'cmd' );
		
		$filter->order = $mainframe->getUserStateFromRequest ( $option . 'adsfilter_order', 'filter_order', 'a.ordering', 'cmd' );
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'adsfilter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$filter->searchtxt = JRequest::getVar ( 'q' );
		
		$filter->status = JRequest::getInt ( 'status', - 1 );
		
		$filter->featured = JRequest::getInt ( 'featured', 0 );
		$filter->category_id = JRequest::getInt ( 'category_id' );
		$filter->country = JRequest::getInt ( 'country_id' );
		$filter->region = JRequest::getInt ( 'region' );
		$filter->flag = JRequest::getInt ( 'flag', 0 );
		$filter->pricetype = JRequest::getInt ( 'pricetype' );
		
		$model = gbimport ( "listbingo.model.ad" );
		$rows = $model->getList ( $filter );
		$total = $model->getListCount ( $filter );
		//$total = count($rows);
		jimport ( 'joomla.html.pagination' );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		$lists = array ();
		
		$lists ['new'] = JHTML::_ ( 'select.booleanlist', 'new', array ('class' => "inputbox", 'onChange' => "document.adminForm.submit();" ), JRequest::getInt ( 'new', 0 ) );
		
		$status = array ();
		$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'SUSPENDED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'CLOSED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '4', JText::_ ( 'ARCHIVED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '-1', JText::_ ( 'ALL' ), 'id', 'title' );
		$lists ['status'] = JHTML::_ ( 'select.genericlist', $status, 'status', 'class="inputbox"', 'id', 'title', $filter->status );
		
		$cat_filter = new stdClass ();
		$cat_filter->id = 0;
		$cat_filter->parent_id = 0;
		$cat_list = $catmodel->getTreeForSelect ( true, $cat_filter );
		$categories = array ();
		$categories [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Category' ), 'value', 'text' );
		foreach ( $cat_list as $cat ) {
			
			$xtreename = str_replace ( ".", "", $cat->treename );
			$xtreename = str_replace ( "&nbsp;", "-", $xtreename );
			$xtreename = str_replace ( "<sup>|_</sup>", "", $xtreename );
			$categories [] = JHTML::_ ( 'select.option', $cat->value, JText::_ ( $xtreename ), 'value', 'text' );
		}
		$lists ['categories'] = JHTML::_ ( 'select.genericlist', $categories, 'category_id', 'class="inputbox" size="1"', 'value', 'text', $filter->category_id );
		
		if (JRequest::getInt ( 'pricetype' ) > 0) {
			$defaultpricetype = JRequest::getInt ( 'pricetype' );
		} else {
			$defaultpricetype = 1;
		}
		$pricetype = array ();
		$pricetype [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PRICEABLE' ), 'id', 'title' );
		$pricetype [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'FREE' ), 'id', 'title' );
		$pricetype [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'PRICE_NEGOTIABLE' ), 'id', 'title' );
		
		$lists ['pricetype'] = JHTML::_ ( 'select.radiolist', $pricetype, 'pricetype', array ('class' => "inputbox", 'onclick' => 'return checkPriceType(this.value)' ), 'id', 'title', $defaultpricetype );
		
		$countries1 = array ();
		$countries1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Country' ), 'value', 'text' );
		
		$countries2 = $cmodel->getListForSelect ( true );
		$countries = array_merge ( $countries1, $countries2 );
		$lists ['countries'] = JHTML::_ ( 'select.genericlist', $countries, 'country_id', 'class="inputbox" size="1"', 'value', 'text', $filter->country );
		
		JFilterOutput::objectHTMLSafe ( $rows );
		JFilterOutput::objectHTMLSafe ( $filter );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagenav );
		$this->assignRef ( 'filter', $filter );
		$this->assignRef ( 'lists', $lists );
		parent::display ( $tpl );
	
	}
}
?>