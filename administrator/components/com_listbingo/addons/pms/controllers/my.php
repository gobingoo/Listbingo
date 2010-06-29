<?php
/**
 * admin.php
 *@package Listbingo
 *@subpackage agent
 *
 *Listbingo Agent Controller
 *
 */

defined('JPATH_BASE') or die();
gbimport("gobingoo.addonscontroller");

class GControllerPms_My extends GAddonsController
{

	function __construct($config = array())
	{
		parent::__construct($config);

	}

	function display()
	{
		$view=$this->getView("pms","html");
		$view->display();
	}

	function view()
	{
		$view=$this->getView("pm","html");
		$view->display();
	}

	function remove()
	{
		global $mainframe,$option,$listitemid;

		$user = JFactory::getUser();
		if($user->guest)
		{
			$returnurl = base64_encode(JRoute::_("index.php?option=$option&task=addons.pms.my&Itemid=$listitemid&time=".time(),false));

			$link = JRoute::_("index.php?option=com_user&view=login&Itemid=$listitemid&return=$returnurl&time=".time(),false);
			$msg = JText::_("LOGIN_TO_DELETE_YOUR_PMS");
			GApplication::redirect($link,$msg,"error");
		}

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );

		JArrayHelper::toInteger($cid, array(0));
		try
		{
			$model=gbaddons("pms.model.pm");

			$model->removeMyPm($cid,$user->get('id'));
			$msg=JText::_('DELETED');
			$type="success";
		}
		catch(DataException $e)
		{
			$msg=$e->getMessage();
			$type="error";
		}

		$link=JRoute::_("index.php?option=$option&task=addons.pms.my&Itemid=$listitemid&time=".time(),false);
		GApplication::redirect($link,$msg,$type);

	}
}
?>