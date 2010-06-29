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

class GControllerPms_Front extends GAddonsController
{

	function showReply($row)
	{
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();

		$view=$this->getView('compose','html');
		$view->assignRef('params',$params);
		$view->assignRef('adid',$row->id);
		$view->display();
	}


	function displayComposeBox()
	{

		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();

		$adid = JRequest::getInt('adid');

		$model = gbimport("listbingo.model.ad");
		$row = $model->load($adid);

		$view=$this->getView('compose','html');
		$view->assignRef('ad',$row);
		
		$view->assignRef('params',$params);
		$view->setLayout('form');
		$view->display();

	}

	function send()
	{
		global $option,$listitemid;
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
		$post = JRequest::get('post');

		$model=gbaddons("pms.model.pm");
		$row=$model->save($post,$params);
		if(is_object($row))
		{
			//GApplication::triggerEvent('onReplySave',array($row,$params));
			$model->dispatch($row,$params);
			$msg=JText::_("MESSAGE_SEND_SUCCESS");
			$errortype = "success";
		}
		else
		{
			$msg=JText::_("MESSAGE_SEND_FAILURE");
			$errortype = "error";
		}

		$redirlink=JRoute::_("index.php?option=$option&task=ads.view&Itemid=$listitemid&adid=".$post['ad_id'],false);

		GApplication::redirect($redirlink,$msg,$errortype);

	}

}
?>