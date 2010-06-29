<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: profile.php 2010-01-10 00:57:37 svn $
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

class ListbingoModelProfile extends GModel {
	function __construct() {
		parent::__construct ();
	}
	
	function getList($published = false, $filter = array()) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_profile $pubcond $orderby";
		$db->setQuery ( $query, $filter->limitstart, $filter->limit );
		return $db->loadObjectList ();
	}
	
	function getListCount($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) from #__gbl_profile $pubcond";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		$table = & JTable::getInstance ( 'profile' );
		
		return $table->publish ( $cid, $publish );
	
	}
	
	function load($id) {
		$table = JTable::getInstance ( "profile" );
		$table->load ( $id );
		return $table;
	
	}
	
	function loadProfile($userid = null, $filter = null) {
		
		$db = JFactory::getDBO ();
		
		$query = "SELECT p.*, u.name, u.email, u.registerDate, r.title as rtitle, c.title as ctitle,
		(SELECT count(*) FROM #__gbl_ads WHERE user_id=$userid) as totalpost
		FROM #__users as u
		LEFT JOIN #__gbl_profile as p ON (u.id=p.user_id) 
		LEFT JOIN #__gbl_countries as c on c.id=p.country_id
		LEFT JOIN #__gbl_regions as r on r.id=p.region_id
		WHERE u.id=$userid";
		$db->setQuery ( $query );
		$result = $db->loadObject ();
		
		return $result;
	
	}
	
	function getUserProfile($uid,$params=null) {
		
		$db = JFactory::getDBO ();
		
		$user = JFactory::getUser ( $uid );		
		
		$query = "SELECT p.*, r.title as rtitle, c.title as ctitle,
		(SELECT count(*) FROM #__gbl_ads WHERE user_id=$uid) as totalpost
		FROM #__gbl_profile as p 
		LEFT JOIN #__gbl_countries as c on c.id=p.country_id
		LEFT JOIN #__gbl_regions as r on r.id=p.region_id
		WHERE p.user_id=$uid";
		$db->setQuery ( $query );
		$user->profile = $db->loadObject ();
		
		GApplication::triggerEvent ( 'onLoadProfile', array (&$user, &$params ) );
		
		return $user;
	
	}
	
	/**
	 * Get Only Profile
	 * @param $userid
	 * @return unknown_type
	 */
	
	function getProfile($userid = 0, $params = array()) {
		$profilebingo = $this->doesProfilebingoExist ();
		
		if ($params->get ( 'enable_profilebingo' ) && $profilebingo > 0) {
			$db = JFactory::getDBO ();
			
			$query = "SELECT p.*,u.id as user_id, u.name, u.username, u.email as uemail, u.registerDate
		FROM #__users as u
		LEFT JOIN #__gbp_profiles as p ON (u.id=p.user_id) 
		WHERE u.id=$userid";
			$db->setQuery ( $query );
			$rows = $db->loadObject ();
		
		} else {
			$rows = $this->loadProfile ( $userid );
		}
		
		$result->user = GApplication::triggerEvent ( 'onLoadProfile', array (&$userid ) );
		return $rows;
	}
	
	function save($post = null, $file = null, $params = null) {
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "profile" );
		
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ();
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		

		
		if (! $row->store ( $file, $params )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		
		$db = JFactory::getDBO ();
		$query = "UPDATE jos_users set name='" . $post ['name'] . "', email='" . $post ['email'] . "' WHERE id='" . $post ['user_id'] . "'";
		$db->setQuery ( $query );
		
		if ($db->query ()) {
			return true;
		}
		
		return $row->id;
	}
	
	function remove($cid = array()) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_profile where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'profile' );
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
		$row = & JTable::getInstance ( 'profile' );
		$row->load ( $id );
		
		return $row->move ( $dir, '' );
	
	}
	
	function doesProfilebingoExist() {
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) FROM #__components WHERE `option`='com_profilebingo' AND parent=0 AND published=1";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function setUserLocation($userpreferences = "", $userid = 0) {
		$db = JFactory::getDBO ();
		$query = "UPDATE #__gbl_profile SET preferences='$userpreferences' WHERE user_id=$userid";
		$db->setQuery ( $query );
		$db->query ();
	}
	
	function getSlug($id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "SELECT username FROM #__users WHERE id=$id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getId($name = '') {
		$db = JFactory::getDBO ();
		
		$query = "SELECT id FROM #__users WHERE username='$name'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}

}
?>