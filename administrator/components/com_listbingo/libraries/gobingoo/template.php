<?php
/**
 * Class GTemplate
 * Templating system based on pattemplate
 *

 */
defined('JPATH_BASE') or die();

gbimport("gobingoo.view");

class GTemplate extends GView
{

	var $_minitemplate=null;

	function __construct($config = array())
	{
		global $option;
		parent::__construct($config );

		$gapp=JFactory::getApplication();
		$templatepath=$gapp->get('gbTemplate'.$option,'default');

		$this->_basePath	= JPATH_ROOT.DS."components".DS.$option.DS."templates".DS.$templatepath;


		$this->_setPath('template', $this->_basePath);

	}


	/**
	 * Load a template file -- first look in the templates folder for an override
	 *
	 * @access	public
	 * @param string $tpl The name of the template source file ...
	 * automatically searches the template paths and compiles as needed.
	 * @return string The output of the the template script.
	 */
	function loadTemplate( $tpl = null)
	{
		global $mainframe, $option;

		// clear prior output
		$this->_output = null;

		//create the template file name based on the layout
		$file = isset($tpl) ? $this->_layout.'_'.$tpl : $this->_layout;
		// clean the file name
		$file = preg_replace('/[^A-Z0-9_\.-]/i', '', $file);
		$tpl  = preg_replace('/[^A-Z0-9_\.-]/i', '', $tpl);

		// load the template script
		jimport('joomla.filesystem.path');

		$filetofind	= $this->_createFileName('template', array('name' => $file));
		$filetofind=$this->getName().".".$filetofind;
			
			

		$this->_template = JPath::find($this->_path['template'], $filetofind);


		if (!$this->_template != false)
		{
			$fallback_basePath	= JPATH_ROOT.DS."components".DS.$option.DS."templates".DS."default";



			$this->_template = JPath::find($fallback_basePath, $filetofind);

			if(!$this->_template != false)
			{

				return JError::raiseError( 500, 'Layout "' . $file . '" not found' );
			}

		}

		// unset so as not to introduce into template scope
		unset($tpl);
		unset($file);

		// never allow a 'this' property
		if (isset($this->this)) {
			unset($this->this);
		}

		// start capturing output into a buffer
		ob_start();
		// include the requested template filename in the local scope
		// (this will execute the view logic).
		include $this->_template;

		// done with the requested template; get the buffer and
		// clear it.
		$this->_output = ob_get_contents();
		ob_end_clean();

		return $this->_output;

	}
	/**
	 * Render mini layouts inside a big layout. That is it
	 * @param $layout
	 * @param $data
	 * @param $display
	 * @return unknown_type
	 */
	function render($layout='default',$data=array(),$display=true)
	{
		

		global $option;
		if(count($data)>0)
		{
			foreach($data as $key=>$val)
			{
				if (is_string($key) && substr($key, 0, 1) != '_')
				{
						
					$this->$key =$val;

				}
			}
				
		}

		//See if there is view attached in the layout

		$layouts=explode(".",$layout);

		//if Yes set the view name from user input
		if(count($layouts)>1)
		{

			$viewname=$layouts[0];
			$layout=$layouts[1];
		}
		else
		{
			//Else get the current view
			$viewname=$this->getName();
		}


		$filetofind	= $this->_createFileName('template', array('name' => $layout));
		$filetofind=$viewname.".".$filetofind;



		$this->_minitemplate = JPath::find($this->_path['template'], $filetofind);


		if ($this->_minitemplate == false){

			$fallback_basePath	= JPATH_ROOT.DS."components".DS.$option.DS."templates".DS."default";



			$this->_minitemplate = JPath::find($fallback_basePath, $filetofind);

			if(!$this->_minitemplate != false)
			{

				return JError::raiseError( 500, 'Layout "' . $file . '" not found' );
			}

		}



		// unset so as not to introduce into template scope
		unset($tpl);
		unset($file);

		// never allow a 'this' property
		if (isset($this->this)) {
			unset($this->this);
		}

		// start capturing output into a buffer
		ob_start();
		// include the requested template filename in the local scope
		// (this will execute the view logic).
		include $this->_minitemplate;

		// done with the requested template; get the buffer and
		// clear it.
		$output_content = ob_get_contents();
		ob_end_clean();

		if($display)
		{
			echo $output_content;
			return;
		}
		else
		{

			return $output_content;
		}



	}

	function addCSS($filepath=null)
	{
		global $option;
		if(is_null($filepath))
		{

			return false;
		}
		$gapp =& JFactory::getApplication();
		$template=$gapp->get('gbTemplate'.$option,'default');

		$csspath=str_replace(".","/",$filepath);

		$cssfullpath=JUri::root()."components/$option/templates/$template/css/$csspath".".css";
		$document=JFactory::getDocument();
		$document->addStyleSheet($cssfullpath);


	}

	function addJS($filepath=null)
	{

		global $option;
		if(is_null($filepath))
		{

			return false;
		}
		$gapp =& JFactory::getApplication();
		$template=$gapp->get('gbTemplate'.$option,'default');

		$jspath=str_replace(".","/",$filepath);

		$jsfullpath=JUri::root()."components/$option/templates/$template/js/$jspath".".js";
		$document=JFactory::getDocument();
		$document->addScript($jsfullpath);

	}

	function addJSI($filepath=null)
	{

		global $option;
		if(is_null($filepath))
		{

			return false;
		}
		$gapp =& JFactory::getApplication();
		$template=$gapp->get('gbTemplate'.$option,'default');

		$jspath=str_replace(".","/",$filepath);

		$jsfullpath=JUri::root()."components/$option/templates/$template/js/$jspath".".js";
		?>
		<script type="text/javascript" src="<?php echo $jsfullpath;?>"></script>
		
		<?php 




	}
}

?>