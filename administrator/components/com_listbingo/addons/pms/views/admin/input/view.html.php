<?php
/**
 * Joomla! 1.5 component estatebingo
 *
 * @version $Id: view.html.php 2009-11-17 10:19:05 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage estatebingo
 * @license GNU/GPL
 *
 * Code Alex
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class AgentViewInput extends GAddonsView {
	function display($tpl = null) {
		$selected=array();
		$agent_id=0;
		//get Data from controller
		if(isset($this->data))
		{
			$data=$this->data;


			if($data->can_view)
			{
				$selected[]='can_view';
			}

			if($data->can_edit)
			{
				$selected[]='can_edit';
			}

			if($data->can_delete)
			{
				$selected[]='can_delete';
			}

			if($data->can_archive)
			{
				$selected[]='can_archive';
			}

			if($data->can_transfer)
			{
				$selected[]='can_transfer';
			}
			$agent_id=$data->agent_id;
		}


		$model = gbaddons("agent.model.agent");
		$agents2 = $model->getListForSelect(true);
		$agents1=array();
		$agents1[]=JHTML::_('select.option', '0', JText::_('SELECT AGENT'), 'value', 'text');

		$agents=array_merge($agents1,$agents2);
		$lists=array();
		$lists['agents'] = JHTML::_('select.genericlist',   $agents, 'agent_id', 'class="inputbox" size="1"', 'value', 'text',$agent_id );

		$access=array();

		$access[]=JHTML::_('select.option', 'can_view', JText::_('CAN_VIEW'), 'value', 'text');
		$access[]=JHTML::_('select.option', 'can_edit', JText::_('CAN_EDIT'), 'value', 'text');
		$access[]=JHTML::_('select.option', 'can_delete', JText::_('CAN_DELETE'), 'value', 'text');
		$access[]=JHTML::_('select.option', 'can_archive', JText::_('CAN_ARCHIVE'), 'value', 'text');
		$access[]=JHTML::_('select.option', 'can_transfer', JText::_('CAN_TRANSFER'), 'value', 'text');
		$lists['access'] = GHelper::checkbox(  $access, 'agent_access', 'class="inputbox" size="1"', 'value', 'text',$selected );

		$this->assignRef('lists',$lists);

		parent::display($tpl);
	}
}
?>