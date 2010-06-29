<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: countries.php
 * @author gobingoo.com
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * @code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.controller");

class ListbingoControllerCountries extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);


	}

	function display()
	{
		JRequest::setVar('view', 'countries');
		$this->item_type = 'Default';
		parent::display();

	}
}
?>