<?php
/**
 * @package		Listbingo
 * @copyright (C) 2009 by gobingoo.com - All rights reserved!
 *
 */

// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.model");

class ListbingoModelConfiguration extends GModel
{
	/**
	 * Configuration data
	 *
	 * @var object
	 **/
	var $_params;

	/**
	 * Configuration for ini path
	 *
	 * @var string
	 **/
	// 	var $_ini	= '';

	/**
	 * Configuration for xml path
	 *
	 * @var string
	 **/
	var $_xml	= '';

	/**
	 * Constructor
	 */
	function __construct()
	{
		$mainframe	=& JFactory::getApplication();

		// Test if ini path is set
		if( empty( $this->_xml ) )
		{
			$this->_xml	= JPATH_COMPONENT . DS . 'config.xml';
		}

		// Call the parents constructor
		parent::__construct();

		// Get the pagination request variables
		$limit		= $mainframe->getUserStateFromRequest( 'global.list.limit', 'limit', $mainframe->getCfg('list_limit'), 'int' );
		$limitstart	= $mainframe->getUserStateFromRequest( 'configuration.limitstart', 'limitstart', 0, 'int' );

		// In case limit has been changed, adjust limitstart accordingly
		$limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);

		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
	}

	/**
	 * Returns the configuration object
	 *
	 * @return object	JParameter object
	 **/
	function getParams()
	{
		global $option;
		// Test if the config is already loaded.
		if( !$this->_params )
		{
			jimport( 'joomla.filesystem.file');
			$ini	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $option . DS . 'default.ini';
			$data	= JFile::read($ini);
				
			// Load default configuration
			$this->_params	= new JParameter( $data );

			$config =& JTable::getInstance('component');
			$config->loadByOption( "com_listbingo" );
				
				
			// Bind the user saved configuration.
			$this->_params->bind( $config->params );
		}
		return $this->_params;
	}

	/**
	 * Save the configuration to the config file
	 *
	 * @return boolean	True on success false on failure.
	 **/
	function save($postData)
	{
		jimport('joomla.filesystem.file');

		$config =& JTable::getInstance('component');
		$config->loadByOption( "com_listbingo" );
		
		

		$registry	=& JRegistry::getInstance( 'listbingo' );
		$registry->loadINI( $config->params , 'listbingo' );



		foreach( $postData['config'] as $key => $value )
		{
			
				$registry->setValue( 'listbingo.' . $key , $value );
			

		}
		
		// Get the complete INI string
		$config->params	= $registry->toString( 'INI' , 'listbingo' );
		// Save it
		if(!$config->store() )
		{
			return false;
		}
		return true;
	}
}