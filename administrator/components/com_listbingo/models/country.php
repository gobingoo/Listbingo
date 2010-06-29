<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: country.php 2010-01-10 00:57:37 svn $
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
gbimport ( "gobingoo.model" );

class ListbingoModelCountry extends GModel {
	var $_count = 0;
	
	function __construct() {
		parent::__construct ();
	}
	
	function getCountryLists($published = false, $filter = array()) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_countries $pubcond $orderby";
		$db->setQuery ( $query, $filter->limitstart, $filter->limit );
		return $db->loadObjectList ();
	}
	
	function getCountryListsCount($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) from #__gbl_countries $pubcond";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getList($published = false, $filter = array()) {
		$cond = array ();
		
		/*		if ($published)
		 {
			$cond[] = " published='1'";
			}*/
		
		if (isset ( $filter->keyword )) {
			$cond [] = " title LIKE '%$filter->keyword%'";
		}
		
		if (isset ( $filter->published ) && $filter->published != "") {
			$cond [] = " published=" . $filter->published;
		}
		
		$where = "";
		if (count ( $cond ) > 0) {
			$where = " WHERE " . implode ( "AND", $cond );
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', default_country, ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_countries $where $orderby";
		$rows = $this->_getList ( $query, $filter->limitstart, $filter->limit );
		
		$this->_count = $this->_getListCount ( $query );
		
		return $rows;
	
	}
	
	function getListCount($published = false) {
		return $this->_count;
	}
	
	function getListForSelect($published = false, $val = 'id', $text = 'title') {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$orderby = ' ORDER BY  ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT $val as value, $text as text from #__gbl_countries $pubcond $orderby";
		$db->setQuery ( $query );
		return $db->loadAssocList ();
	
	}
	
	function hasValidCurrencyList($published = false) {
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$pubcond = "";
		$cond = array ();
		if ($published) {
			$cond [] = "published='1'";
		}
		$cond [] = " currency_symbol!=''";
		$cond [] = " currency!=''";
		
		if (count ( $cond ) > 0) {
			$pubcond = " WHERE " . implode ( " AND ", $cond );
		}
		
		$orderby = ' ORDER BY  ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) from #__gbl_countries $pubcond $orderby";
		$db->setQuery ( $query );
		
		return $db->loadResult ();
	
	}
	
	function getCurrencyListForSelect($published = false) {
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$pubcond = "";
		$cond = array ();
		if ($published) {
			$cond [] = "published='1'";
		}
		$cond [] = " currency_symbol!=''";
		$cond [] = " currency!=''";
		
		if (count ( $cond ) > 0) {
			$pubcond = " WHERE " . implode ( " AND ", $cond );
		}
		
		$orderby = ' ORDER BY  ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT DISTINCT concat(currency_symbol,':',currency) as value, currency as text from #__gbl_countries $pubcond $orderby";
		$db->setQuery ( $query );
		$rows = $db->loadAssocList ();
		
		if (isset ( $rows ) && count ( $rows ) > 0) {
			$result = $rows;
		} else {
			$curr = $params->get ( 'default_currency', '$:USD' );
			$excurr = explode ( ":", $curr );
			
			$result = array ();
			if (count ( $excurr ) > 1) {
				$result [0] ['value'] = $curr;
				$result [0] ['text'] = $excurr [1];
			}
		}
		
		//var_dump($result);exit;
		return $result;
	
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		$table = & JTable::getInstance ( 'country' );
		
		return $table->publish ( $cid, $publish );
	
	}
	
	function load($id) {
		$table = JTable::getInstance ( "country" );
		$table->load ( $id );
		return $table;
	
	}
	
	function save($post = null) {
		
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "country" );
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ();
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ( $post )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
	}
	
	function remove($cid = array()) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_countries where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'country' );
		$groupings = array ();
		
		// update ordering values
		for($i = 0; $i < $total; $i ++) {
			$row->load ( ( int ) $cid [$i] );
			// track categories
			

			if ($row->ordering != $order [$i]) {
				$row->ordering = $order [$i];
				if (! $row->store ()) {
					throw new DataException ( JText::_ ( "NO_ORDER_SAVE" ), 500 );
				}
			}
		}
	
	}
	
	function order($task, $id) {
		if ($task == 'orderup') {
			
			$dir = - 1;
		} else {
			$dir = 1;
		}
		$row = & JTable::getInstance ( 'country' );
		$row->load ( $id );
		
		return $row->move ( $dir, '' );
	
	}
	
	function makeDefault($id) {
		
		$db = JFactory::getDBO ();
		$query = "UPDATE #__gbl_countries set default_country=0";
		$db = JFactory::getDBO ();
		$db->setQuery ( $query );
		
		if ($db->query ()) {
			$table = JTable::getInstance ( 'country' );
			$table->id = $id;
			$table->default_country = 1;
			$table->published = 1;
			$table->store ();
			return true;
		} else {
			throw new DataException ( JText::_ ( "NO_DEFAULT_COUNTRY" ), 502 );
		}
	
	}
	
	function getDefaultCountry() {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_countries where default_country='1' AND published='1'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getCurrentCountry(&$params = null) {
		
		global $option;
		$mainframe = JFactory::getApplication ();
		
		if (is_null ( $params )) {
			return - 1;
		}
		
		if ($params->get ( 'country_selection' )) {
			
			$countrystate = $mainframe->getUserState ( $option . 'country' );
			
			if ($countrystate > 0) {
				return $countrystate;
			}
			
			if ($params->get ( 'force_country_selection', 0 )) {
				$db = JFactory::getDBO ();
				
				$query = "SELECT count(*) FROM #__gbl_countries WHERE published='1'";
				$db->setQuery ( $query );
				$rows = $db->loadResult ();
				
				if (isset ( $rows ) && $rows > 0) {
					return 0;
				} else {
					return - 1;
				}
			
			} else {
				$countryobj = self::getDefaultCountry ();
				
				if ($countryobj) {
					
					$mainframe->setUserState ( $option . 'countrytitle', $countryobj->title );
					
					$mainframe->setUserState ( $option . 'country', $countryobj->id );
					return $countryobj->id;
				} else {
					return - 1;
				}
			
			}
		} else {
			$countryobj = self::getDefaultCountry ();
			
			if ($countryobj) {
				
				$mainframe->setUserState ( $option . 'countrytitle', $countryobj->title );
				
				$mainframe->setUserState ( $option . 'country', $countryobj->id );
				return $countryobj->id;
			} else {
				return - 1;
			}
		}
	
	}
	
	function getCountryTitle(&$params = null) {
		global $option;
		if (is_null ( $params )) {
			return false;
		}
		
		$mainframe = JFactory::getApplication ();
		
		$countrystate = $mainframe->getUserState ( $option . 'country' );
		$query = "SELECT * from #__gbl_countries where id='$countrystate'";
		
		$db = JFactory::getDBO ();
		
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		if ($obj) {
			$mainframe->setUserState ( $option . 'countrytitle', $obj->title );
			return $obj->title;
		} else {
			$mainframe->setUserState ( $option . 'countrytitle', JText::_ ( "All" ) );
			return "All";
		}
	}
	
	function getSlug($id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "SELECT title, alias FROM #__gbl_countries WHERE id=$id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getId($name = '') {
		$db = JFactory::getDBO ();
		
		$query = "SELECT id FROM #__gbl_countries WHERE title='$name'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getCurrency($currency = '') {
		$currency = strtolower ( $currency );
		$db = JFactory::getDBO ();
		$query = "SELECT concat(currency_symbol,':',currency) concurrency from #__gbl_countries where lower(currency)='$currency'";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function findAndSetCountry(&$title = null, $setregion = true) {
		global $option;
		
		$wordstring = "in,of,over,on,near," . JText::_ ( "SEARCH_IN" );
		$conjunction = strtolower ( "AND,OR,+," . JText::_ ( "SEARCH_CONJ" ) );
		$filterwords = explode ( ",", $wordstring );
		
		$found = false;
		$countrytext = "";
		$filterkey = '';
		foreach ( $filterwords as $key => $search_needle ) {
			
			if (stristr ( $title, $search_needle ) != FALSE) {
				
				$found = true;
				$filterkey = trim ( $search_needle );
			
			}
		}
		
		$textarray = explode ( " $filterkey ", $title );
		$region = "";
		
		if (count ( $textarray ) > 0) {
			$region = strtolower ( array_pop ( $textarray ) );
		}
		$countrytext = array_shift ( $textarray );
		$conjunctions = explode ( ",", $conjunction );
		
		$words = array ();
		
		foreach ( $conjunctions as $conj ) {
			
			if (stristr ( $region, $conj ) != FALSE) {
				$conj = strtolower ( trim ( $conj ) );
				
				$xwords = explode ( " $conj ", $region );
				
				foreach ( $xwords as $w ) {
					if (! in_array ( $w, $words )) {
						array_push ( $words, $w );
					}
				}
			
			}
		}
		
		if (count ( $words ) < 1 && ! empty ( $region )) {
			array_push ( $words, $region );
		
		}
		
		$mainframe = JFactory::getApplication ();
		if (is_null ( $title )) {
			return false;
		}
		
		if (empty ( $title )) {
			return false;
		}
		
		$db = JFactory::getDBO ();
		
		$wheres = array ();
		$cond = array ();
		$condition = "";
		
		foreach ( $words as $word ) {
			$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
			
			$wheres [] = 'title LIKE ' . $word;
			$wheres [] = 'code LIKE ' . $word;
		
		}
		
		if (count ( $wheres ) > 0) {
			$cond [] = '(' . implode ( ') OR (', $wheres ) . ')';
		}
		
		$cond [] = " published='1'";
		
		if (count ( $cond ) > 0) {
			$condition = " where " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT id, title from #__gbl_countries $condition";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		$countryobj = new stdClass ();
		$rid = array ();
		$ctitle = array ();
		if (count ( $rows ) > 0) {
			
			foreach ( $rows as $r ) {
				$rid [] = $r->id;
				$ctitle [] = $r->title;
				
				if ($setregion) {
					$mainframe->setUserState ( $option . 'country', $r->id );
				}
				array_push ( $filterwords, strtolower ( trim ( $r->title ) ) );
			
			}
			rsort ( $filterwords );
			
			/*$countryobj->text = trim ( str_replace ( $filterwords, "", strtolower ( $title ) ) );
			$countryobj->text = trim ( str_replace ( $conjunctions, "", strtolower ( $countryobj->text ) ) );*/
			$countryobj->text = $countrytext;
			$countryobj->title = $region;
			
			$countryobj->cid = $rid;
			
			return $countryobj;
		
		} else {
			return false;
		}
	
	}

}
?>