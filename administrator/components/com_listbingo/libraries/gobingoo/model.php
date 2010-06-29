<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport("joomla.application.component.model");

class GModel extends JModel
{
	function &getAddonInstance($path, $prefix = "GModel") {
		global $option;
		$path=str_replace(".model.",".models.",$path);
		// use a static array to store controller instances

		$addonspath=explode(".", $path);
		$package=$addonspath[0];
		$entity= array_pop($addonspath);
		$basepath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS;
		$entitypath=implode(DS,$addonspath);


		static $instances;
		if (!$instances) {
			$instances = array();
		}
		// determine subclass name
		$class = $prefix.ucfirst($package).ucfirst($entity);

		// check if we already instantiated this controller
		if (!isset($instances[$class])) {
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
						throw new ControllerException(JText::_('Invalid Addon Model'),400);


					}
				} else {
					// class file not found
					throw new ControllerException(JText::_('Unknown Addon Model'),400);


				}
			}
			// create controller instance
			$instances[$class] = new $class();
		}
		// return a reference to the controller
		return $instances[$class];

	}

}
?>