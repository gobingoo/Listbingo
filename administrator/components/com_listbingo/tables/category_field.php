<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: category_field.php 2010-01-10 00:57:37 svn $
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
class JTableCategory_field extends GTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $field_id=null;

	var $category_id=null;

	
	
	


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__gbl_categories_fields', 'id', $db);
	}
	


}
?>