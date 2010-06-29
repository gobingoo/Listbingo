<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: addon.php 2010-01-10 00:57:37 svn $
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
class JTableAddon extends GTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $name=null;

	var $element=null;

	var $folder=null;

	var $access=null;

	var $ordering=null;

	var $published=null;

	var $iscore=null;

	var $client_id=null;

	var $checked_out=null;

	var $checked_out_time=null;

	var $params=null;




	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__gbl_addons', 'id', $db);
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

	function bind($array, $ignore = '')
	{
		if (isset( $array['params'] ) && is_array($array['params']))
		{
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}

}
?>