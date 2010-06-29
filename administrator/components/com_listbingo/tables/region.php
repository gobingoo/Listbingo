<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: field.php 2010-01-10 00:57:37 svn $
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
gbimport ( "gobingoo.table" );
// Include library dependencies
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableRegion extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $title = null;
	
	var $alias = null;
	
	var $parent_id = null;
	
	var $description = null;
	
	var $published = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	var $country_id = null;
	
	var $default_region = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_regions', 'id', $db );
	}
	
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		$datenow = & JFactory::getDate ();
		
		$db = JFactory::getDBO ();
		$query = "SELECT parent_id from #__gbl_regions where id='$this->parent_id' and parent_id!='0'";
		
		$db->setQuery ( $query );
		$xid = $db->loadResult ();
		if ($xid === $this->id) {
			$this->setError ( JText::_ ( 'Recursive Relationship. Cannot assign Parent' ) );
			return false;
		}
		if (empty ( $this->title )) {
			$this->setError ( JText::_ ( 'Region must have a title' ) );
			return false;
		}
		
		if (empty ( $this->alias )) {
			$this->alias = $this->title;
		}
		$this->alias = JFilterOutput::stringURLSafe ( $this->alias );
		
		if (trim ( str_replace ( '-', '', $this->alias ) ) == '') {
			
			$this->alias = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		}
		
		$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		if (trim ( str_replace ( '&nbsp;', '', $this->description ) ) == '') {
			$this->description = '';
		}
		
		if ($this->parent_id != 0) {
			$db = JFactory::getDBO ();
			$query = "SELECT country_id from #__gbl_regions where id='$this->parent_id'";
			$db->setQuery ( $query );
			$this->country_id = $db->loadResult ();
		}
		
		if ($this->parent_id == 0 && $this->country_id != 0 && $this->id != 0) {
			$db = JFactory::getDBO ();
			$query = "UPDATE #__gbl_regions set country_id='$this->country_id' where parent_id='$this->id'";
			$db->setQuery ( $query );
			$db->query ();
		}
		
		if ($this->default_region) {
			$db = JFactory::getDBO ();
			$query = "UPDATE #__gbl_regions set default_region=0";
			$db = JFactory::getDBO ();
			$db->setQuery ( $query );
			$db->query ();
			$this->published = 1;
		}
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		$this->title = $filter->clean ( $this->title, "STRING" );
		$this->alias = $filter->clean ( $this->alias, "STRING" );
		$this->parent_id = $filter->clean ( $this->parent_id, "INT" );
		$this->description = $filter->clean ( $this->description, "STRING" );
		$this->published = $filter->clean ( $this->published, "INT" );
		$this->country_id = $filter->clean ( $this->country_id, "INT" );
		$this->default_region = $filter->clean ( $this->currency, "STRING" );

		
		return true;
	}

}
?>