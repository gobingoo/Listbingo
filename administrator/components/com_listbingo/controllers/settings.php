<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: settings.php 2010-01-10 00:57:37 svn $
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

gbimport("gobingoo.controller");

class ListbingoControllerSettings extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);

		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask( 'apply',		'save' );
		$this->registerTask( 'orderup',	'order' );
		$this->registerTask( 'orderdown',	'order' );

	}

	function display()
	{

		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'configuration');
		}
		$this->item_type = 'Default';

		parent::display();
	}


	/**
	 * Unpublish Method
	 * @return unknown_type
	 */


	function save()
	{
		global $option;

		// Test if this is really a post request
		$method	= JRequest::getMethod();

		if( $method == 'GET' )
		{
			JError::raiseError( 500 , JText::_('Access Method not allowed') );
			return;
		}

		
		$post=JRequest::get('post');

		try
		{
			$model=$this->getModel('configuration');
			$model->save($post);
			$link=JRoute::_("index.php?option=$option&task=settings",false);
			$msg=JText::_("SAVED");

		}
		catch(DataException $e)
		{
			$link=JRoute::_("index.php?option=$option&task=settings",false);
			$msg=$e->getMessage();
		}





		GApplication::redirect($link,$msg);
	}
}
?>