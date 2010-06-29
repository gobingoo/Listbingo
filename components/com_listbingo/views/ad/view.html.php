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
jimport ( "joomla.utilities.date" );
/**
 * HTML View class for the Listbingo component
 */
class ListbingoViewAd extends GTemplate {
	function display($tpl = null) {
		global $mainframe, $option, $listitemid;
		//Import required libararies
		

		gbimport ( "gobingoo.currency" );
		
		$model = gbimport ( "listbingo.model.ad" );
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$document = & JFactory::getDocument ();
		
		$id = JRequest::getInt ( 'adid', 0 );
		
		$viewCounter = $model->hit ( $id );
		$row = $model->loadWithFields ( $id, true );
		
		//JFilterOutput::objectHTMLSafe ( $row );

		GApplication::triggerEvent ( 'onBeforeLoadDetail', array (&$row, &$params ) );
		
		if (! $row->canbeviewed || is_null($row->user_id)) {
			$this->setLayout ( 'noad' );
			parent::display ( $tpl );
		} else {
			
			$this->assignRef ( 'params', $params );
			ListbingoHelper::bakeCountryBreadcrumb ();
			ListbingoHelper::bakeRegionBreadcrumb ();
			ListbingoHelper::bakeCategoryBreadcrumb ();
			gbimport ( "gobingoo.extrafieldhelper" );
			$price = "";
			
			if ($row->hasprice == 1) {
				$currency = new GCurrency ( $row->price, $row->currencycode, $row->currency, $params->get ( 'currency_format' ), $params->get ( 'decimals' ), $this->params->get ( 'decimal_separator' ), $params->get ( 'value_separator' ) );
				
				switch ($row->pricetype) {
					
					case 2 :
						$price = JText::_ ( 'FREE' );
						break;
					case 3 :
						$price = JText::_ ( 'PRICE_NEGOTIABLE' );
						break;
					
					default :
						if ($row->price > 0) {
							$price = $currency->toString ();
						} else {
							$price = JText::_ ( 'FREE' );
						}
						break;
				}
			
			}
			

			$user = JFactory::getUser ();

			$adimages = "";
			$imageflag = 0;
			if (count ( $row->images ) > 0) {
				$basepath = JPATH_ROOT;
				$midthumb = $params->get ( 'suffix_thumbnail_mid' );
				foreach ( $row->images as $f ) {
					if (file_exists ( $basepath . $f->image . $midthumb . "." . $f->extension )) {
						$imageflag = 1;
					}
				}
				
				if ($imageflag > 0) {
					$imagedata = "";
					$adimages .= "<div class=\"imageSlide\">";
					
					$adimages .= $this->render ( 'image', array ("images" => $row->images, "title" => $row->title, "description" => $row->description ), false );
					$adimages .= "</div>";
				}
			
			} else {
				
				$slidewidth = $params->get ( 'width_thumbnail_mid' );
				$slideheight = $params->get ( 'height_thumbnail_mid' );
							
				$noimageurl = JUri::root () . "administrator/components/com_listbingo/images/noimage-large.gif";
				$imagedata = "";
				$adimages .= "<div class=\"imageSlide\">";				
				$adimages .= "<div id=\"myGallery\">";
				$adimages .= "<img src=\"$noimageurl\" class=\"full\" width=\"$slidewidth\" height=\"$slideheight\" />";
				$adimages .= "</div>";
				$adimages .= "</div>";
			}
			
			JFilterOutput::objectHTMLSafe ( $adimages );
			$this->assignRef ( 'adimages', $adimages );
			
			$address = array ();
			$regions = array ();
			
			if (! empty ( $row->address->address )) {
				$address [] = $row->address->address;
			}
			
			if (! empty ( $row->address->street )) {
				$address [] = $row->address->street;
			}
			
			if (! empty ( $row->address->region )) {
				$regions [] = $row->address->region;
			}
			
			if (! empty ( $row->address->state )) {
				$regions [] = $row->address->state;
			}
			
			if (! empty ( $row->address->zipcode )) {
				$regions [] = $row->address->zipcode;
			}
			
			$row->created_date = ListbingoHelper::getDate ( $row->created_date, $params->get ( 'date_format' ) );
			
			$adaddress = implode ( ", ", $address );
			$adregion = implode ( ", ", $regions );
			
			$this->assignRef ( 'address', $adaddress );
			$this->assignRef ( 'regions', $adregion );
			
			$this->assign ( 'price', $price );
			
			$profilemodel = gbimport ( "listbingo.model.profile" );
			
			GApplication::triggerEvent ( 'onLoadProfilelink', array (&$row->aduser, &$params ) );
			
			if (empty ( $row->aduser->profilelink )) {
				$row->aduser->profilelink = JRoute::_ ( "index.php?option=$option&task=ads.showuserads&uid=" . $row->user_id );
			}
			
			$this->assignRef ( 'user', $user );
			GApplication::triggerEvent ( 'onBeforeAdDisplay', array (&$row, &$params ) );
			
			if (($row->user_id == $user->get ( 'id', 0 )) && ! $user->guest) {
				$link = JRoute::_ ( "index.php?option=$option&task=ads.edit&catid=" . $row->category_id . "&adid=" . $row->id, false );
				$row->adlink = "<a href=\"$link\">" . JText::_ ( 'EDIT' ) . "</a>";
			} else {
				$link = JRoute::_ ( "index.php?option=$option&&task=new", false );
				$row->adlink = "<a href=\"$link\">" . JText::_ ( 'POST' ) . "</a>";
			}
			
			$document->setTitle ( $row->title );
			if (! empty ( $row->tags )) {
				$document->setMetadata ( 'keywords', strip_tags ( html_entity_decode ( $row->tags ) ) );
			} else {
				$document->setMetadata ( 'keywords', strip_tags ( html_entity_decode ( $row->title ) ) );
			}
			
			if ($params->get ( 'enable_field_tags', 0 )) {
				
				$tagcontent = array ();
				$tagtext = "<div class=\"tags\"><strong>" . JText::_ ( 'TAGS' ) . ":</strong> ";
				$tags = preg_split ( "/[\s,]+/", $row->tags );
				$tags = array_filter ( $tags );
				if (is_array ( $tags ) && count ( $tags ) > 0) {
					foreach ( $tags as $t ) {
						if (! empty ( $t )) {
							$taglink = JRoute::_ ( "index.php?option=$option&task=ads.search&q=$t&Itemid=$listitemid" );
							$tagcontent [] = "<a href=\"$taglink\">" . $t . "</a> ";
						}
					}
					$tagtext .= implode ( ", ", $tagcontent );
				}
				$tagtext .= "</div>";
				
				if (is_array ( $tags ) && count ( $tags ) > 0) {
					$row->tags = $tagtext;
				} else {
					$row->tags = "";
				}
			} else {
				$row->tags = "";
			}
			
			if (is_object ( $row->aduser )) {
				$row->aduser->profilelink = "<a href=" . $row->aduser->profilelink . ">" . $row->aduser->name . "</a>";
			
			}
			
			$this->assignRef ( 'row', $row );
			$this->setLayout ( 'mainpage' );
			
			if (! empty ( $row->metadesc )) {
				$document->setDescription ( strip_tags ( $row->metadesc ) );
			} else {
				$introtext_length = $params->get ( 'listing_introtext_length' );
				$desc = GHelper::trunchtml ( trim ( strip_tags ( $row->description ) ), $introtext_length );
				$document->setDescription ( strip_tags ( $desc ) );
			}
			
			if($user->guest)
			{
				$user = JFactory::getUser($row->user_id);
			}
			GApplication::triggerEvent ( 'onLoadProfile', array ($user, &$params ) );
			
			switch ($params->get ( 'posting_scheme', 0 )) {
				
				case 2 :	
					
					if(isset($user->package) && is_object($user->package))
					{
					
						$conf = new JParameter ( $user->package->params );
						$package_showcontact = ( int )$conf->get('show_contact',0);
					}
					else
					{	
						$package_showcontact = (int)$params->get ( 'show_contact_information', 0 );
					}							
					$showcontact = $package_showcontact ? (int)$row->show_contact : $package_showcontact;
					break;
				
				case 0 :
				case 1 :
				default :
					$showcontact = ( int ) $params->get ( 'show_contact_information', 0 ) ? (int)$row->show_contact : ( int ) $params->get ( 'show_contact_information', 0 );
					break;
			
			}
			JFilterOutput::objectHTMLSafe ( $showcontact );
			$this->assignRef ( 'showcontact', $showcontact );
			
			parent::display ( $tpl );
			GApplication::triggerEvent ( 'onAfterAdDisplay', array (&$row, &$params ) );
		
		}
	
	}
}
?>
