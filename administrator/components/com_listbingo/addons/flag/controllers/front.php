<?php
/**
 * admin.php
 *@package Listbingo
 *@subpackage flag
 *
 *Flag Addon Controller
 *code Bruce
 *
 */

defined('JPATH_BASE') or die();
gbimport("gobingoo.addonscontroller");

class GControllerFlag_Front extends GAddonsController
{

	function displayFlag($row)
	{
		$view=$this->getView('flag','html');
		$view->display();
	}

	function showFlagForm()
	{

		global $mainframe,$option;

		$adid = JRequest::getVar('adid',0);
		$ip = GHelper::getIP();
		$model=gbaddons("flag.model.flag");
		$flag = $model->isFromThisIP($adid,$ip);

		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();


		$article_id=$params->get('flag_id',0);
		$article=JTable::getInstance("content");
		$article->load($article_id);

		$article->text=$article->introtext.$article->fulltext;

		$xparams=& $mainframe->getParams('com_content');
		$results = $mainframe->triggerEvent('onPrepareContent', array (& $article, & $xparams, 0));

		$report=array();

		$report[]=JHTML::_('select.option', '', JText::_('PLEASE_SELECT'), 'id', 'title');
		$report[]=JHTML::_('select.option', '1', JText::_('MISCATEGORIZED'), 'id', 'title');
		$report[]=JHTML::_('select.option', '2', JText::_('FRAUD'), 'id', 'title');
		$report[]=JHTML::_('select.option', '3', JText::_('ILLEGAL'), 'id', 'title');
		$report[]=JHTML::_('select.option', '4', JText::_('SPAM'), 'id', 'title');
		$report[]=JHTML::_('select.option', '5', JText::_('UNAVAILABLE'), 'id', 'title');

		$reportlist = JHTML::_('select.genericlist',  $report, 'flag_id', 'class="inputField required"', 'id', 'title');

		$view = $this->getView('flag','html');
		$view->assignRef('article',$article);
		$view->assignRef('report',$reportlist);
		$view->assignRef('params',$params);
		$view->assignRef('adid',$adid);
		$view->setLayout('form');
		$view->customDisplay();
	}



	function report()
	{
		global $mainframe,$option, $listitemid;

		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();

		$data = JRequest::get('post',array());
		$data['ipaddress'] = GHelper::getIP();
		$user = JFactory::getUser();

		$data['user_id'] = $user->get('id');
		

		try
		{

			$model=gbaddons("flag.model.flag");

			$filter = new stdClass();
			$filter->item_id = $data['item_id'];
			$filter->email = $data['email'];

			if(!$model->checkFlaggedItem($filter))
			{
				$id = $model->save($data);
				$link=JRoute::_("index.php?option=$option&task=ads.view&Itemid=$listitemid&adid=".$data['item_id'],false);
				$msg=JText::_("FLAGGED");

				$flag = $model->load($id);
				$model->doSuspension($params);

				//GApplication::triggerEvent('afterDataSave',array($data));
				GApplication::triggerEvent('onFlagSave',array($flag,$params));
			}
			else
			{

				$msg = JText::_('ALREADY_FLAGGED');
				$link=JRoute::_("index.php?option=$option&task=ads.view&Itemid=$listitemid&adid=".$data['item_id'],false);
			}

		}
		catch(DataException $e)
		{
			$link=JRoute::_("index.php?option=$option&task=ads.view&Itemid=$listitemid&adid=".$data['item_id'],false);
			$msg=$e->getMessage();
		}

		GApplication::redirect($link,$msg);
	}

}
?>