<?php
/**
 * Gobingoo Abstraction Layer for portability
 *

 */

class GApplication extends JApplication
{

	var $config=null;

	function redirect( $url, $msg='', $msgtype='message' )
	{
		$gapp=self::getInstance('site');

		$gapp->redirect($url,$msg,$msgtype);

	}
	/**
	 * Init Basics
	 * @return unknown_type
	 */
	function init($config=null)
	{
		$this->config=$config;
		self::initTemplate();
	}

	/**
	 * Init Templates
	 * @return unknown_type
	 */

	function initTemplate()
	{
		global $option;
		$gapp =& JFactory::getApplication();

		$gapp->set('gbTemplate'.$option,$this->config->get('template','default'));

	}

	function setTemplate($template=null)
	{

		if(is_null($template))
		{
			return false;
		}
		$gapp =& JFactory::getApplication();
		$gapp->set('gbTemplate',$template);

	}

	function message($msg,$msgtype='message')
	{

		$gapp=self::getInstance('site');

		$gapp->enqueueMessage($msg,$msgtype);
	}

	function triggerEvent($event, $args=null)
	{
		gbimport("gobingoo.dispatcher");
		
		$dispatcher =& GDispatcher::getInstance();
		return $dispatcher->trigger($event, $args);
	}
	
	
	function initializeSession($config=null)
	{
		$this->_createSession(JUtility::getHash($config['session_name']));
		
	}
	
	function initLocale()
	{
		
	}


}





?>