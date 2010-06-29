<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.view");
class ListbingoViewConfiguration extends GView {
	function display($tpl = null) {
		global $option;

		jimport('joomla.html.pane');
		$pane   	=& JPane::getInstance('sliders');
		$document	=& JFactory::getDocument();

		// Load tooltips
		JHTML::_('behavior.tooltip', '.hasTip');
		JHTML::_('behavior.switcher');

		$params	= $this->get( 'Params' );


		// Add submenu
		$contents = '';
		ob_start();
		require_once( JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . $option. DS . 'views' . DS . 'configuration' . DS . 'tmpl' . DS . 'navigation.php' );

		$contents = ob_get_contents();
		ob_end_clean();

		$document	=& JFactory::getDocument();

		$document->setBuffer($contents, 'modules', 'submenu');

		$lists = array();

		for ($i=1; $i<=31; $i++) {
			$qscale[]	= JHTML::_('select.option', $i, $i);
		}

		$lists['qscale'] = JHTML::_('select.genericlist',  $qscale, 'config[qscale]', 'class="inputbox" size="1"', 'value', 'text', $params->get('qscale', '11'));

		$videosSize = array
		(
		JHTML::_('select.option', '320x240', '320x240 (QVGA 4:3)'),
		JHTML::_('select.option', '400x240', '400x240 (WQVGA 5:3)'),
		JHTML::_('select.option', '400x300', '400x300 (Quarter SVGA 4:3)'),
		JHTML::_('select.option', '480x272', '480x272 (Sony PSP 30:17)'),
		JHTML::_('select.option', '480x320', '480x320 (iPhone 3:2)'),
		JHTML::_('select.option', '512x384', '512x384 (4:3)'),
		JHTML::_('select.option', '600x480', '600x480 (5:4)'),
		JHTML::_('select.option', '640x360', '640x360 (16:9)'),
		JHTML::_('select.option', '640x480', '640x480 (VCA 4:3)'),
		JHTML::_('select.option', '800x600', '800x600 (SVGA 4:3)'),
		//			JHTML::_('select.option', '856x480', '856x480 (WVGA 16:9)'),
		//			JHTML::_('select.option', '1024x576', '1024x576 (WSVGA 16:9)'),
		//			JHTML::_('select.option', '1024x768', '1024x768 (XGA 4:3)')
		);

		$lists['videosSize'] = JHTML::_('select.genericlist',  $videosSize, 'config[videosSize]', 'class="inputbox" size="1"', 'value', 'text', $params->get('videosSize'));

		$cmodel=gbimport("listbingo.model.country");
		$rmodel=gbimport("listbingo.model.region");

		$country = $cmodel->getDefaultCountry();
		$region = $rmodel->getDefaultRegion();		

		
		$lists['currencies'] = $cmodel->getCurrencyListForSelect(true);
		$validCurrencyList = $cmodel->hasValidCurrencyList(true);

		$uploadLimit = ini_get('upload_max_filesize');
		$uploadLimit = JString::str_ireplace('M', ' MB', $uploadLimit);


		$this->assignRef( 'lists', $lists );
		$this->assign( 'uploadLimit' , $uploadLimit );
		$this->assign( 'config' , $params );
		$this->assign('country',$country);
		$this->assign('region',$region);
		$this->assignRef('validcurrencylist', $validCurrencyList);

		parent::display($tpl);
	}

	function getTemplatesList($name,$val)
	{
		global $option;

		$templatefolderpath=JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$folders=JFolder::folders($templatefolderpath,'.');
		$templates=array();
		$templates[] = JHTML::_('select.option', 'default', JText::_( 'Select Template' ), 'value', 'text');
		if(count($folders)>0)
		{
			foreach($folders as $f)
			{
				$templates[] = JHTML::_('select.option', $f, JText::_( ucfirst($f) ), 'value', 'text');
			}

		}

		return JHTML::_('select.genericlist',   $templates, $name, 'class="inputbox" size="1"', 'value', 'text',$val );

	}
}
?>