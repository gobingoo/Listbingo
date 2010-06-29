<?php
/**
 * Joomla! 1.5 component Estatebingo
 *
 * @version $Id: type.php 2009-10-13 00:39:06 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage estatebingo
 * @license GNU/GPL
 * @code Alex
 *
 *
 *
 *
 */
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.controller");

class ListbingoControllerDefault extends GController
{


	function display()
	{
		$view=$this->getView('default','html');
		$view->display();
	
	}
}
?>