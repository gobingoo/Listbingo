<?php
/**
 * Joomla! 1.5 component Listbingo
 *
 * @version $Id: email.php 2010-01-10 00:57:37 svn $
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

class ListbingoModelEmail extends GModel {
	function __construct() {
		parent::__construct();
	}

	function getList($published = false, $filter = array()) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}

		$orderby = ' ORDER BY '.$filter->order.' '.$filter->order_dir.', ordering';

		$db = JFactory::getDBO();
		$query = "SELECT * from #__gbl_mailformats $pubcond $orderby";
		$db->setQuery($query,$filter->limitstart,$filter->limit);
		return $db->loadObjectList();
	}

	function getListCount($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}

		$db = JFactory::getDBO();
		$query = "SELECT count(*) from #__gbl_mailformats $pubcond";
		$db->setQuery($query);
		return $db->loadResult();
	}

	function getListForSelect($published=false)
	{
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}

		$orderby = ' ORDER BY  ordering';

		$db = JFactory::getDBO();
		$query = "SELECT id as value, title as text from #__gbl_mailformats $pubcond $orderby";
		$db->setQuery($query);
		return $db->loadAssocList();

	}

	function getCurrencyListForSelect($published=false)
	{
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}

		$orderby = ' ORDER BY  ordering';

		$db = JFactory::getDBO();
		$query = "SELECT concat(currency_symbol,':',currency) as value, currency as text from #__gbl_mailformats $pubcond $orderby";
		$db->setQuery($query);
		return $db->loadAssocList();

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
		$table=& JTable::getInstance('email');

		return $table->publish($cid,$publish);

	}

	function load($id)
	{
		$table=JTable::getInstance("email");
		$table->load($id);
		return $table;

	}

	function save($post=null)
	{

		if(!is_array($post))
		{
			throw new DataException(JText::_("INVALID_DATA"),400);
		}

		$row=JTable::getInstance("email");
		if(!$row->bind($post))
		{
			throw new DataException(JText::_("NO_BIND").$row->getError(),401);
		}

		if (!$row->id) {
			$row->ordering = $row->getNextOrder( );
		}

		if(!$row->check())
		{
			throw new DataException($row->getError(),402);
		}

		if(!$row->store($post))
		{
			throw new DataException(JText::_("NO_SAVE").$row->getError(),402);
		}
	}

	function remove($cid=array())
	{

		$db=JFactory::getDBO();
		if(count($cid))
		{
			$cids=implode(',',$cid);
			$query="DELETE from #__gbl_mailformats where id in ($cids)";
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
		$row =& JTable::getInstance('email');
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
		$row = & JTable::getInstance('email');
		$row->load( $id );

		return $row->move($dir,'' );

	}

}
?>