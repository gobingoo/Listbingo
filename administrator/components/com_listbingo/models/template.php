<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ad.php 2010-01-10 00:57:37 svn $
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
gbimport("gobingoo.model");

class ListbingoModelTemplate extends GModel {

	var $_count=0;
	function __construct()
	{
		parent::__construct();
	}

	function getList()
	{
		global $option;
		$templatehelper=gbimport("gobingoo.templateshelper");
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$templates=GTemplatesHelper::parseXMLTemplateFiles($templatepath);
		return $templates;
	}

	function load($template)
	{
		global $option;
		$templatehelper=gbimport("gobingoo.templateshelper");
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";
		//		$templates=GTemplatesHelper::parseXMLTemplateFiles($templatepath);

		if (!is_dir( $templatepath . DS . $template )) {
			return JError::raiseWarning( 500, JText::_('Template not found') );
		}


/*		$lang =& JFactory::getLanguage();
		$lang->load( 'tpl_'.$template, JPATH_ADMINISTRATOR );*/


		$row	= GTemplatesHelper::parseXMLTemplateFile($templatepath, $template);

		return $row;

	}

	function remove($cid=array())
	{
		global $option;

		if(count($cid))
		{

			$installer =& JInstaller::getInstance();
			$adaptherPath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."libraries".DS."adapters".DS."template.php";
			require_once($adaptherPath);
			$adapterobj=new JInstallerTemplate($installer);

			$installer->setAdapter('template',$adapterobj);

			foreach($cid as $c)
			{
				$installer->uninstall('template', $c, 0 );
			}

			return true;
		}
	}

	function getListCount()
	{

	}
	
	function save()
	{
		
	}



}
?>