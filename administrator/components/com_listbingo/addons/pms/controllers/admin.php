<?php
/**
 * admin.php
 *@package Estatebingo
 *@subpackage agent
 *
 *Estatebingo Agent Controller
 *code Alex
 *
 */

defined('JPATH_BASE') or die();
gbimport("gobingoo.addonscontroller");

class GControllerPms_Admin extends GAddonsController
{

	function __construct($config = array())
	{
		parent::__construct($config);

	}

	function display()
	{
		$view=$this->getView("pms","html",true);
		$view->display();
	}

	function pmsSettingsPage($params=null)
	{
		$view=$this->getView('settings','html',true);
		$view->assignRef('config',$params);
		$view->display();
	}


	function remove()
	{
		global $mainframe,$option;

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		try
		{
			$model=$this->getModel('pm');

			$model->remove($cid);
			$msg=JText::_('DELETED');
		}
		catch(DataException $e)
		{
			$msg=$e->getMessage();
		}

		$link=JRoute::_("index.php?option=$option&task=addons.pms.admin",false);
		GApplication::redirect($link,$msg);

	}

	function view()
	{
		$view=$this->getView('pm','html',true);
		$view->display();
	}


}
?>