<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: adimage.php 2010-01-10 00:57:37 svn $
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
class JTableAdimage extends GTable {

	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;

	var $caption=null;

	var $ad_id=null;

	var $published=null;

	var $ordering=null;

	var $created_date=null;

	var $image=null;


	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct('#__gbl_ads_images', 'id', $db);
	}

	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		$datenow =& JFactory::getDate();

		$this->created_date=$datenow->toFormat("%Y-%m-%d-%H-%M-%S");

		return true;
	}

	function removeImage($iid)
	{
		$image = parent::load($iid);
		
		$db = JFactory::getDBO();
		$query = "DELETE FROM #__gbl_ads_images WHERE id=$iid";
		$db->setQuery($query);
		$db->query();
	}

}
?>