<?php

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

class modLbCategoriesHelper {
	function getCategories(&$params) {
		$db = JFactory::getDBO ();
		
		$orderby = ' ORDER BY c.parent_id asc,c.ordering';
		$catid = JRequest::getInt ( 'catid', 0 );
		$db = JFactory::getDBO ();
		
		$user = JFactory::getUser ();
		$access = ( int ) $user->get ( 'aid', 0 );
		
		$query = "SELECT c.*,c.title as name,c.parent_id as parent, 0 as pcount FROM #__gbl_categories as c WHERE parent_id=0 AND c.published='1' AND c.access<=$access $orderby";
		
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		if (count ( $rows ) > 0) {
			$n = count ( $rows );
			for($i = 0; $i < $n; $i ++) {
				$r = $rows [$i];
				$query2 = "SELECT * FROM #__gbl_categories WHERE parent_id='" . $r->id . "' AND  access<=$access";
				$db->setQuery ( $query2 );
				$r->child = $db->loadObjectList ();
				
				$r->adcat = self::_getChildrens ( $r->id, $access );
				
				if (count ( $r->child ) > 0) {
					$m = count ( $r->child );
					
					for($j = 0; $j < $m; $j ++) {
						$a = $r->child [$j];
						$a->adcat2 = self::_getChildrens ( $a->id, $access );
					}
				}
			
			}
		
		}
		return $rows;
	
	}
	
	function _getChildrens($cid, $access = 0) {
		$childrens = array ();
		$childrens [] = $cid;
		if ($cid == 0) {
			return false;
		}
		$db = JFactory::getDBO ();
		$query = "SELECT id from #__gbl_categories where parent_id=$cid AND access<=$access";
		$db->setQuery ( $query );
		$rows = $db->loadResultArray ();
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				$childrens [] = $r;
				$childrens = array_merge ( $childrens, self::_getChildrens ( $r, $access ) );
			
			}
		}
		
		return $childrens;
	
	}
	
	function _countTotalProducts($filter) {
		
		$db = JFactory::getDBO ();
		
		$config = self::getConfiguration ();
		
		$country = self::getCurrentCountry ( $config );
		$region = self::getCurrentRegion ( $config );
		
		$user = JFactory::getUser ();
		$access = ( int ) $user->get ( 'aid', 0 );
		
		$pubcond = "";
		$cond = array ();
		
		$cond [] = " (a.expiry_date > NOW() || a.expiry_date='" . $db->getNullDate () . "')";
		
		$condition = "";
		if ($access) {
			$condition = " AND cat.access<=$access";
		}
		if($country>0)
		{
		$cond [] = "(a.country_id=" . $country . ")";
		}
		
		if ($region>0) {
			$regions = self::getSubRegion ( $region );
			array_push ( $regions, $region );
			$regions = implode ( ",", $regions );
			
			$cond [] = "(a.region_id IN (" . $regions . ") )";
		}
		if (count ( $cond ) > 0) {
			$pubcond = " AND " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT	cat.title, cat.id, " . "(" . "SELECT	count(*) " . "FROM	#__gbl_ads as a " . "WHERE	a.category_id = cat.id AND a.status=1 $pubcond" . ") AS adCount " . "FROM	#__gbl_categories as cat WHERE published=1 $condition";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	
	}
	
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
	
	function getCurrentCountry() {
		$mainframe = JFactory::getApplication ();
		return $mainframe->getUserState ( 'com_listbingocountry' );
	
	}
	
	function getCurrentRegion() {
		$mainframe = &JFactory::getApplication ();
		
		return $mainframe->getUserState ( "com_listbingoregion" );
	
	}
	
	function getConfiguration() {
		
		jimport ( 'joomla.filesystem.file' );
		$ini = JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . "com_listbingo" . DS . 'default.ini';
		$data = JFile::read ( $ini );
		
		// Load default configuration
		$xparams = new JParameter ( $data );
		
		$config = & JTable::getInstance ( 'component' );
		$config->loadByOption ( "com_listbingo" );
		
		// Bind the user saved configuration.
		$xparams->bind ( $config->params );
		return $xparams;
	}

}
