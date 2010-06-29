<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
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

jimport('joomla.client.helper');

jimport( 'joomla.installer.installer' );
jimport('joomla.installer.helper');



class ListbingoControllerPlugins extends GController
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
			JRequest::setVar('view', 'addons');
		}
		$this->item_type = 'Default';
		parent::display();
	}

	/**
	 * Publish Method
	 * @return unknown_type
	 */
	function publish()
	{
		global $mainframe,$option;
		$tasks=explode(".",JRequest::getCmd("task"));
		$task=$tasks[1];

		$cid=JRequest::getVar('cid',array(),'','array');
		$model=$this->getModel('addon');

		if($model->publish($task,$cid))
		{
			switch($task)
			{
				case 'publish':
					$msg=JText::_("PUBLISHED_SUCCESS");
					break;
				default:
					$msg=JText::_("UNPUBLISHED_SUCCESS");
					break;
			}
		}

		$link=JRoute::_("index.php?option=$option&task=plugins",false);
		GApplication::redirect($link,$msg);
	}
	/**
	 * Unpublish Method
	 * @return unknown_type
	 */

	function edit()
	{
		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'addon');
		}
		$this->item_type = 'Default';
		parent::display();
	}


	function add()
	{
		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'install');
		}
		$this->item_type = 'Default';
		parent::display();
	}

	function doInstall()
	{

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model	= &$this->getModel( 'install' );

		$view	= &$this->getView( 'install' ,'html');

		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		$view->assignRef('ftp', $ftp);


		if ($model->install()) {
			$cache = &JFactory::getCache('mod_menu');
			$cache->clean();
		}
			
		$addonmodel=$this->getModel('addon');
		
		$addonmodel->rebuild();

		$view->setModel( $model, true );
		$view->display();
	}


	function save()
	{
		global $mainframe,$option;
		$post=JRequest::get('post');
		$tasks=explode(".",JRequest::getCmd("task"));
		$task=$tasks[1];
		try
		{
			$model=$this->getModel('addon');
			$id=$model->save($post);
			switch($task)
			{
				case 'save':

					$link=JRoute::_("index.php?option=$option&task=plugins",false);
					$msg=JText::_("SAVED");
					break;
				default:
					$link=JRoute::_("index.php?option=$option&task=plugins.edit&cid[]=".$id,false);
					$msg=JText::_("APPLIED");
					break;

			}


		}
		catch(DataException $e)
		{
			$link=JRoute::_("index.php?option=$option&task=plugins.edit&cid[]=".$post['id'],false);
			$msg=$e->getMessage();
		}

		GApplication::redirect($link,$msg);
	}

	function remove()
	{
		global $mainframe,$option;
		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		try
		{
			$model=$this->getModel('addon');

			$model->remove($cid);
		
		
		$model->rebuild();
			$msg=JText::_('DELETED');
		}
		catch(DataException $e)
		{
			$msg=$e->getMessage();
		}

		$link=JRoute::_("index.php?option=$option&task=plugins",false);
		GApplication::redirect($link,$msg);


	}

	function saveorder()
	{
		global $mainframe,$option;

		$error="info";
		$cid=JRequest::getVar('cid',array(),'','array');


		$total		= count( $cid );
		$order 		= JRequest::getVar( 'order', array(0), 'post', 'array' );
		JArrayHelper::toInteger($order, array(0));
		$model=$this->getModel('addon');
		$link=JRoute::_("index.php?option=$option&task=plugins",false);
		try
		{
			$model->saveorder($cid,$order,$total);
			$msg=JText::_("ORDER_SAVED");
		}
		catch(DataException $e)
		{
			$error="error";
			$msg=$e->getMessage();
		}
		GApplication::redirect($link,$msg);

	}

	function order()
	{
		global $mainframe,$option;

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );


		$tasks=explode(".",JRequest::getCmd("task"));
		$task=$tasks[1];

		$cid=JRequest::getVar('cid',array(),'','array');
		$model=$this->getModel('addon');


		if($model->order($task,$id))
		{
			switch($task)
			{
				case 'orderdown':
					$msg=JText::_("ORDER_DOWN");
					break;
				default:
					$msg=JText::_("ORDERUP");
					break;
			}
		}

		$link=JRoute::_("index.php?option=$option&task=plugins",false);
		GApplication::redirect($link,$msg);
	}
	
	function rebuild()
	{
		global $option;
		$model=gbimport("listbingo.model.addon");
		if($model->rebuild())
		{
			$msg=JText::_("BUILD_SUCCESS");
	
			$type="message";
			
		}
		else
		{
			$msg=JText::_("BUILD_FAIL");
	
			$type="error";
		}
		
		$link=JRoute::_("index.php?option=$option&task=plugins",false);
		GApplication::redirect($link,$msg,$type);
		
		
	}
}
?>