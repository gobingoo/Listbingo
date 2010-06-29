<?php


// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

jimport( 'joomla.event.event' );


/**
 * GEvent Class
 *
 * @abstract
 * @package		Joomla.Framework
 * @subpackage	Plugin
 * @since		1.5
 */
class GEvent extends JEvent
{

	var $_taskMap=array();
	var $_methods=array();
	
	var $calledevent=null;
	/**
	 * A JParameter object holding the parameters for the plugin
	 *
	 * @var		A JParameter object
	 * @access	public
	 * @since	1.5
	 */
	var	$params	= null;

	/**
	 * The name of the plugin
	 *
	 * @var		sring
	 * @access	protected
	 */
	var $_name	= null;

	/**
	 * The plugin type
	 *
	 * @var		string
	 * @access	protected
	 */
	var $_type	= null;

	/**
	 * Constructor
	 *
	 * For php4 compatability we must not use the __constructor as a constructor for plugins
	 * because func_get_args ( void ) returns a copy of all passed arguments NOT references.
	 * This causes problems with cross-referencing necessary for the observer design pattern.
	 *
	 * @param object $subject The object to observe
	 * @param array  $config  An optional associative array of configuration settings.
	 * Recognized key values include 'name', 'group', 'params'
	 * (this list is not meant to be comprehensive).
	 * @since 1.5
	 */
	function GEvent(& $subject, $config = array())  {
		global $option;
		//Set the parameters
		if ( isset( $config['params'] ) ) {

			if(is_a($config['params'], 'JParameter')) {
				$this->params = $config['params'];
			} else {
				$this->params = new JParameter($config['params']);
			}
		}

		if ( isset( $config['name'] ) ) {
			$this->_name = $config['name'];
		}

		if ( isset( $config['type'] ) ) {
			$this->_type = $config['type'];
		}

		parent::__construct($subject,$config);
		$langpath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$this->_type;

		$lang=JFactory::getLanguage();

		$lang->load("joomla",$langpath);
		$this->_taskMap		= array();
		$this->_methods		= array();
		
		$thisMethods	= get_class_methods( get_class( $this ) );
		$baseMethods	= get_class_methods( 'GEvent' );
		$methods		= array_diff( $thisMethods, $baseMethods );
		foreach ( $methods as $method )
		{
			if ( substr( $method, 0, 1 ) != '_' ) {
				$this->_methods[] = strtolower( $method );
				// auto register public methods as tasks
				$this->_taskMap[strtolower( $method )] = $method;
			}
		}
		

		
	}

	/**
	 * Constructor
	 */
	function __construct(& $subject, $config = array())
	{
		global $option;
		//Set the parameters
		if ( isset( $config['params'] ) ) {

			if(is_a($config['params'], 'JParameter')) {
				$this->params = $config['params'];
			} else {
				$this->params = new JParameter($config['params']);
			}
		}

		if ( isset( $config['name'] ) ) {
			$this->_name = $config['name'];
		}

		if ( isset( $config['type'] ) ) {
			$this->_type = $config['type'];
		}

		parent::__construct($subject,$config);
		$langpath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$this->_type;

		$lang=JFactory::getLanguage();

		$lang->load("joomla",$langpath);
		$this->_taskMap		= array();
		$this->_methods		= array();
		
		$thisMethods	= get_class_methods( get_class( $this ) );
		$baseMethods	= get_class_methods( 'GEvent' );
		$methods		= array_diff( $thisMethods, $baseMethods );
		
		
		foreach ( $methods as $method )
		{
			
			if ( substr( $method, 0, 1 ) != '_' ) {
			
				$this->_methods[] = strtolower( $method );
				// auto register public methods as tasks
				$this->_taskMap[strtolower( $method )] = $method;
			}
		}
		
		
	}

	/**
	 * Loads the plugin language file
	 *
	 * @access	public
	 * @param	string 	$extension 	The extension for which a language file should be loaded
	 * @param	string 	$basePath  	The basepath to use
	 * @return	boolean	True, if the file has successfully loaded.
	 * @since	1.5
	 */
	function loadLanguage($extension = '', $basePath = JPATH_BASE)
	{
		if(empty($extension)) {
			$extension = 'evt_'.$this->_type.'_'.$this->_name;
		}

		$lang =& JFactory::getLanguage();
		return $lang->load( strtolower($extension), $basePath);
	}


	function registerTask($task,$method)
	{

		
	if ( in_array( strtolower( $method ), $this->_methods ) ) {
		
			$this->_taskMap[strtolower( $task )] = $method;
		}

	}
	
	function update(&$args)
	{
		/*
		 * First lets get the event from the argument array.  Next we will unset the
		 * event argument as it has no bearing on the method to handle the event.
		 */
		 $event = $args['event'];
		 $this->calledevent=$event;
	
		unset($args['event']);
		

		/*
		 * If the method to handle an event exists, call it and return its return
		 * value.  If it does not exist, return null.
		 */
		
	
		if (method_exists($this, $this->_taskMap[strtolower($event)])) {
		
			 return call_user_func_array ( array($this, $this->_taskMap[strtolower($event)]), $args );
			
			
			//return call_user_func_array ( array($this, $this->_taskMap[strtolower($event)]), $args );
		} else {
			return null;
		}
	}


}
