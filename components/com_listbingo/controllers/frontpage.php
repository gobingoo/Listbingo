<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: frontpage.php 2010-01-10 00:57:37 svn $
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

class ListbingoControllerFrontpage extends GController {
	
	function __construct($config = array()) {
		parent::__construct ( $config );
	
	}
	
	function display() {
		global $option, $listitemid;
		
		//Check if the view is frontpage.
		//if Yes select the appropriate layout and render.
		//Else pass the control to called view
		

		if (JRequest::getCmd ( 'view' ) == 'frontpage' || (JRequest::getCmd ( 'view' ) == '' || JRequest::getCmd ( 'task' ) == 'frontpage' && JRequest::getCmd ( 'task' ) == '')) {
			
			$configmodel = gbimport ( "listbingo.model.configuration" );
			$params = $configmodel->getParams ();
			
			//Get Frontpage Layout from User Settings
			$frontpage_layout = $params->get ( 'frontpage_layout' );
			
			$mainframe = JFactory::getApplication ();
			$mainframe->setUserState ( 'post', false );
			$mainframe->setUserState ( 'hereiam', '' );
			

			switch ($frontpage_layout) {
				
				case 'category' :
					$link = JRoute::_ ( "index.php?option=$option&task=categories&Itemid=$listitemid", false );
					
					break;
				
				case 'listing' :
					$link = JRoute::_ ( "index.php?option=$option&task=ads&Itemid=$listitemid", false );
					break;
				
				case 'advsearch' :
					$link = JRoute::_ ( "index.php?option=$option&task=search&type=adv&Itemid=$listitemid", false );
					break;
				
				case 'search' :
				default :
					
					$link = JRoute::_ ( "index.php?option=$option&task=search&Itemid=$listitemid", false );
					break;
			
			}
			
			GApplication::redirect ( $link );
		} else {
			//Render called view
			parent::display ();
		
		}
	
	}
}
?>