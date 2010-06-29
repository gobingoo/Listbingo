<?php
/**
 * Joomla! 1.5 component Listbingo
 *
 * @version $Id: link.php 2010-01-10 00:57:37 svn $
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
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.model");

class ListbingoModelLink extends GModel {
	function __construct() {
		parent::__construct();
	}

	function getList($published = false, $filter = array()) {
		$condition = "";
		$cond=array();
		if ($published) {
			$cond[]="published=1";
		}

		if(count($cond)>0)
		{
			$condition="where ".implode(" AND ", $cond);
		}

		$orderby = ' ORDER BY '.$filter->order.' '.$filter->order_dir.",ordering";

		$db = JFactory::getDBO();
		$query = "SELECT * from #__gbl_links 	$condition $orderby";
		$db->setQuery($query,$filter->limitstart,$filter->limit);
		$rows= $db->loadObjectList();
		return $rows;

	}

	function getListCount($published = false) {
		$condition = "";
		$cond=array();
		if ($published) {
			$cond[]="published=1";
		}

		if(count($cond)>0)
		{
			$condition="where ".implode(" AND ", $cond);
		}


		$db = JFactory::getDBO();
		$query = "SELECT count(*) from #__gbl_links $condition";
		$db->setQuery($query);
		return $db->loadResult();
	}


	function publish($task,$cid)
	{
		if($task=='publish')
		{
			$publish='1';
		}
		else
		{
			$publish='0';
		}
		$table=& JTable::getInstance('link');

		return $table->publish($cid,$publish);

	}

	function load($id)
	{
		$table=JTable::getInstance("link");
		$table->load($id);
		return $table;

	}

	function save($post=null,$file,$params)
	{

		if(!is_array($post))
		{
			throw new DataException(JText::_("INVALID_DATA"),400);
		}

		

		$row=JTable::getInstance("link");
		if(!$row->bind($post))
		{
			throw new DataException(JText::_("NO_BIND").$row->getError(),401);
		}

		if (!$row->id) {
			$row->ordering = $row->getNextOrder();
		}

		if(!$row->check())
		{
			throw new DataException($row->getError(),402);
		}

		if(!$row->store($post,$file,$params))
		{
			throw new DataException(JText::_("NO_SAVE").$row->getError(),402);
		}
		
	
		return $row->id;
	}

	function remove($cid=array())
	{

		$db=JFactory::getDBO();
		if(count($cid))
		{
			$cids=implode(',',$cid);
			$query="DELETE from #__gbl_links where id in ($cids)";
			$db->setQuery($query);
			if(!$db->query())
			{
				throw new DataException(JText::_("NO_DELETE"),400);
			}
			return true;
		}
	}

	function saveorder($cid,$order,$total)
	{
		$db			=& JFactory::getDBO();
		$row =& JTable::getInstance('link');
		$groupings = array();

		// update ordering values
		for( $i=0; $i < $total; $i++ ) {
			$row->load( (int) $cid[$i] );
			// track categories

			if ($row->ordering != $order[$i]) {
				$row->ordering = $order[$i];
				if (!$row->store()) {
					throw new DataException(JText::_("NO_ORDER_SAVE"),500);
				}
			}
		}

	}

	function order($task,$id)
	{

		if($task=='orderup')
		{

			$dir=-1;
		}
		else
		{
			$dir=1;
		}
		$row = & JTable::getInstance('link');
		$row->load( $id );

		return $row->move($dir,'' );

	}


	function getMenus()
	{
		$db=JFactory::getDBO();
		$query="SELECT concat('x:',menutype) as id, title as title from #__menu_types order by title";
		$db->setQuery($query);
		return $db->loadObjectList();

	}
	
	function getPanelLinks(&$user=null,$params=null)
	{
		$role_id=$user->ebuser->role_id;
		$db=JFactory::getDBO();
		$query="SELECT l.* from #__gbl_links_roles as lr left join #__gbl_links as l on l.id=lr.link_id where lr.role_id=$role_id and l.published=1";
		$db->setQuery($query);
		return $db->loadObjectList();
		
	}




}
?>