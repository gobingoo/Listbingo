<?php
/**
 * Joomla! 1.5 component listbingo
 *
 * @version $Id: view.html.php 2009-11-17 10:19:05 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage Listbingo
 * @license GNU/GPL
 *
 * Code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class CaptchaViewSettings extends GAddonsView
{
	function display($tpl = null) 
	{
		jimport('joomla.html.pane');
		$pane	=& JPane::getInstance('sliders');
		
		$controller=gbaddons("captcha.controller.admin");
		$fonts = $controller->getFonts();
		
		$this->assign( 'fonts' , $fonts );
		$this->assignRef( 'pane', $pane );
		parent::display($tpl);
	}
}
?>