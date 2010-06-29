<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ads.php 2010-01-10 00:57:37 svn $
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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

gbimport ( "gobingoo.controller" );

class ListbingoControllerCron extends GController {
	
	function run() {
		
		global $option;
		
		$mainframe = JFactory::getApplication ();
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$cronmodel = gbimport ( "listbingo.model.cron" );
		
		if ($params->get ( 'enable_core_cron', 0 )) {
			$cronmodel->core ($params);
		}
	
		
		if ($params->get ( 'enable_addons_cron', 0 )) {
			$cronmodel->addons ($params);
		}
	
	}

}
?>