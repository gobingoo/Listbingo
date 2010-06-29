<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

gbimport("gobingoo.controller");

class GAddonsController extends GController
{
	
	function __construct($config=array())
	{
		global $option;
		
		
		$langpath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.self::getName();
		$lang=JFactory::getLanguage();
		
		$lang->load("joomla",$langpath);
		
		parent::__construct($config);
		
	}
	
	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			if ( !preg_match( '/GController(.*)_.*/i', get_class( $this ), $r ) ) {
				JError::raiseError(500, "GAddonsController::getName() : Cannot get or parse class name.");
			}
			$name = strtolower( $r[1] );
		}

		return $name;
	}


	function &getView($name = '', $type = '',$admin=false, $prefix = '', $config = array() )
	{

		global $option;
		$this->_basePath	= JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$this->getName();
		if($admin)
		{
			$config['viewpath']='admin';
			$this->_setPath( 'view', $this->_basePath.DS.'views'.DS."admin" );
		}
		else
		{
			$config['viewpath']='front';
			$this->_setPath( 'view', $this->_basePath.DS.'views'.DS."front" );
		}
		
		static $views;

		if ( !isset( $views ) ) {
			$views = array();
		}

		if ( empty( $name ) ) {
			$name = $this->getName();
		}

		if ( empty( $prefix ) ) {
			$prefix = $this->getName() . 'View';
		}

		if ( empty( $views[$name] ) )
		{
			
			if ( $view = & $this->_createView( $name, $prefix, $type, $config ) ) {
				
				 $views[$name] = & $view;
			} else {
				$result = JError::raiseError(
				500, JText::_( 'View not found [name, type, prefix]:' )
				. ' ' . $name . ',' . $type . ',' . $prefix
				);
				return $result;
			}
		}

		return $views[$name];
	}
	function &_createView( $name, $prefix = '', $type = '', $config = array() )
	{
		$result = null;

		// Clean the view name
		$viewName	 = preg_replace( '/[^A-Z0-9_]/i', '', $name );
		$classPrefix = preg_replace( '/[^A-Z0-9_]/i', '', $prefix );
		$viewType	 = preg_replace( '/[^A-Z0-9_]/i', '', $type );

		// Build the view class name
		$viewClass = $classPrefix . $viewName;

		if ( !class_exists( $viewClass ) )
		{

			jimport( 'joomla.filesystem.path' );
			$path = JPath::find(
			$this->_path['view'],
			$this->_createFileName( 'view', array( 'name' => $viewName, 'type' => $viewType) )
			);
			
			

			if ($path) {



				require_once ($path);


				if ( !class_exists( $viewClass ) ) {
					$result = JError::raiseError(
					500, JText::_( 'View class not found [class, file]:' )
					. ' ' . $viewClass . ', ' . $path );
					return $result;
				}
			} else {
				return $result;
			}
		}

		$result = new $viewClass($config);
		return $result;
	}
	
	function getModel($name,$prefix='',$config=array())
	{
		$package=self::getName();
		return gbaddons($package.".model.".$name);
	}


}
?>