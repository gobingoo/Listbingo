<?php


// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Event helper class
 *
 * @static
 * @package		Joomla.Framework
 * @subpackage	Event
 * @since		1.5
 */
class GEventHelper
{
	/**
	 * Get the event data of a specific type if no specific event is specified
	 * otherwise only the specific event data is returned
	 *
	 * @access public

	 * @param string 	$event	The event name
	 * @return mixed 	An array of event data objects, or a event data object
	 */
	function &getEvent($event = null)
	{
		$result = array();

		$events = GEventHelper::_load();

		$total = count($events);
		for($i = 0; $i < $total; $i++)
		{
			if(is_null($event))
			{

				$result[] = $events[$i];

			}
			else
			{
				if($events[$i]->name == $event) {
					$result = $events[$i];
					break;
				}
			}

		}

		return $result;
	}

	/**
	 * Checks if a event is enabled
	 *
	 * @access	public

	 * @param string 	$event	The event name
	 * @return	boolean
	 */
	function isEnabled(  $event = null )
	{
		$result = &GEventHelper::getEvent( $event);
		return (!empty($result));
	}

	/**
	 * Loads all the event files for a particular type if no specific event is specified
	 * otherwise only the specific pugin is loaded.
	 *
	 * @access public

	 * @param string 	$event	The event name
	 * @return boolean True if success
	 */
	function importEvent( $event = null, $autocreate = true, $dispatcher = null)
	{

		$result = false;

		if($events = GEventHelper::_load())
		{

			$total = count($events);
			for($i = 0; $i < $total; $i++) {
				if($events[$i]->name == $event ||  $event === null) {
					GEventHelper::_import( $events[$i], $autocreate, $dispatcher );
					$result = true;
				}
			}
		}
		return $result;
	}

	/**
	 * Loads the event file
	 *
	 * @access private
	 * @return boolean True if success
	 */
	function _import( &$event, $autocreate = true, $dispatcher = null )
	{
		global $option;
		static $paths;

		if (!$paths) {
			$paths = array();
		}

		$result	= false;
		$event->type = preg_replace('/[^A-Z0-9_\.-]/i', '', $event->type);
		$event->name  = preg_replace('/[^A-Z0-9_\.-]/i', '', $event->name);

		$path	= JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$event->type.DS.$event->name.'.php';

		if (!isset( $paths[$path] ))
		{

			if (file_exists( $path ))
			{


				//needed for backwards compatibility
				global $_MAMBOTS, $mainframe;

				gbimport("gobingoo.event");
				gbimport("gobingoo.dispatcher");
				require_once( $path );
				$paths[$path] = true;

				if($autocreate)
				{
					// Makes sure we have an event dispatcher
					if(!is_object($dispatcher)) {
						$dispatcher = & GDispatcher::getInstance();
					}

					$className = 'evt'.$event->type.$event->name;
					if(class_exists($className))
					{
						// load event parameters
						$event =& GEventHelper::getEvent( $event->name);

						// create the event
						$instance = new $className($dispatcher, (array)($event));
					}
				}
			}
			else
			{
				$paths[$path] = false;
			}
		}
	}

	/**
	 * Loads the published events
	 *
	 * @access private
	 */
	function _load()
	{

		static $events;

		if (isset($events)) {
			return $events;
		}

		$db		=& JFactory::getDBO();
		$user	=& JFactory::getUser();


		$query = 'SELECT folder AS type, element AS name, params'
		. ' FROM #__gbl_addons'
		. ' WHERE published >= 1'
		. ' ORDER BY ordering';


		$db->setQuery( $query );

		if (!($events = $db->loadObjectList())) {

			return false;
		}



		return $events;
	}

}
