<?php
gbimport("gobingoo.element");

class GExtrafieldHelper
{

	function render($field=null)
	{
		if(is_object($field))
		{
			
			$element=self::getInstance($field->type);
			
			$options=new stdClass();
			$options->size=$field->size;
			$options->attributes=$field->attributes;
		
			echo $element->fetchElement($field->id,$field->title,$field->field_value,$field->required,$options);
		}
			
	}

	function renderVal($type='text',$value='')
	{	
		$element=self::getInstance($type);
		echo $element->render($value);
	}

	function getInstance($entity, $prefix = "GElement") 
	{
		// use a static array to store controller instances
		global $option;
		static $instances;
		if (!$instances) 
		{
			$instances = array();
		}
		// determine subclass name
		$class = $prefix.ucfirst($entity);

		// check if we already instantiated this controller
		if (!isset($instances[$class])) 
		{
			// check if we need to find the controller class
			if (!class_exists($class)) 
			{
				jimport('joomla.filesystem.file');
				$path = JPATH_ADMINISTRATOR.DS."components".DS.$option.DS.'libraries'.DS."elements".DS.strtolower($entity).'.php';
				// search for the file in the controllers path
				if (JFile::exists($path)) 
				{
					// include the class file
					require_once $path;
					if (!class_exists($class)) 
					{
						// class file does not include the class
						throw new ElementException(JText::_('Invalid Element'),400);


					}
				} 
				else 
				{
					// class file not found
					throw new ElementException(JText::_('Unknown Element'),400);


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