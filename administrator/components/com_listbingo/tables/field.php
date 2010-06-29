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
// Include library dependenciesa
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableField extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $title = null;
	
	var $type = null;
	var $default_value = null;
	
	var $description = null;
	
	var $published = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	var $required = null;
	
	var $infobar = null;
	
	var $icon = null;
	
	var $hidecaption = null;
	
	var $view_in_summary = null;
	
	var $view_in_detail = null;
	
	var $access = null;
	
	var $edit_prefix = null;
	
	var $edit_suffix = null;
	
	var $view_prefix = null;
	
	var $view_suffix = null;
	
	var $size = null;
	
	var $attributes = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_fields', 'id', $db );
	}
	
	function load($oid = null) {
		
		parent::load ( $oid );
		
		$db = JFactory::getDBO ();
		$query = "SELECT category_id from #__gbl_categories_fields where field_id='$this->id'";
		$db->setQuery ( $query );
		$this->categories = $db->loadResultArray ();
	}
	function store($categories) {
		
		$el = parent::store ();
		if (count ( $categories ) > 0) {
			$db = JFactory::getDBO ();
			$query = "DELETE from #__gbl_categories_fields where field_id=$this->id";
			$db->setQuery ( $query );
			if ($db->query ()) {
				
				foreach ( $categories as $c ) {
					$cftable = JTable::getInstance ( 'category_field' );
					$cftable->field_id = $this->id;
					$cftable->category_id = $c;
					$cftable->store ();
				}
			}
		
		}
		
		return $el;
	
	}
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		$datenow = & JFactory::getDate ();
		if (empty ( $this->title )) {
			$this->setError ( JText::_ ( 'Type must have a title' ) );
			return false;
		}
		
		$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		if (trim ( str_replace ( '&nbsp;', '', $this->description ) ) == '') {
			$this->description = '';
		}
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		$this->title = $filter->clean ( $this->title, "STRING" );
		$this->type = $filter->clean ( $this->type, "STRING" );
		$this->default_value = $filter->clean ( $this->default_value, "STRING" );
		$this->description = $filter->clean ( $this->description, "STRING" );
		$this->published = $filter->clean ( $this->published, "INT" );
		$this->ordering = $filter->clean ( $this->ordering, "INT" );
		$this->created_date = $filter->clean ( $this->created_date, "STRING" );
		$this->required = $filter->clean ( $this->required, "INT" );
		$this->infobar = $filter->clean ( $this->infobar, "STRING" );
		$this->icon = $filter->clean ( $this->icon, "STRING" );
		$this->hidecaption = $filter->clean ( $this->hidecaption, "INT" );
		$this->view_in_summary = $filter->clean ( $this->view_in_summary, "INT" );
		$this->view_in_detail = $filter->clean ( $this->view_in_detail, "INT" );
		$this->access = $filter->clean ( $this->access, "INT" );
		$this->edit_prefix = $filter->clean ( $this->edit_prefix, "STRING" );
		$this->edit_suffix = $filter->clean ( $this->edit_suffix, "STRING" );
		$this->view_prefix = $filter->clean ( $this->view_prefix, "STRING" );
		$this->view_suffix = $filter->clean ( $this->view_suffix, "STRING" );
		$this->size = $filter->clean ( $this->size, "INT" );
		$this->attributes = $filter->clean ( $this->attributes, "STRING" );
		
		return true;
	}

}
?>