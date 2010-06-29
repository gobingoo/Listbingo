<?php

defined('JPATH_BASE') or die();

gbimport( 'gobingoo.event' );
gbimport("gobingoo.helper");


class evtSystemScripttime extends GEvent
{

	function onSystemStart()
	{

		
		$app=JFactory::getApplication();
		$app->set('starttime',microtime(true));
	}
	
	function onAfterDispatch()
	{
		$app=JFactory::getApplication();
		$currenttime=microtime(true);
		$starttime=$app->get('starttime');
		$timediff=$currenttime-$starttime;
		echo "Listbingo Execution Time ".$timediff . " sec";
	}

}
?>