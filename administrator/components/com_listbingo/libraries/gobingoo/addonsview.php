<?php
/**
 *
 * GAddonsView class extending GView
 */
// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();
gbimport("gobingoo.view");
class GAddonsView extends GView
{

	var $_addonname=null;
	function __construct($config = array())
	{
		global $option;
		parent::__construct($config );
		$viewpath=$config['viewpath'];

		$this->_basePath	= JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$this->getAddonName();
		
		
		$this->_setPath('template', $this->_basePath.DS.'views'.DS.$viewpath.DS.$this->getName().DS.'tmpl');
		
		$gapp=JFactory::getApplication();
		$templatepath=$gapp->get('gbTemplate'.$option,'default');

		$this->_templatebasepath	= JPATH_ROOT.DS."components".DS.$option.DS."templates".DS.$templatepath;


		$this->_setPath('basetemplate', $this->_templatebasepath);

	}

	function getName()
	{
		$name = $this->_name;

		if (empty( $name ))
		{
			$r = null;
			$addonname=self::getAddonName();
			
			if (!preg_match('/'.$addonname.'((view)*(.*(view)?.*))$/i', get_class($this), $r)) {
				JError::raiseError (500, "JView::getName() : Cannot get or parse class name.");
			}
			if (strpos($r[3], "view"))
			{
				
				JError::raiseWarning('SOME_ERROR_CODE',"JView::getName() : Your classname contains the substring 'view'. ".
											"This causes problems when extracting the classname from the name of your objects view. " .
											"Avoid Object names with the substring 'view'.");
			}
			 $name = strtolower( $r[3] );
		}

		return $name;
	}

	function getAddonName()
	{
		$addonname = $this->_addonname;

		if (empty( $name ))
		{
			$r = null;
			if ( !preg_match( '/(.*)View.*/i', get_class( $this ), $r ) ) {
				JError::raiseError(500, "GAddonView::getAddonName() : Cannot get or parse class name.");
			}
			$addonname = strtolower( $r[1] );
		}

		return $addonname;
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
<script
	type="text/javascript" src="<?php echo $jsfullpath;?>"></script>

		<?php




	}


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



		$this->_minitemplate = JPath::find($this->_path['basetemplate'], $filetofind);


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

}
?>