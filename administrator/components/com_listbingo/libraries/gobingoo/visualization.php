<?php
/**
 * @package Gobingoo
 * @subpackage Visualization
 * 
 * @author alex@gobingoo.com
 * 
 * code Alex
 * 
 * A google visualization API Class
 * 
 
 */


class GVisualization
{
	
	var $columns=array();
	var $data=array();
	var $element=null;
	
	
	function __construct()
	{
		
	}
	
	function setColumns($columns=array())
	{
		$this->columns=$columns;
	}
	
	function setData($data=array())
	{
		$this->data=$data;
	}
	
	function draw($el='')
	{
		$this->element=$el;
		gbext("js","http://www.google.com/jsapi");
	
		
	}
	
	function drawData()
	{
		
		if(count($this->columns)>0)
		{
			?>
			 var data<?php echo $this->element;?> = new google.visualization.DataTable();
			
			<?
			foreach($this->columns as $value=>$key)
			{
			?>
			data<?php echo $this->element;?>.addColumn('<?php echo $key;?>', '<?php echo $value;?>');
			<?php				
			}
		}
		if(count($this->data)>0)
		{
			
			$data=array();
			foreach($this->data as $d)
			{
				$newd=array();
				if(count($d)>0)
				{
					
					foreach($d as $xd)
					{
						if(is_string($xd))
						{
							$newd[]="'".$xd."'";
						}
						else
						{
							$newd[]=$xd;
						}
					}
				}
				$data[]='['.implode(",",$newd).']';
			}
			
			?>
			data<?php echo $this->element;?>.addRows([<?php echo implode(",",$data)?>]);
			<?php
			
		}
	}
	
	function getInstance($entity,$package=false, $prefix = "GVisualization")
	{
		global $option;
		// use a static array to store controller instances
		static $vinstances;
		if (!$vinstances) {
			$vinstances = array();
		}
		// determine subclass name
		$class = $prefix.ucfirst($entity);

		// check if we already instantiated this controller
		if (!isset($vinstances[$class])) {
			// check if we need to find the controller class
			if (!class_exists($class)) {
				jimport('joomla.filesystem.file');
				 $path = JPATH_ADMINISTRATOR.DS."components".DS.$option.DS.'libraries'.DS."visualizations".DS.strtolower($entity).'.php';
				// search for the file in the controllers path
				if (JFile::exists($path)) {
					// include the class file
					require_once $path;
					if (!class_exists($class)) {
						// class file does not include the class
						throw new VisualizationException(JText::_('Invalid visualization'),400);


					}
				} else {
					// class file not found
					throw new VisualizationException(JText::_('Unknown visualization'),400);


				}
			}
			// create controller instance
			$vinstances[$class] = new $class($package);
		}
		// return a reference to the controller
		return $vinstances[$class];
	}
	
	
}



?>