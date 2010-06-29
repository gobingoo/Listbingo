<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: listbingo.php 2010-01-10 00:57:37 svn $
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
global $option;

require_once JPATH_ADMINISTRATOR . DS . "components" . DS . $option . DS . 'libraries' . DS . 'core.php';

gbimport ( "gobingoo.application" );
gbimport ( "gobingoo.eventhelper" );
gbimport ( "gobingoo.extrafieldhelper" );
GEventHelper::importEvent ();
gbimport ( 'base.exceptions' );
gbimport ( 'base.controller' );
gbimport ( "gobingoo.helper" );
gbimport ( 'listbingo.helper' );
gbimport ( 'tables' );

try {
	
	$config = ListbingoController::getConfiguration ();
	
	ListbingoHelper::setErrorLevel ( $config );
	
	GApplication::init ( $config );
	global $listitemid;
	if (! JRequest::getInt ( 'Itemid', 0 )) {
		$menu = &JSite::getMenu ();
		$item = $menu->getItems ( 'link', 'index.php?option=com_listbingo&task=frontpage', true );
		/*JRequest::setVar ( 'Itemid', $item->id );
		 $listitemid = $item->id;*/
		if (is_object ( $item )) {
			JRequest::setVar ( 'Itemid', $item->id );
			$listitemid = $item->id;
		} else {
			$listitemid = 0;
		}
	
	} else {
		$listitemid = JRequest::getInt ( 'Itemid', 0 );
	}
	
	GApplication::triggerEvent ( "onSystemStart" );
	ListbingoController::loadDefault ();
	
	ListbingoController::dispatch ( JRequest::getVar ( 'task', 'frontpage' ) );
	GApplication::triggerEvent ( "onAfterDispatch" );
	
	if ($config->get ( 'enable_frontpage_cron', 0 )) {
		
		$cronmodel = gbimport ( "listbingo.model.cron" );
		
		if ($config->get ( 'enable_core_cron', 0 )) {
			$cronmodel->core ( $config );
		}
		
		if ($config->get ( 'enable_addons_cron', 0 )) {
			$cronmodel->addons ( $config );
		}
	}
} catch ( EventException $e ) {
	GApplication::triggerEvent ( "onError", array (&$e ) );
	echo $e->getMessage ();
}
?>