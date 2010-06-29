<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: region.php 2010-01-10 00:57:37 svn $
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

class ListbingoModelRegion extends GModel {
	var $_count = 0;
	
	var $_pagination = null;
	
	function __construct() {
		parent::__construct ();
	}
	
	function getList($published = false, $filter = array(), $cid = 0) {
		
		static $items;
		
		if (isset ( $items )) {
			return $items;
		}
		
		$db = JFactory::getDBO ();
		
		$cond = array ();
		$where = "";
		if (isset ( $filter->published ) && $filter->published != "") {
			$where = " WHERE  c.published=" . $filter->published;
		}
		
		// just in case filter_order get's messed up
		if ($filter->order) {
			$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', c.parent_id, c.ordering';
		} else {
			$orderby = ' ORDER BY c.parent_id, c.ordering';
		}
		
		// select the records
		// note, since this is a tree we have to do the limits code-side
		if ($filter->keyword) {
			$query = 'SELECT c.id' . ' FROM #__gbl_regions AS c' . ' WHERE LOWER( c.title ) LIKE ' . $db->Quote ( '%' . $db->getEscaped ( $filter->keyword, true ) . '%', false ) . $where;
			$db->setQuery ( $query );
			$search_rows = $db->loadResultArray ();
		}
		
		$query = "SELECT c.*,c.title as name,c.parent_id as parent,IFNULL(ct.title,'Not Assigned') as country
		FROM #__gbl_regions as c
		LEFT JOIN #__gbl_countries as ct on ct.id=c.country_id" . $where . " " . $orderby;
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		// establish the hierarchy of the region
		$children = array ();
		// first pass - collect children
		foreach ( $rows as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		
		// second pass - get an indent list of the items
		//$list = JHTML::_('menu.treerecurse', 0, '', array(), $children,5 );
		

		$list = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, max ( 0, $filter->levellimit - 1 ) );
		
		// eventually only pick out the searched items.
		if ($filter->keyword) {
			$list1 = array ();
			
			foreach ( $search_rows as $sid ) {
				foreach ( $list as $item ) {
					if ($item->id == $sid) {
						$list1 [] = $item;
					}
				}
			}
			// replace full list with found items
			$list = $list1;
		}
		
		$total = count ( $list );
		$this->_count = $total;
		
		jimport ( 'joomla.html.pagination' );
		$this->_pagination = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		// slice out elements based on limits
		$list = array_slice ( $list, $this->_pagination->limitstart, $this->_pagination->limit );
		$items = $list;
		return $items;
	
	}
	
	function getListCount($published = false) {
		/*$pubcond = "";
		 if ($published)
		 {
			$pubcond = " where published='1'";
			}

			$db = JFactory::getDBO();
			$query = "SELECT count(*) from #__gbl_regions $pubcond";
			$db->setQuery($query);
			return $db->loadResult();*/
		return $this->_count;
	}
	
	function &getPagination() {
		if ($this->_pagination == null) {
			$this->getItems ();
		}
		
		return $this->_pagination;
	}
	
	function getListForSelect($published = false, $id = 0, $rootonly = true, $cid = 0) {
		$cond = array ();
		$pubcond = "";
		if ($published) {
			$cond [] = " published='1'";
		}
		
		if ($cid) {
			$cond [] = " country_id=$cid";
		
		}
		
		if (count ( $cond ) > 0) {
			$pubcond = "and " . implode ( " AND ", $cond );
		}
		$orderby = ' ORDER BY  ordering';
		$rootcond = "";
		if ($rootonly) {
			$rootcond = " and parent_id=0";
		}
		
		$db = JFactory::getDBO ();
		
		$query = "SELECT id as value, title as text from #__gbl_regions where id !=$id $pubcond $rootcond $orderby";
		$db->setQuery ( $query );
		return $db->loadAssocList ();
	
	}
	
	function getTreeForSelect($published = false, $cid = 0) {
		$cond = array ();
		$pubcond = "";
		if ($published) {
			$cond [] = " c.published='1'";
		}
		
		if ($cid) {
			$cond [] = " c.country_id=$cid";
		
		}
		
		if (count ( $cond ) > 0) {
			$pubcond = "where " . implode ( " AND ", $cond );
		}
		$orderby = ' ORDER BY c.parent_id asc,c.ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT c.*, c.id as value,c.title as name,c.parent_id as parent from #__gbl_regions as c
	
		$pubcond $orderby";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		;
		
		$children = array ();
		// first pass - collect children
		foreach ( $rows as $v ) {
			$pt = $v->parent_id;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		// second pass - get an indent list of the items
		$list = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, 2 );
		$newlist = array ();
		foreach ( $list as $item ) {
			
			$newlist [] = $item;
		
		}
		
		return $newlist;
	
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		$table = & JTable::getInstance ( 'region' );
		
		return $table->publish ( $cid, $publish );
	
	}
	
	function load($id) {
		$table = JTable::getInstance ( "region" );
		$table->load ( $id );
		return $table;
	
	}
	
	function save($post = null) {
		
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "region" );
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ( 'parent_id=' . $row->parent_id );
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ( $post )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		
		$cmodel = gbimport ( "listbingo.model.country" );
		$cmodel->makeDefault ( $row->country_id );
		
		return true;
	
	}
	
	function remove($cid = array()) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_regions where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'region' );
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
		$row = & JTable::getInstance ( 'region' );
		$row->load ( $id );
		
		return $row->move ( $dir, 'parent_id=' . $row->parent_id );
	
	}
	
	function getRegionTree($id = 0) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_regions where id='$id'";
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		if ($obj && $obj->parent_id != 0) {
			$query = "SELECT * from #__gbl_regions where id='$obj->parent_id'";
			$db->setQuery ( $query );
			$obj->parent = $db->loadObject ();
		}
		
		return $obj;
	}
	
	function getParentRegions($cid = 0) {
		$cond = array ();
		$condition = "";
		if ($cid > 0) {
			$cond [] = "country_id=$cid";
		}
		$cond [] = " published=1";
		$cond [] = " parent_id=0";
		if (count ( $cond ) > 0) {
			
			$condition = " where " . implode ( " AND ", $cond );
		}
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_regions $condition";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _getChildRegions($parent = 0) {
		
		$db = &JFactory::getDBO ();
		$query = "SELECT * from #__gbl_regions where parent_id=$parent and published='1'";
		
		$db->setQuery ( $query );
		$rows = $db->loadObjectlist ();
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				$r->children = self::_getChildRegions ( $r->id );
			}
			return $rows;
		} else {
			return;
		}
	}
	
	function getRegionsWithChild($cid = 0, $rid = 0) {
		$cond = array ();
		$condition = "";
		if ($cid > 0) {
			$cond [] = "country_id=$cid";
		}
		$cond [] = " published=1";
		$cond [] = " parent_id=0";
		if (count ( $cond ) > 0) {
			
			$condition = " where " . implode ( " AND ", $cond );
		}
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_regions $condition order by ordering,parent_id";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				$r->children = self::_getChildRegions ( $r->id );
			}
		}
		
		return $rows;
	}
	
	function getDefaultRegion() {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_regions where default_region='1'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getCurrentRegion(&$params = null) {
		
		global $option;
		$mainframe = JFactory::getApplication ();
		
		if (is_null ( $params )) {
			return - 1;
		}
		
		if ($params->get ( 'region_selection' )) {
			$countrystate = $mainframe->getUserState ( $option . 'country' );
			$regionstate = $mainframe->getUserState ( $option . 'region' );
			
			if ($regionstate > 0) {
				
				return $regionstate;
			}
			
			if ($params->get ( 'force_region_selection', 0 )) {
				
				$db = JFactory::getDBO ();
				
				$cond = array ();
				$cond [] = "published=1";
				if ($countrystate > 0) {
					$cond [] = "country_id=$countrystate";
				}
				
				$condition = "";
				
				if (count ( $cond )) {
					$condition = " WHERE " . implode ( " AND ", $cond );
				}
				
				$query = "SELECT count(*) FROM #__gbl_regions $condition";
				$db->setQuery ( $query );
				$rows = $db->loadResult ();
				
				if (isset ( $rows ) && $rows > 0) {
					return 0;
				} else {
					return - 1;
				}
			
			} else {
				$regionobj = self::getDefaultRegion ();
				
				if ($regionobj) {
					
					$mainframe->setUserState ( $option . 'regiontitle', $regionobj->title );
					
					$mainframe->setUserState ( $option . 'region', $regionobj->id );
					return $regionobj->id;
				} else {
					return - 1;
				}
			
			}
		} else {
			$regionobj = self::getDefaultRegion ();
			
			if ($regionobj) {
				
				$mainframe->setUserState ( $option . 'regiontitle', $regionobj->title );
				
				$mainframe->setUserState ( $option . 'region', $regionobj->id );
				return $regionobj->id;
			} else {
				return - 1;
			}
		}
	
	}
	
	function getRegionTitle(&$params = null) {
		global $option;
		if (is_null ( $params )) {
			return false;
		}
		
		$mainframe = JFactory::getApplication ();
		
		$countrystate = $mainframe->getUserState ( $option . 'country' );
		
		$regionstate = $mainframe->getUserState ( $option . 'region' );
		
		$cond = "";
		if ($countrystate) {
			$cond = " AND country_id=$countrystate";
		}
		
		$query = "SELECT * from #__gbl_regions where id='$regionstate' $cond";
		
		$db = JFactory::getDBO ();
		
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		if ($obj) {
			
			$mainframe->setUserState ( $option . 'regiontitle', $obj->title );
			return $obj->title;
		} else {
			
			$mainframe->setUserState ( $option . 'regiontitle', JText::_ ( "All" ) );
			return JText::_ ( "All Regions" );
		}
	}
	
	function findAndSetRegion(&$title = null, $setregion = true) {
		global $option;
		
		$wordstring = "in,of,over,on,near," . JText::_ ( "SEARCH_IN" );
		$conjunction = strtolower ( "AND,OR,+," . JText::_ ( "SEARCH_CONJ" ) );
		$filterwords = explode ( ",", $wordstring );
		
		$returntext = "";
		$found = false;
		$filterkey = '';
		foreach ( $filterwords as $key => $search_needle ) {
			
			if (stristr ( $title, $search_needle ) != FALSE) {
				
				$found = true;
				$filterkey = trim ( $search_needle );
			
			}
		}
		/*if (! $found) {
			return false;
		}*/
		
		$textarray = explode ( " $filterkey ", $title );
		$region = "";
		
		if (count ( $textarray ) > 0) {
			$region = strtolower ( array_pop ( $textarray ) );
		
		}
		$regiontext = array_shift ( $textarray );
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
		
		/*	$titles=explode(" ",$title);

		$title=implode(" ",$titles);
		*/
		$db = JFactory::getDBO ();
		
		//$words = explode ( ' ', $title );
		$wheres = array ();
		$cond = array ();
		$condition = "";
		
		foreach ( $words as $word ) {
			$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
			
			$wheres [] = 'r.title LIKE ' . $word;
			$wheres [] = 'r.alias LIKE ' . $word;
		
		}
		
		if (count ( $wheres ) > 0) {
			$cond [] = '((' . implode ( ') OR (', $wheres ) . '))';
		}
		
		$cond [] = " r.published='1'";
		
		if (count ( $cond ) > 0) {
			$condition = " where " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT r.id as rid,r.*,c.id as cid from #__gbl_regions as r
		left join #__gbl_countries as c on c.id=r.country_id  $condition";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		$regionobj = new stdClass ();
		$rid = array ();
		
		if (count ( $rows ) > 0) {
			
			foreach ( $rows as $r ) {
				$rid [] = $r->rid;
				
				if ($setregion) {
					$mainframe->setUserState ( $option . 'region', $r->rid );
					$mainframe->setUserState ( $option . 'country', $r->cid );
				}
				array_push ( $filterwords, strtolower ( trim ( $r->title ) ) );
			
			}
			
			rsort ( $filterwords );
			
			/*	
			 $regionobj->text = trim ( str_replace ( $filterwords, "", strtolower ( $title ) ) );
			 $regionobj->text = trim ( str_replace ( $conjunctions, "", strtolower ( $regionobj->text ) ) );*/
			$regionobj->text = $regiontext;
			$regionobj->title = $region;
			
			$regionobj->rid = $rid;
			
			return $regionobj;
		
		} else {
			return false;
		}
	
	}
	
	/*
	 * 
	 * Unused
	 * 
	function findAndSetRegion(&$title = null) {
		global $option;
		
		
		
		
		$wordstring = " a, an, the, in, of, under, below, above, over, on, as, to, be, any";
		$filterwords = explode ( ",", $wordstring );
		
		$title = str_replace ( $filterwords, "", $title );
		
		$mainframe = JFactory::getApplication ();
		if (is_null ( $title )) {
			return false;
		}
		
		if (empty ( $title )) {
			return false;
		}
		
		//	$titles=explode(" ",$title);

		//$title=implode(" ",$titles);
		
		$db = JFactory::getDBO ();
		
		$words = explode ( ' ', $title );
		$wheres = array ();
		$cond = array ();
		$condition = "";
		
		foreach ( $words as $word ) {
			$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
			
			$wheres [] = 'r.title LIKE ' . $word;
		
		}
		
		if (count ( $wheres ) > 0) {
			$cond [] = '(' . implode ( ') OR (', $wheres ) . ')';
		}
		
		$cond [] = " r.published='1'";
		
		if (count ( $cond ) > 0) {
			$condition = " where " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT r.id as rid,r.*,c.id as cid from #__gbl_regions as r
		left join #__gbl_countries as c on c.id=r.country_id  $condition limit 1";
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		
		if ($obj) {
			
			$mainframe->setUserState ( $option . 'region', $obj->rid );
			$mainframe->setUserState ( $option . 'country', $obj->cid );
			array_push ( $filterwords, strtolower ( $obj->title ) );
			
			$obj->text = trim ( str_replace ( $filterwords, "", strtolower ( $title ) ) );
			
			return $obj;
		} else {
			return false;
		}
	
	}*/
	
	function getSubRegion($id = 0, $published = true) {
		$cond = array ();
		
		$cond [] = " parent_id=$id";
		
		$cond [] = " published='1'";
		
		if (count ( $cond ) > 0) {
			$condition = " where " . implode ( " AND ", $cond );
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT id from #__gbl_regions $condition";
		$db->setQuery ( $query );
		$results = $db->loadResultArray ();
		
		if (count ( $results ) > 0) {
			foreach ( $results as $r ) {
				$results = array_merge ( $results, self::getSubRegion ( $r ) );
			}
		}
		return $results;
	}
	
	function getSlug($id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "SELECT title, alias FROM #__gbl_regions WHERE id=$id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getId($name = '') {
		$db = JFactory::getDBO ();
		$query = "SELECT id FROM #__gbl_regions WHERE title='$name'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function makeDefault($id) {
		$db = JFactory::getDBO ();
		$query = "UPDATE #__gbl_regions set default_region=0";
		$db = JFactory::getDBO ();
		$db->setQuery ( $query );
		
		if ($db->query ()) {
			$table = JTable::getInstance ( 'region' );
			$table->id = $id;
			$table->default_region = 1;
			$table->published = 1;
			if ($table->store ()) {
				$row = self::load ( $id );
				
				$cmodel = gbimport ( "listbingo.model.country" );
				$cmodel->makeDefault ( $row->country_id );
				return true;
			}
		} else {
			throw new DataException ( JText::_ ( "NO_DEFAULT_REGION" ), 501 );
		}
	
	}

}

?>