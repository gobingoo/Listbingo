<?php
/**
 * Joomla! 1.5 component LISTBINGO
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
gbimport("gobingoo.table");
// Include library dependencies
jimport('joomla.filter.input');

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableEmail extends GTable {
	var $id=null;


	var $subject=null;

	var $body=null;

	var $published=null;


	var $type=null;

	var $ordering=null;

	var $event=null;

	var $mailto=null;

	var $from_name=null;

	var $from_email=null;

	var $reply_to=null;

	var $reply_to_email=null;

	function __construct(&$db)
	{
		parent::__construct('#__gbl_mailformats','id',$db);

	}
}

?>