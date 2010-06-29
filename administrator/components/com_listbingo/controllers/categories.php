<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: categories.php 2010-01-10 00:57:37 svn $
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

class ListbingoControllerCategories extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask( 'apply',		'save' );
		$this->registerTask( 'orderup',	'order' );
		$this->registerTask( 'orderdown',	'order' );

	}

	function display()
	{

		JRequest::setVar('view', 'categories');

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
		$task=array_pop($tasks);

		$cid=JRequest::getVar('cid',array(),'','array');
		$model=$this->getModel('category');

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

		$link=JRoute::_("index.php?option=$option&task=categories",false);
		GApplication::redirect($link,$msg);
	}
	/**
	 * Unpublish Method
	 * @return unknown_type
	 */

	function edit()
	{
		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'category');
		}
		$this->item_type = 'Default';
		parent::display();
	}

	function save()
	{
		global $mainframe,$option;
		$post=JRequest::get('post');
		$files=JRequest::get('files');
		
		$post ['description'] = JRequest::getVar ( 'description', '', 'post', 'string', JREQUEST_ALLOWHTML );


		$configmodel=gbimport('listbingo.model.configuration');
		$params=$configmodel->getParams();
		$tasks=explode(".",JRequest::getCmd("task"));
		$task=array_pop($tasks);
		try
		{
			$model=$this->getModel('category');
				
			$id = $model->save($post,$files['logo'],$params);
			switch($task)
			{
				case 'save':

					$link=JRoute::_("index.php?option=$option&task=categories",false);
					$msg=JText::_("SAVED");
					break;
				default:
					$link=JRoute::_("index.php?option=$option&task=categories.edit&cid[]=".$id,false);
					$msg=JText::_("APPLIED");
					break;

			}


		}
		catch(DataException $e)
		{
			$link=JRoute::_("index.php?option=$option&task=categories.edit&cid[]=".$post['id'],false);
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
			$model=$this->getModel('category');

			$model->remove($cid);
			$msg=JText::_('DELETED');
		}
		catch(DataException $e)
		{
			$msg=$e->getMessage();
		}

		$link=JRoute::_("index.php?option=$option&task=categories",false);
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
		$model=$this->getModel('category');
		$link=JRoute::_("index.php?option=$option&task=categories",false);
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
		$model=$this->getModel('category');


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

		$link=JRoute::_("index.php?option=$option&task=categories",false);
		GApplication::redirect($link,$msg);
	}

	function loadef()
	{

		$cid=(int)JRequest::getVar('cid',0);
		$ad_id=(int)JRequest::getVar('adid',0);

		$catmodel=gbimport("listbingo.model.category");
		$fields=$catmodel->getExtrafields($cid,$ad_id);
		$view=$this->getView('ajaxinput','html');
		$view->setLayout('category');
		$view->assignRef('fields',$fields);
		$view->display();

	}
}
?>