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
class JTableOption extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $title = null;
	
	var $option_value = null;
	
	var $field_id = null;
	
	var $published = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_options', 'id', $db );
	}
	
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		$datenow = & JFactory::getDate ();
		$db=JFactory::getDBO();
		if (empty ( $this->title )) {
			$this->setError ( JText::_ ( 'Type must have a title' ) );
			return false;
		}
		
		$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		$this->title = $filter->clean ( $this->title, "STRING" );
		$this->option_value = $filter->clean ( $this->option_value );
		$this->field_id = $filter->clean ( $this->field_id, "INT" );
		$this->published = $filter->clean ( $this->published, "INT" );
		$this->ordering = $filter->clean ( $this->ordering, "INT" );
		$this->created_date = $filter->clean ( $this->created_date, "STRING" );	

		
		return true;
	}

}
?>