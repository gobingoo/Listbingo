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
class ListbingoViewNew extends GTemplate {
	function display($tpl = null) {
		
		global $mainframe, $option;
		global $listitemid;
		
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		
		$lists = array ();
		
		if (! $user->guest) {
			
			$adid = JRequest::getInt ( 'adid', 0 );
			
			$edit = false;
			if ($adid && $userid) {
				$edit = true;
			}
			
			$configmodel = gbimport ( "listbingo.model.configuration" );
			$cmodel = gbimport ( "listbingo.model.country" );
			$regionsmodel = gbimport ( "listbingo.model.region" );
			$catmodel = gbimport ( "listbingo.model.category" );
			$model = gbimport ( "listbingo.model.ad" );
			
			$row = $model->load ( $adid );
			
			$params = $configmodel->getParams ();
			
			$showcontact = $params->get ( 'show_contact_information', 0 );
			$countrytitle = "";
			$regiontitle = "";
			
			if (! $edit) {
				$country = $cmodel->getCurrentCountry ( $params );
				$region = $regionsmodel->getCurrentRegion ( $params );
				
				$countrytitle = $cmodel->getCountryTitle ( $params );
				$regiontitle = $regionsmodel->getRegionTitle ( $params );
			
			} else {
				$country = $row->country_id ? $row->country_id : - 1;
				$region = $row->region_id ? $row->region_id : - 1;
			}
			
			$force = JRequest::getInt ( 'force', 0 );
			if ($force) {
				$mainframe->setUserState ( $option . 'forcepost', 1 );
				$params->set ( 'posting_scheme', 1 );
			}
			
			$query = "index.php?option=$option&task=new&force=$force&Itemid=$listitemid&time=" . time ();
			$mainframe->setUserState ( "hereiam", base64_encode ( $query ) );
			
			if (! $params->get ( 'enable_cat_in_form' )) {
				$category = JRequest::getInt ( 'catid', 0 );
				$cattitleid = JRequest::getVar ( 'catid', 0 );
				$extrafields = $catmodel->getExtrafields ( $category, $adid );
				$query = "index.php?option=$option&task=new&force=$force&catid=$cattitleid&Itemid=$listitemid&time=" . time ();
				$mainframe->setUserState ( "hereiam", base64_encode ( $query ) );
				
				$catinfo = $catmodel->load ( $category );
				$parents = $catmodel->_getParents ( $category );
				
				if ($parents) {
					$parentstree = array ();
					foreach ( $parents as $p ) {
						$parentstree [] = $p->title;
					}
					arsort ( $parentstree );
				
				}
				
				if (isset ( $parentstree ) && count ( $parentstree ) > 0) {
					$parents = implode ( " >>", $parentstree );
				}
				
				/*** for sub category *****/
				
				$catfilter = new stdClass ();
				
				$catfilter->order = $mainframe->getUserStateFromRequest ( $option . 'listfilter_order', 'order', 'c.title', 'cmd' );
				$catfilter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'listfilter_order_Dir', 'dir', '', 'word' );
				
				$catfilter->country = $country;
				$catfilter->region = $region;
				//$catfilter->countrytitle = $countrytitle;
				//$catfilter->regiontitle = $regiontitle;
				$catfilter->catid = $category;
				$catfilter->access = ( int ) $user->get ( 'aid', 0 );
				
				$childcategories = $catmodel->getListForProduct ( false, $catfilter );
				
				$adcount = $catmodel->_countTotalProducts ( $catfilter );
				
				if (count ( $adcount ) > 0) {
					foreach ( $adcount as $ac ) {
						$indcount [$ac->id] = $ac->adCount;
					}
				}
				
				$this->assignRef ( 'parents', $parents );
				$this->assignRef ( 'catinfo', $catinfo );
				$this->assignRef ( 'categories', $childcategories );
				$this->assignRef ( 'indcount', $indcount );
				
				$this->assignRef ( 'extrafields', $extrafields );
			
			}
			
			GApplication::triggerEvent ( 'onAdEdit', array ($row ) );
			
			//$mainframe->getUserState($option.'forcepost');
			

			if ($params->get ( 'posting_scheme' ) == 2) {
				
				GApplication::triggerEvent ( 'onPostRequest', array (&$user, &$row, &$params, &$edit ) );
				
				
				if (isset ( $user->package ) && is_object ( $user->package )) {
					$packageparams = new JParameter ( $user->package->params );
					$showcontact = $packageparams->get ( 'show_contact', 0 );
				
				}
			
			}
			
			if ($adid) {
				$defaultpricetype = $row->pricetype;
				
				$adcurrency = $row->currency;
				$adcurrencycode = $row->currencycode;
			
			} 

			else {
				
				$defaultpricetype = 1;
				
				$adcurrency = '';
				$adcurrencycode = '';
			}
			
			// Load the form validation behavior
			JHTML::_ ( 'behavior.formvalidation' );
			
			if ($country == 0) {
				$link = JRoute::_ ( "index.php?option=$option&task=countries&Itemid=$listitemid&time=" . time (), false );
				GApplication::redirect ( $link );
			}
			
			if ($region == 0) {
				$link = JRoute::_ ( "index.php?option=$option&task=regions&Itemid=$listitemid&time=" . time (), false );
				GApplication::redirect ( $link );
			}
			
			/*
			 * @modified on 19th May,2010
			 */
			
			if ($params->get ( 'enable_cat_in_form' ) || $edit) {
				
				$filter = new stdClass ();
				$filter->id = 0;
				$filter->parent_id = 0;
				$cat_list = $catmodel->getTreeForSelect ( true, $filter );
				
				$categories = array ();
				$categories [] = JHTML::_ ( 'select.option', '', JText::_ ( 'Select Category' ), 'value', 'text' );
				foreach ( $cat_list as $cat ) {
					
					$xtreename = str_replace ( ".", "", $cat->treename );
					$xtreename = str_replace ( "&nbsp;", "-", $xtreename );
					$xtreename = str_replace ( "<sup>|_</sup>", "", $xtreename );
					
					if (!$params->get ( 'enable_root_cat_post' )&&$cat->parent==0) {
					
						$categories [] = JHTML::_ ( 'select.optgroup', JText::_ ( $xtreename ),  'value', 'text' );
					}
					else
					{
						$categories [] = JHTML::_ ( 'select.option', $cat->value, JText::_ ( $xtreename ), 'value', 'text' );
						
					}
					
					
				}
				$lists ['categories'] = JHTML::_ ( 'select.genericlist', $categories, 'catid', 'class="inputbox required"', 'value', 'text', $row->category_id );
				
				$countries1 = array ();
				$countries1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Country' ), 'value', 'text' );
				
				$countries2 = $cmodel->getListForSelect ( true );
				$countries = array_merge ( $countries1, $countries2 );
				$lists ['countries'] = JHTML::_ ( 'select.genericlist', $countries, 'countries', 'class="inputbox" size="1"', 'value', 'text', $row->country_id );
				
				$this->setLayout ( 'catform' );
			} else {
				
				if (! $category) {
					$link = JRoute::_ ( "index.php?option=$option&task=categories&time=" . time (), false );
					GApplication::redirect ( $link );
				}
			
			}
			
			$pricerequired = "";
			$currequired = "";
			
			$pricerequired = "required validate-numeric";
			$currequired = "required";
			
			$pricetypecategories = $catmodel->getPriceTypeCategories ( true, 0, false );
			
			$status = array ();
			$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'SOLD' ), 'id', 'title' );
			$status [] = JHTML::_ ( 'select.option', '-1', JText::_ ( 'ARCHIVED' ), 'id', 'title' );
			$lists ['status'] = JHTML::_ ( 'select.genericlist', $status, 'status', 'class="inputbox"', 'id', 'title', $row->status );
			
			$pricetype = array ();
			$pricetype [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PRICEABLE' ), 'id', 'title' );
			$pricetype [] = JHTML::_ ( 'select.option', '2', JText::_ ( 'FREE' ), 'id', 'title' );
			$pricetype [] = JHTML::_ ( 'select.option', '3', JText::_ ( 'PRICE_NEGOTIABLE' ), 'id', 'title' );
			
			$lists ['pricetype'] = JHTML::_ ( 'select.radiolist', $pricetype, 'pricetype', array ('onclick' => 'return checkPriceType(this.value)' ), 'id', 'title', $defaultpricetype );
			
			$lists ['featured'] = JHTML::_ ( 'select.booleanlist', 'featured', 'class="inputbox"', $row->featured );
			if ($showcontact) {
				$lists ['showcontact'] = JHTML::_ ( 'select.booleanlist', 'show_contact', 'class="inputbox"', $row->show_contact );
			}
			
			if ($params->get ( 'currency_selectable', 0 )) {
				
				$currencies1 = array ();
				$currencies1 [] = JHTML::_ ( 'select.option', '', JText::_ ( 'Select Currency' ), 'value', 'text' );
				
				$currencies2 = $cmodel->getCurrencyListForSelect ( true );
				$currencies = array_merge ( $currencies1, $currencies2 );
				
				$lists ['price'] = JHTML::_ ( 'select.genericlist', $currencies, 'currency', 'class="inputbox   ' . $currequired . ' "', 'value', 'text', $adcurrencycode . ":" . $adcurrency ) . "&nbsp<input name=\"price\"
	type=\"text\" class=\"inputtextbox1 $pricerequired\" id=\"price\"
	value=\"" . $row->price . "\" />";
			} else {
				$currency = $params->get ( 'default_currency' );
				
				$currencies = explode ( ":", $currency );
				$lists ['price'] = $currencies [0] . "&nbsp<input name=\"price\"
	type=\"text\" class=\"inputtextbox1 $pricerequired \" id=\"price\"
	value=\"" . $row->price . "\" />&nbsp;" . $currencies [1];
				$lists ['price'] .= "<input name=\"currency\"
	type=\"hidden\"  id=\"currency\"
	value=\"" . $currency . "\" />";
			}
			$lists ['user_id'] = JHTML::_ ( 'list.users', 'user_id', $row->user_id, 1, NULL, 'name', 0 );
			$access = array ();
			$access [] = JHTML::_ ( 'select.option', 'can_view', JText::_ ( 'CAN_VIEW' ), 'value', 'text' );
			$access [] = JHTML::_ ( 'select.option', 'can_edit', JText::_ ( 'CAN_EDIT' ), 'value', 'text' );
			$access [] = JHTML::_ ( 'select.option', 'can_delete', JText::_ ( 'CAN_DELETE' ), 'value', 'text' );
			$access [] = JHTML::_ ( 'select.option', 'can_archive', JText::_ ( 'CAN_ARCHIVE' ), 'value', 'text' );
			$access [] = JHTML::_ ( 'select.option', 'can_transfer', JText::_ ( 'CAN_TRANSFER' ), 'value', 'text' );
			$lists ['access'] = GHelper::checkbox ( $access, 'access', 'class="inputbox" size="1"', 'value', 'text', 0 );
			
			$filter = new stdClass ();
			$filter->id = 0;
			$filter->parent_id = 0;
			
			JFilterOutput::objectHTMLSafe ( $row );
			JFilterOutput::objectHTMLSafe ( $edit );
			JFilterOutput::objectHTMLSafe ( $lists );
			JFilterOutput::objectHTMLSafe ( $pricetypecategories );
			JFilterOutput::objectHTMLSafe ( $params );
			JFilterOutput::objectHTMLSafe ( $country );
			JFilterOutput::objectHTMLSafe ( $user );
			JFilterOutput::objectHTMLSafe ( $region );
			
			$this->assignRef ( "row", $row );
			$this->assignRef ( "edit", $edit );
			$this->assignRef ( "lists", $lists );
			$this->assignRef ( 'pricetypecategories', $pricetypecategories );
			$this->assignRef ( 'params', $params );
			$this->assignRef ( 'country', $country );
			$this->assignRef ( 'user', $user );
			$this->assignRef ( 'region', $region );
			
			switch ($params->get ( 'posting_scheme' )) {
				
				case 2 :
					$profilemodel = gbimport ( "listbingo.model.profile" );
					$profile = $profilemodel->getUserProfile ( $userid, $params );
					
					if (isset ( $profile->package ) && is_object ( $profile->package )) {
						//$packageparams = new JParameter ( $profile->package->params );
						$maxlimit = $profile->package->number_of_images;
					} else {
						$maxlimit = $params->get ( 'images_number' );
					}
					break;
				
				case 0 :
				case 1 :
				default :
					$maxlimit = $params->get ( 'images_number' );
					break;
			
			}
			
			$this->assign ( 'max_image_upload_limit', ( int ) $maxlimit );
			
			GApplication::triggerEvent ( 'onBeforeAdPost', array ($row, $params ) );
			
			ListbingoHelper::bakeCountryBreadcrumb ();
			ListbingoHelper::bakeRegionBreadcrumb ();
			ListbingoHelper::bakeCategoryBreadcrumb ();
			
			$suffix = $params->get ( $params->get ( 'listlayout_thumbnail' ) );
			$this->assign ( 'suffix', $suffix );
			
			$locationtext = "";
			if (! $edit) {
				
				$strings = array ();
				if (! empty ( $countrytitle )) {
					$strings [] = "<strong>" . $countrytitle . "</strong>";
				}
				
				if (! empty ( $regiontitle )) {
					
					$strings [] = "<strong>" . $regiontitle . "</strong>";
				}
				
				if ((count ( $strings ) > 0) && ($params->get ( 'country_selection', 0 ) || $params->get ( 'region_selection', 0 ))) {
					$loclink = JRoute::_ ( "index.php?option=$option&task=regions.selectRegionCountry&format=raw&time=" . time (), false );
					
					$locationtext = JText::_ ( 'YOU_ARE_POSTING_AD_IN' ) . " " . implode ( " &raquo; ", $strings );
					$locationtext .= " <a rel=\"moodalbox 650 400\" href=\"$loclink\">" . JText::_ ( 'CHANGE' ) . "</a>";
					
					$locationtext = "<div class='locationinfo'>" . $locationtext . "</div>";
				
				}
			
			}
			
			$this->assign ( 'locationtext', $locationtext );
			
			parent::display ( $tpl );
		} else {
			$catid = JRequest::getInt ( 'catid' );
			if ($catid) {
				$cat = "&catid=" . $catid;
			}
			$returnurl = base64_encode ( JRoute::_ ( "index.php?option=$option&task=new$cat&Itemid=$listitemid&time=" . time (), false ) );
			
			$link = JRoute::_ ( "index.php?option=com_user&view=login&return=$returnurl&Itemid=$listitemid&time=" . time (), false );
			$msg = JText::_ ( "LOGIN_TO_POST_AD" );
			GApplication::redirect ( $link, $msg, "error" );
		}
	}
	
	function customDisplay($tpl = null) {
		parent::display ( $tpl );
	}
}
?>