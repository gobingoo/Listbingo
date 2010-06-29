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
gbimport ( "gobingoo.table" );
// Include library dependencies
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableCountry extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $title = null;
	
	var $code = null;
	
	var $zipcode = null;
	
	var $description = null;
	
	var $published = null;
	
	var $ordering = null;
	
	var $image = null;
	
	var $default_country = null;
	
	var $currency = null;
	
	var $currency_symbol = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_countries', 'id', $db );
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
			$this->setError ( JText::_ ( 'Country must have a title' ) );
			return false;
		}
		
		if (trim ( str_replace ( '&nbsp;', '', $this->description ) ) == '') {
			$this->description = '';
		}
		
		if ($this->default_country) {
			$db = JFactory::getDBO ();
			$query = "UPDATE #__gbl_countries set default_country=0";
			$db = JFactory::getDBO ();
			$db->setQuery ( $query );
			$db->query ();
			
			$this->published = 1;
		}
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		$this->title =  $filter->clean ( $this->title, "STRING" );		
		$this->code = $filter->clean ( $this->code, "STRING" );		
		$this->zipcode = $filter->clean ( $this->zipcode, "INT" );		
		$this->description = $filter->clean ( $this->description, "STRING" );		
		$this->published = $filter->clean ( $this->published, "INT" );		
		$this->ordering = $filter->clean ( $this->ordering, "INT" );		
		$this->image = $filter->clean ( $this->image, "STRING" );		
		$this->default_country = $filter->clean ( $this->default_country, "INT" );		
		$this->currency = $filter->clean ( $this->currency, "STRING" );		
		$this->currency_symbol = $filter->clean ( $this->currency_symbol, "STRING" );
		
		return true;
	}

}
?>