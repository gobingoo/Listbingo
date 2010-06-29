<?php
/**
 *
 *
 */

defined('JPATH_BASE') or die();
gbimport("gobingoo.addonscontroller");

class GControllerCaptcha_Admin extends GAddonsController
{
	private $mySess;
	private $debugMode;

	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask( 'apply',		'save' );
		$this->registerTask( 'orderup',	'order' );
		$this->registerTask( 'orderdown',	'order' );

	}

	function display()
	{

		$view=$this->getView("captchas","html",true);

		$view->display();
	}

	function captchaSettingsPage($params=null)
	{
		$view=$this->getView('settings','html',true);
		$view->assignRef('config',$params);
		$view->display();
	}

	function getFonts()
	{
		$path	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . 'com_listbingo' . DS . 'addons' . DS . 'captcha' . DS . 'fonts';

		jimport( 'joomla.filesystem.file' );
		$fonts = array();
		if( $handle = @opendir($path) )
		{
			while( false !== ( $file = readdir( $handle ) ) )
			{
				if( JFile::getExt($file) === 'ttf')
				$fonts[JFile::stripExt($file)]	= JFile::stripExt($file);
			}
		}
		return $fonts;
	}

	function generateCaptchaImage()
	{
		global $option;
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.$option . DS .'addons' . DS .'captcha'. DS . 'libraries' . DS . 'utils.php' );
		
		$utils = new XiJCUtils($this->debugMode);
		$utils->generateCaptchaImage();
		die();
	}

	//verify capctcha
	function _verifyCaptcha()
	{
		global $mainframe;

		$value	= JRequest::getVar('xiCaptchaValue','0','POST');

		if(!$value)
		return false;

		// test the give key and value, sending key as 0 b'coz it's not required
		// will collect it from session
		$utils = XiJCUtils::getObject($this->debugMode);
		return $utils->_keyValuePair('GET',0, $value);
	}

}
?>