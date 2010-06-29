<?php
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class FlagViewFlags extends GAddonsView 
{	
	
	function display($tpl=null)
	{		
		$row = null;
		$model=gbaddons("flag.model.flag");
		$result = $model->getFlagLists($row);
		
		$this->assignRef('flaglist',$result);
		parent::display();
	}	
	
}
?>