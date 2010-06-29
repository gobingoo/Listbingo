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
class ListbingoViewAd extends GView {
	function display($tpl = null) {
		global $option, $mainframe;
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$model = gbimport ( "listbingo.model.ad" );
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$model = gbimport ( "listbingo.model.ad" );
		$cmodel = gbimport ( "listbingo.model.country" );
		$catmodel = gbimport ( "listbingo.model.category" );
		
		$pricetypecategories = $catmodel->getPriceTypeCategories ( true, 0, false );
		
		$row = $model->load ( $id );
		
		JFilterOutput::objectHTMLSafe ( $row );
		
		//var_dump($row);exit;
		GApplication::triggerEvent ( 'onAdEdit', array (&$row ) );
		$edit = false;
		if ($id) {
			
			$mainframe->setUserState ( $option . 'admin_globalad_id', $row->globalad_id );
			$mainframe->setUserState ( $option . 'admin_title', $row->title );
			$mainframe->setUserState ( $option . 'admin_alias', $row->alias );
			$mainframe->setUserState ( $option . 'admin_status', $row->status );
			$mainframe->setUserState ( $option . 'admin_pricetype', $row->pricetype );
			$mainframe->setUserState ( $option . 'admin_currencycode', $row->currencycode );
			$mainframe->setUserState ( $option . 'admin_currency', $row->currency );
			$mainframe->setUserState ( $option . 'admin_price', $row->price );
			$mainframe->setUserState ( $option . 'admin_expiry_date', $row->expiry_date );
			$mainframe->setUserState ( $option . 'admin_description', $row->description );
			$mainframe->setUserState ( $option . 'admin_country_id', $row->country_id );
			$mainframe->setUserState ( $option . 'admin_address2', $row->address2 );
			$mainframe->setUserState ( $option . 'admin_zipcode', $row->zipcode );
			$mainframe->setUserState ( $option . 'admin_address1', $row->address1 );
			$mainframe->setUserState ( $option . 'admin_category_id', $row->category_id );
			$mainframe->setUserState ( $option . 'admin_tags', $row->tags );
			$mainframe->setUserState ( $option . 'admin_metadesc', $row->metadesc );
			
			$edit = true;
		}
		
		if ($id) {
			$defaultpricetype = $mainframe->getUserState ( $option . 'admin_pricetype', $row->pricetype );
		} else {
			$defaultpricetype = 1;
		}
		
		$lists = array ();
		
		$status = array ();
		$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'SUSPENDED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'CLOSED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '4', JText::_ ( 'ARCHIVED' ), 'id', 'title' );
		$lists ['status'] = JHTML::_ ( 'select.genericlist', $status, 'status', 'class="inputbox"', 'id', 'title', $mainframe->getUserState ( $option . 'admin_status', $row->status ) );
		
		$pricetype = array ();
		$pricetype [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PRICEABLE' ), 'id', 'title' );
		$pricetype [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'FREE' ), 'id', 'title' );
		$pricetype [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'PRICE_NEGOTIABLE' ), 'id', 'title' );
		
		$lists ['pricetype'] = JHTML::_ ( 'select.radiolist', $pricetype, 'pricetype', array ('class' => "inputbox", 'onclick' => 'return checkPriceType(this.value)' ), 'id', 'title', $defaultpricetype );
		
		//$lists['setprice']=JHTML::_('select.booleanlist','setprice',array('class'=>"inputbox",'onclick'=>'return checkPrice(this.value)'),$setprice);
		

		$currencies1 = array ();
		$currencies1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Currency' ), 'value', 'text' );
		
		$currencies2 = $cmodel->getCurrencyListForSelect ( true );
		
		if (count ( $currencies2 ) > 0) {
			$defaultcurrency = $mainframe->setUserState ( $option . 'admin_currencycode', $row->currencycode ) . ":" . $mainframe->setUserState ( $option . 'admin_currency', $row->currency );
		} else {
			$defaultcurrency = 0;
		}
		
		$currencies = array_merge ( $currencies1, $currencies2 );
		$lists ['currencies'] = JHTML::_ ( 'select.genericlist', $currencies, 'currency', 'class="inputbox" size="1"', 'value', 'text', $defaultcurrency );
		
		$countries1 = array ();
		$countries1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Country' ), 'value', 'text' );
		
		$countries2 = $cmodel->getListForSelect ( true );
		$countries = array_merge ( $countries1, $countries2 );
		$lists ['countries'] = JHTML::_ ( 'select.genericlist', $countries, 'country_id', 'class="inputbox" size="1"', 'value', 'text', $mainframe->setUserState ( $option . 'admin_country_id', $row->country_id ) );
		
		/*$currencies1=array();
		 $currencies1[] = JHTML::_('select.option', '0', JText::_('Select Currency'), 'value', 'text');

		 $currencies2=$cmodel->getCurrencyListForSelect(true);
		 $currencies=array_merge($currencies1,$currencies2);
		 $lists['currencies'] = JHTML::_('select.genericlist',   $currencies, 'currency', 'class="inputbox" size="1"', 'value', 'text',$mainframe->setUserState ( $option . 'admin_currencycode',$row->currencycode).":".$mainframe->setUserState ( $option . 'admin_currency',$row->currency) );
		 */		$lists ['user_id'] = JHTML::_ ( 'list.users', 'user_id', $row->user_id, 1, NULL, 'name', 0 );
		$access = array ();
		$access [] = JHTML::_ ( 'select.option', 'can_view', JText::_ ( 'CAN_VIEW' ), 'value', 'text' );
		$access [] = JHTML::_ ( 'select.option', 'can_edit', JText::_ ( 'CAN_EDIT' ), 'value', 'text' );
		$access [] = JHTML::_ ( 'select.option', 'can_delete', JText::_ ( 'CAN_DELETE' ), 'value', 'text' );
		$access [] = JHTML::_ ( 'select.option', 'can_archive', JText::_ ( 'CAN_ARCHIVE' ), 'value', 'text' );
		$access [] = JHTML::_ ( 'select.option', 'can_transfer', JText::_ ( 'CAN_TRANSFER' ), 'value', 'text' );
		$lists ['access'] = GHelper::checkbox ( $access, 'access', 'class="inputbox" size="1"', 'value', 'text', $mainframe->getUserState ( $option . 'admin_access', 0 ) );
		
		$filter = new stdClass ();
		$filter->id = 0;
		$filter->parent_id = 0;
		$cat_list = $catmodel->getTreeForSelect ( true, $filter );
		$categories = array ();
		$categories [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Category' ), 'value', 'text' );
		foreach ( $cat_list as $cat ) {
			
			$xtreename = str_replace ( ".", "", $cat->treename );
			$xtreename = str_replace ( "&nbsp;", "-", $xtreename );
			$xtreename = str_replace ( "<sup>|_</sup>", "", $xtreename );
			$categories [] = JHTML::_ ( 'select.option', $cat->value, JText::_ ( $xtreename ), 'value', 'text' );
		}
		$lists ['categories'] = JHTML::_ ( 'select.genericlist', $categories, 'category_id', 'class="inputbox" style="width:200px;" size="15"', 'value', 'text', $mainframe->getUserState ( $option . 'admin_category_id', $row->category_id ) );
		
		$lists ['showcontact'] = JHTML::_ ( 'select.booleanlist', 'show_contact', 'class="inputbox"', $row->show_contact );
		
		
		JFilterOutput::objectHTMLSafe ( $row );
		JFilterOutput::objectHTMLSafe ( $edit );
		JFilterOutput::objectHTMLSafe ( $lists );
		JFilterOutput::objectHTMLSafe ( $categories );
		JFilterOutput::objectHTMLSafe ( $pricetypecategories );
		JFilterOutput::objectHTMLSafe ( $params );
		
		$this->assignRef ( "row", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( "lists", $lists );
		$this->assignRef ( 'categories', $categories );
		$this->assignRef ( 'pricetypecategories', $pricetypecategories );
		$this->assignRef ( 'params', $params );
		parent::display ( $tpl );
	}
}
?>