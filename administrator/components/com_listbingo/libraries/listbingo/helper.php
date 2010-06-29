<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: helper.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from GOBINGOO.
 *
 * code Bruce
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

/**
 * listbingo Helper
 *
 * @package Joomla
 * @subpackage LISTBINGO
 * @since 1.5
 */

jimport ( "joomla.utilities.date" );

gbimport ( "gobingoo.helper" );
class ListbingoHelper extends GHelper {
	function getGlobalAdId($title = '', $params) {
		return $params->get ( 'global_prefix' ) . rand ( 1, 9999999 );
	}

	function status(&$row, $i = 0) {

		global $option;
		switch (( int ) $row->status) {

			case 1 :
				$img = "published.gif";
				$alt = "Published";
				break;
					
			case 2 :
				$img = "suspended.gif";
				$alt = "Suspended";
				break;
					
			case 0 :
				$img = "unpublished.gif";
				$alt = "Unpublished";
				break;
					
			case 3 :
				$img = "closed.gif";
				$alt = "closed";
				break;
			default :
			case 4 :
				$img = "archived.gif";
				$alt = "Archived";
				break;
		}
		$baseurl = JUri::root () . "/administrator/components/$option/images/";
		$href = '<img src="' . $baseurl . $img . '" border="0" alt="' . $alt . '" />';

		return $href;
	}

	function getSearchUrl($filter) {
		$uri = JFactory::getURI ();
		$xuri = clone ($uri);
		$task = JRequest::getCmd ( 'task' );
		$xuri->setVar ( 'task', $task );
		$xuri->setVar ( 'order', $filter );
		return $xuri->getQuery ();

	}

	function getTaskSearchUrl($task) {
		$uri = JFactory::getURI ();
		$xuri = clone ($uri);

		$xuri->setVar ( 'task', $task );
		return $xuri->getQuery ();
	}

	function getItemid($url = "",$strict=true,$base=false) {
		$db = JFactory::getDBO();
		if($strict)
		{
			$query = "SELECT id FROM #__menu WHERE link = '$url' AND published = 1";
		}
		else
		{
			$query = "SELECT id FROM #__menu WHERE link LIKE '%$url%' AND published = 1";
		}

		$db->setQuery ( $query );
		$Itemid = $db->loadResult ();

		if ($Itemid < 1) {
			if($base)
			{
				$query="SELECT id FROM #__menu WHERE link LIKE '%index.php?option=com_listbingo%' AND published = 1";
				$db->setQuery ( $query );
				$Itemid = $db->loadResult ();
			}
			else
			{
				$Itemid = 0;
			}
		}

		return $Itemid;
	}

	function bakeCountryBreadcrumb() {
		global $mainframe, $option;

		$configmodel = gbimport ( "listbingo.model.configuration" );

		$params = $configmodel->getParams ();
		$pathway = & $mainframe->getPathway ();

		if ($params->get ( 'country_selection' ))
		{
			if ($params->get ( 'enable_country_breadcrumb' ))
			{
				$id = JRequest::getInt ( 'adid', 0 );
				$admodel = gbimport ( "listbingo.model.ad" );
				$countrymodel = gbimport ( "listbingo.model.country" );
				if ($id)
				{
					$row = $admodel->load ( $id );

					$country = $countrymodel->load ( $row->country_id );

					if ($country->title!="")
					{
						$pathway->addItem ( $country->title, '' );
					}
				}
				else
				{
					$country = $countrymodel->getCountryTitle ( $params );

					if ($country)
					{
						$pathway->addItem ( $country, '' );
					}
				}
			}
		}

		return $pathway;
	}

	function bakeRegionBreadcrumb()
	{
		global $mainframe, $option;

		$configmodel = gbimport ( "listbingo.model.configuration" );

		$params = $configmodel->getParams ();
		$pathway = & $mainframe->getPathway ();

		if ($this->params->get ( 'region_selection' ))
		{
			if ($params->get ( 'enable_region_breadcrumb' ))
			{
				$id = JRequest::getInt ( 'adid', 0 );
				$admodel = gbimport ( "listbingo.model.ad" );
				$regionmodel = gbimport ( "listbingo.model.region" );
				if ($id)
				{
					$row = $admodel->load ( $id );

					$region = $regionmodel->load ( $row->region_id );

					if ($region->title!="")
					{
						$pathway->addItem ( $region->title, '' );
					}
				}
				else
				{
					$region = $regionmodel->getRegionTitle ( $params );

					if ($region)
					{
						$pathway->addItem ( $region, '' );
					}
				}
			}
		}
		return $pathway;
	}

	function bakeCategoryBreadcrumb() {
		global $mainframe, $option;

		$configmodel = gbimport ( "listbingo.model.configuration" );

		$params = $configmodel->getParams ();

		$pathway = & $mainframe->getPathway ();

		if ($params->get ( 'enable_category_breadcrumb' )) {
			$model = gbimport ( "listbingo.model.ad" );
			$catmodel = gbimport ( "listbingo.model.category" );

			$id = JRequest::getInt ( 'adid', 0 );

			if ($id) {
				$row = $model->loadWithFields ( $id, true );
				$catid = $row->category_id;
			} else {
				$catid = JRequest::getInt ( 'catid', 0 );
			}

			$item = array_reverse ( $catmodel->_getParents ( $catid ) );

			$breadcrumb = array ();
			foreach ( $item as $b ) {
				$pathway->addItem ( $b->title, JRoute::_ ( "index.php?option&option=$option&task=categories.select&catid=" . $b->id, false ) );
			}

			if ($id) {
				$pathway->addItem ( $row->title, JRoute::_ ( "index.php?option=$option&task=ads.view&adid=" . $row->id, false ) );
			}
		}

		return $pathway;

	}

	/*
	 * function to calculate script execution time
	 *
	 * @Example of usage:
	 *
	 * $start = microtime_float();
	 *
	 * php,mysql script goes here
	 *
	 * $end = microtime_float();
	 *
	 * echo 'Script Execution Time: ' . round($end - $start, 3) . ' seconds';
	 *
	 */

	function microtime_float() {
		list ( $msec, $sec ) = explode ( ' ', microtime () );
		$microtime = ( float ) $msec + ( float ) $sec;
		return $microtime;
	}

	/**
	 * Returns the relative date / time that the date occurred from with
	 * respect to right now.
	 * parameter format.
	 * @param $date string Y-m-d H:i:s date
	 */
	function getDate($date, $format = null, $humanize = true) {
		$lang = &JFactory::getLanguage ();
		$lang->load ( 'com_listbingo' );

		$db = JFactory::getDBO ();
		if ($date != $db->getNullDate ()) {

			if ($humanize) {

				$time = strtotime ( gmdate ( 'Y-m-d H:i:s' ) ) - strtotime ( $date );
				$minutes = ( int ) ($time / 60);
				$hours = ( int ) ($minutes / 60);
				$days = ( int ) ($hours / 24);

				if ($days == 0) {
					if ($hours == 0) {
						if ($minutes == 0) {
							return JText::sprintf ( 'SECONDS AGO X1', $time );
						}

						if ($minutes == 1) {
							return JText::_ ( 'MINUTE AGO' );
						}

						return JText::sprintf ( 'MINUTES AGO X1', $minutes );
					}

					if ($hours == 1) {
						return JText::_ ( 'HOUR AGO' );
					}

					return JText::sprintf ( 'HOURS AGO X1', $hours );
				}

				if ($days == 1) {
					return JText::_ ( 'YESTERDAY' );
				}

				if ($days <= 30) {
					return JText::sprintf ( 'DAYS AGO X1', $days );
				}
			}



			$addate = new JDate ( $date );

			return $addate->toFormat ( $format );
		} else {
			return "---";
		}

	} //end getDate


	function isGCartAvailable($params = null, &$cart = null) {
		if (is_null ( $params )) {
			return false;
		}

		$cartbingopath = JPATH_ROOT . DS . "administrator" . DS . "components" . DS . "com_cartbingo";
		if ($params->get ( 'enable_cartbingo', 0 ) && is_dir ( $cartbingopath )) {

			$cart->cartlink = JRoute::_ ( "index.php?option=com_cartbingo&task=cart.view", false );
			return true;
		} else {
			$cartaddonpath = JPATH_ROOT . DS . "administrator" . DS . "components" . DS . "com_listbingo" . DS . "addons" . DS . "cart";
			$db = JFactory::getDBO ();
			$query = "SELECT * from #__gbl_addons where folder='cart' and element='cart' and published=1";
			$db->setQuery ( $query );
			$obj = $db->loadObject ();
			if (is_dir ( $cartaddonpath ) && $obj) {
				$cart->cartlink = JRoute::_ ( "index.php?option=com_listbingo&task=addons.cart.front.view", false );
				return true;
			} else {
				return false;
			}

		}

		return false;

	}
	
	
	function setErrorLevel($params)
	{
		$params->get('error_level',0);
		if($params->get('error_level',0))
		{
			error_reporting(0);
		}
		
	}

}
?>
