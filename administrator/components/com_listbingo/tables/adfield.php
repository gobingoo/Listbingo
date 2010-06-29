<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: adfield.php 2010-01-10 00:57:37 svn $
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
gbimport("gobingoo.table");
// Include library dependencies
jimport('joomla.filter.input');

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableAdfield extends GTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $ad_id=null;

	var $field_id=null;

	var $field_value=null;

	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__gbl_ads_fields', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		
		return true;
	}

}
?>