<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport("joomla.application.component.controller");

class GController extends JController
{

	function &getAddonInstance($path, $prefix = "GController") {
		global $option;
		$path=str_replace(".controller.",".controllers.",$path);
		// use a static array to store controller instances

		$addonspath=explode(".", $path);
		$package=$addonspath[0];
		$entity= array_pop($addonspath);
	 	$basepath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS;
		$entitypath=implode(DS,$addonspath);


		static $addoninstances;
		if (!$addoninstances) {
			$addoninstances = array();
		}
		// determine subclass name
		$class = $prefix.ucfirst($package)."_".ucfirst($entity);

		// check if we already instantiated this controller
		if (!isset($addoninstances[$class])) {
			// check if we need to find the controller class
			if (!class_exists($class)) {
				jimport('joomla.filesystem.file');
				 $path = $basepath.$entitypath.DS.strtolower($entity).'.php';

				// search for the file in the controllers path
				if (JFile::exists($path)) {
						
					// include the class file
					require_once $path;
						
					if (!class_exists($class)) {
						// class file does not include the class
						throw new ControllerException(JText::_('Invalid Addon'),400);


					}
						
				} else {
						
					// class file not found
					throw new ControllerException(JText::_('Unknown Addon'),400);


				}
			}
			// create controller instance
			$addoninstances[$class] = new $class();
		}
		// return a reference to the controller
		return $addoninstances[$class];
		

	}

	function invokeAddon($command)
	{
		
		$commands=explode(".",$command);
		$task="display";
		if(count($commands)>2)
		{
			$task=array_pop($commands);
		}
		
		$xcommand=array();
		$xcommand[]=array_shift($commands);
		$xcommand[]="controller";
		
		$xcommand=array_merge($xcommand,$commands);
		
		
	
		 $xcommand= implode(".",$xcommand);
		$controller=gbaddons($xcommand);
		$controller->execute($task);
		$controller->redirect();
		
	}

}
?>