<?php
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class FlagViewFlag extends GAddonsView {
	
	
	function display($tpl=null)
	{		
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
		
		$this->assignRef('flag',$flag);
		$this->assignRef('adid',$row->id);
		$this->assignRef('params',$params);
		
		parent::display();
	}
	
	function customDisplay($tpl=null)
	{
		parent::display();
	}
	
	
}
?>