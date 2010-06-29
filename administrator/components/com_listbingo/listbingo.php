<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: listbingo.php 2010-01-10 00:57:37 svn $
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

/*
 * Define constants for all pages
 */

require_once JPATH_ADMINISTRATOR.DS."components".DS.$option.DS.'libraries'.DS.'core.php';
gbimport("gobingoo.application");
gbimport("gobingoo.eventhelper");
GEventHelper::importEvent();
gbimport('base.exceptions');
gbimport('base.controller');
gbimport("gobingoo.helper");
gbimport('listbingo.helper');
gbimport('tables');
try
{
	$config = ListbingoController::getConfiguration ();	
	ListbingoHelper::setErrorLevel($config);
	
	GApplication::triggerEvent("onAdminSystemStart");
	ListbingoController::dispatch(JRequest::getCmd('task', 'default'));
	GApplication::triggerEvent("onAdminAfterDispatch");
}
catch(EventException $e)
{
	GApplication::triggerEvent("onError",array(&$e));
	echo $e->getMessage();
}
?>