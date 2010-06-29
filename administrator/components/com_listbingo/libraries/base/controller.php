<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: controller.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from GOBINGOO.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.controller");


/**
 * listbingo Controller
 *
 * @package Joomla
 * @subpackage LISTBINGO
 */
class ListbingoController extends GController {
	/**
	 * Constructor
	 * @access private
	 * @subpackage listbingo
	 */
	function __construct() {
		//Get View
		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'default');
		}
		$this->item_type = 'Default';
		parent::__construct();
	}

	function getInstance($entity, $prefix = "ListbingoController") {
		// use a static array to store controller instances
		static $instances;
		if (!$instances) {
			$instances = array();
		}
		// determine subclass name
		$class = $prefix.ucfirst($entity);

		// check if we already instantiated this controller
		if (!isset($instances[$class])) {
			// check if we need to find the controller class
			if (!class_exists($class)) {
				jimport('joomla.filesystem.file');
				$path = JPATH_COMPONENT.DS.'controllers'.DS.strtolower($entity).'.php';
				// search for the file in the controllers path
				if (JFile::exists($path)) {
					// include the class file
					require_once $path;
					if (!class_exists($class)) {
						// class file does not include the class
						throw new ControllerException(JText::_('Invalid controller'),400);


					}
				} else {
					// class file not found
					throw new ControllerException(JText::_('Unknown controller'),400);


				}
			}
			// create controller instance
			$instances[$class] = new $class();
		}
		// return a reference to the controller
		return $instances[$class];

	}

	function loadDefault()
	{

		$controller=self::getInstance('default');
		$controller->execute('default');
	}

	function dispatch($command='default')
	{
		global $mainframe;

		try
		{
		 if (strpos($command, 'default') === 0) {
		 	throw new ControllerException("Default Panel",0);
		 }
			$mod="";
			$task="";
			if (strpos($command, 'addons') === 0) {
					

				$commands=explode(".",$command);
				array_shift($commands);
				self::invokeAddon(implode(".",$commands));
					
			}
			else
			{

				$commands=explode(".",$command);
				if(count($commands)<=1)
				{
					$mod=$command;
					$task="display";
				}
				else
				{
					$mod=$commands[0];
					$task=$commands[1];
				}
				$controller = self::getInstance($mod);

				$controller->execute($task);

				// redirect
				$controller->redirect();
			}

		}
		catch(ControllerException $e)
		{
			$controller = new self();

			// Perform the Request task
			if($e->getCode()!=0)
			{
				$mainframe->enqueueMessage($e->getMessage(), 'error');
			}
			$controller->execute($command);

			$controller->redirect();
		}
	}

	function getConfiguration()
	{
		$configmodel=gbimport("listbingo.model.configuration");
		return $configmodel->getParams();

	}


}
?>
