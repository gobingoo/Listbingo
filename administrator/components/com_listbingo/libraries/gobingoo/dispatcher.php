<?php
/**
 * GDispatcher for Gobingoo events
 *
 */


jimport( 'joomla.event.dispatcher' );
class GDispatcher extends JDispatcher
{
	
	function & getInstance()
	{
		static $instance;

		if (!is_object($instance)) {
			$instance = new GDispatcher();
		}

		return $instance;
	}
	
	function trigger($event, $args = null, $doUnpublished = false)
	{
		
		
		// Initialize variables
		$result = array ();

		/*
		 * If no arguments were passed, we still need to pass an empty array to
		 * the call_user_func_array function.
		 */
		if ($args === null) {
			$args = array ();
		}

		/*
		 * We need to iterate through all of the registered observers and
		 * trigger the event for each observer that handles the event.
		 */
		foreach ($this->_observers as $observer)
		{
			
			if (is_array($observer))
			{
				/*
				 * Since we have gotten here, we know a little something about
				 * the observer.  It is a function type observer... lets see if
				 * it handles our event.
				 */

				if ($observer['event'] == $event)
				{
						
						
					if (function_exists($observer['handler']))
					{
						$result[] = call_user_func_array($observer['handler'], $args);
					}
					else
					{
						/*
						 * Couldn't find the function that the observer specified..
						 * wierd, lets throw an error.
						 */
						JError::raiseWarning('SOME_ERROR_CODE', 'JDispatcher::trigger: Event Handler Method does not exist.', 'Method called: '.$observer['handler']);
					}
				}
				else
				{
					// Handler doesn't handle this event, move on to next observer.
					continue;
				}
			}
			elseif (is_object($observer))
			{
					
				/*
				 * Since we have gotten here, we know a little something about
				 * the observer.  It is a class type observer... lets see if it
				 * is an object which has an update method.
				 */
				if (method_exists($observer, 'update'))
				{
						
					/*
					 * Ok, now we know that the observer is both not an array
					 * and IS an object.  Lets trigger its update method if it
					 * handles the event and return any results.
					 */
					
					$method=$event;
					if(isset($observer->_taskMap[strtolower($event)]))
					{
						$method=$observer->_taskMap[strtolower($event)];
					}
					
					if (method_exists($observer,$method))
					{

						$args['event'] = $event;
						$result[] = $observer->update($args);
					}
					else
					{
						/*
						 * Handler doesn't handle this event, move on to next
						 * observer.
						 */
						continue;
					}
				}
				else
				{
					/*
					 * At this point, we know that the registered observer is
					 * neither a function type observer nor an object type
					 * observer.  PROBLEM, lets throw an error.
					 */
					JError::raiseWarning('SOME_ERROR_CODE', 'JDispatcher::trigger: Unknown Event Handler.', $observer );
				}
			}
		}
		return $result;
	}

}
?>