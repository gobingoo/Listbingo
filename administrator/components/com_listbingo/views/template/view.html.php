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

class ListbingoViewTemplate extends GView
{
	function display($tpl = null)
	{

		global $option;

		$cid		= JRequest::getVar('cid', array(), 'method', 'array');
		$cid		= array(JFilterInput::clean(@$cid[0], 'cmd'));
		$template	= $cid[0];
		$option		= JRequest::getCmd('option');

		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		
		$templatehelper=gbimport("gobingoo.templateshelper");
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";

		if($template)
		{
			$edit = true;
		}
		else
		{
			$edit = false;
		}

		$model=gbimport("listbingo.model.template");
		$row = $model->load($template);

		$ini	= $templatepath.DS.$template.DS.'params.ini';
		$xml	= $templatepath.DS.$template.DS.'template.xml';

		jimport('joomla.filesystem.file');
		// Read the ini file
		if (JFile::exists($ini))
		{
			$content = JFile::read($ini);
		}
		else
		{
			$content = null;
		}

		$params = new JParameter($content, $xml, 'gbtemplate');

		$lists = array();

		/*$assigned = TemplatesHelper::isTemplateAssigned($row->directory);
		 $default = TemplatesHelper::isTemplateDefault($row->directory, $client->id);
		 gbimport('listbingo.template');
		 if($client->id == '1')
		 {
			$lists['selections'] =  JText::_('Cannot assign an administrator template');
			}
			else
			{
			$lists['selections'] = TemplatesHelper::createMenuList($template);
			}

			if ($default)
			{
			$row->pages = 'all';
			}
			elseif (!$assigned)
			{
			$row->pages = 'none';
			}
			else
			{
			$row->pages = null;
			}*/

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');

		$this->assignRef('row',$row);
		$this->assignRef('edit',$edit);
		$this->assignRef('client',$client);
		$this->assignRef('ftp',$ftp);
		$this->assignRef('lists',$lists);
		$this->assignRef('params',$params);
		parent::display($tpl);
	}

	function customDisplay($tpl=null)
	{
		parent::display($tpl);
	}

	function installDisplay($tpl=null)
	{
		global $mainframe;
		$model	= gbimport("listbingo.model.template");

		$model->setState( 'install.directory', $mainframe->getCfg( 'config.tmp_path' ));

		$this->setModel( $model, true );
		/*
		 * Set toolbar items for the page
		 */


		$paths = new stdClass();
		$paths->first = '';

		$this->assignRef('paths', $paths);
		$this->assignRef('state', $this->get('state'));

		parent::display($tpl=null);
	}
}
?>