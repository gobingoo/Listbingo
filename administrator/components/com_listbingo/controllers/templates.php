<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: templates.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * Code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.controller");

jimport( 'joomla.installer.installer' );
jimport('joomla.installer.helper');

class ListbingoControllerTemplates extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);
		$this->registerTask( 'add', 'edit' );
		$this->registerTask( 'unpublish',	'publish' );
		$this->registerTask( 'apply',		'save' );
		$this->registerTask( 'applyCSS',	'saveCSS' );
		$this->registerTask( 'applyHTML',	'saveHTML' );
		$this->registerTask( 'orderup',	'order' );
		$this->registerTask( 'orderdown',	'order' );

		$this->registerTask( 'addCSS',	'editCSS' );
		$this->registerTask( 'addHTML',	'editHTML' );

	}

	function display()
	{

		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'templates');
		}
		$this->item_type = 'Default';

		parent::display();
	}

	function edit()
	{

		if(JRequest::getCmd('view') == '') {
			JRequest::setVar('view', 'template');
		}
		$this->item_type = 'Default';

		parent::display();
	}

	function cancelTemplate()
	{
		global $mainframe, $option;
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$mainframe->redirect('index.php?option='.$option.'&cid[]='.$template.'&task=templates.edit',false);
	}


	/**
	 * Unpublish Method
	 * @return unknown_type
	 */

	function install()
	{
		$view = $this->getView('template','html');
		$view->setLayout('install');
		$view->installDisplay();
	}

	function doInstall()
	{

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$model	= &$this->getModel( 'install' );

		$view	= &$this->getView( 'install' ,'html');

		/*		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		 $view->assignRef('ftp', $ftp);*/


		if ($model->install()) {
			$cache = &JFactory::getCache('mod_menu');
			$cache->clean();
		}

		$view->setModel( $model, true );
		$view->display();
	}

	function remove()
	{
		global $mainframe,$option;

		$cid = JRequest::getVar( 'default_template', array(0), '', 'array' );

		try
		{
			$model=$this->getModel('template');
			$model->remove($cid);
			$msg=JText::_('DELETED');
		}
		catch(DataException $e)
		{
			$msg=$e->getMessage();
		}

		$link=JRoute::_("index.php?option=$option&task=templates",false);
		GApplication::redirect($link,$msg);


	}

	function makeDefault()
	{
		global $mainframe, $option;
		$default = JRequest::getVar('default_template','','post','cmd');

		jimport('joomla.filesystem.file');

		$config =& JTable::getInstance('component');
		$config->loadByOption( "com_listbingo" );

		$registry	=& JRegistry::getInstance( 'listbingo' );
		$registry->loadINI( $config->params , 'listbingo' );

		$registry->setValue( 'listbingo.' . 'template' , $default );

		// Get the complete INI string
		$config->params	= $registry->toString( 'INI' , 'listbingo' );


		// Save it
		if($config->store())
		{
			$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates','Template Saved');
		}
		else
		{
			$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates','error');

		}

	}

	function chooseCSS()
	{
		global $mainframe;

		// Initialize some variables
		$option 	= JRequest::getCmd('option');
		$template	= JRequest::getVar('template', '', 'method', 'cmd');
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";

		// Determine template CSS directory
		$dir = $templatepath.DS.$template.DS.'css';

		// List template .css files
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '\.css$', false, false);

		$view = $this->getView('templates','html');
		$view->assignRef('template',$template);
		$view->assignRef('files',$files);
		$view->assignRef('dir',$dir);

		$view->setLayout('css');
		$view->customDisplay();
	}


	function editCSS()
	{
		global $mainframe;

		// Initialize some variables
		$option		= JRequest::getCmd('option');
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template	= JRequest::getVar('template', '', 'method', 'cmd');
		$filename	= JRequest::getVar('filename', '', 'method', 'cmd');

		$fullpath = $templatepath.DS.$template.DS.'css'.DS.$filename;

		jimport('joomla.filesystem.file');

		if(JFile::exists($fullpath))
		{

			if (JFile::getExt($filename) !== 'css')
			{
				$msg = JText::_('Wrong file type given, only CSS files can be edited.');
				$mainframe->redirect('index.php?option='.$option.'&task=chooseCSS&template='.$template, $msg, 'error');
			}

			$content = JFile::read($templatepath.DS.$template.DS.'css'.DS.$filename);

			if ($content !== false)
			{

				$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
				$edit=true;

				$view = $this->getView('template','html');
				$view->assignRef('content',$content);
				$view->assignRef('edit',$edit);
				$view->assignRef('templatepath',$templatepath);
				$view->assignRef('template',$template);
				$view->assignRef('filename',$filename);
				$view->setLayout('css');
				$view->customDisplay();
			}
			else
			{
				$msg = JText::sprintf('Operation Failed Could not open', $client->path.$filename);
				$mainframe->redirect('index.php?option='.$option, $msg);
			}
		}
		else
		{
			$content = "";
			$edit = false;
			$filename="";
			$view = $this->getView('template','html');
			$view->assignRef('content',$content);
			$view->assignRef('edit',$edit);
			$view->assignRef('templatepath',$templatepath);
			$view->assignRef('template',$template);
			$view->assignRef('filename',$filename);
			$view->setLayout('css');
			$view->customDisplay();
		}
	}

	function saveCSS()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$templatepath 	= JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if (!$template)
		{
			$mainframe->redirect('index.php?option='.$option, JText::_('Operation Failed').': '.JText::_('No template specified.'));
		}

		if (!$filecontent)
		{
			$mainframe->redirect('index.php?option='.$option, JText::_('Operation Failed').': '.JText::_('Content empty.'));
		}

		$file = $templatepath.DS.$template.DS.'css'.DS.$filename;

		jimport('joomla.filesystem.file');

		$return = JFile::write($file, $filecontent);

		if ($return)
		{
			$tasks=explode(".",JRequest::getCmd("task"));
			$task=array_pop($tasks);

			switch($task)
			{
				case 'saveCSS':

					$link=JRoute::_('index.php?option='.$option.'&task=templates.edit&cid[]='.$template,false);
					$msg=JText::_("SAVED");
					break;

				default:
					$link=JRoute::_('index.php?option='.$option.'&task=templates.editCSS&template='.$template.'&filename='.$filename,false);
					$msg=JText::_("APPLIED");
					break;

			}
			GApplication::redirect($link,$msg);
			//$mainframe->redirect('index.php?option='.$option.'&task=templates.edit&cid[]='.$template, JText::_('File Saved'));

		}
		else
		{
			$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseCSS', JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
		}
	}

	function cancelCSS()
	{
		global $mainframe, $option;
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseCSS',false);
	}

	function removeCSS()
	{
		global $mainframe, $option;

		$templatepath 	= JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');

		$fullpath = $templatepath.DS.$template.DS.'css'.DS.$filename;
		chmod($fullpath,777);
		unlink($fullpath);
		$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseCSS',false);
	}

	function chooseHTML()
	{
		global $mainframe;

		// Initialize some variables
		$option 	= JRequest::getCmd('option');
		$template	= JRequest::getVar('template', '', 'method', 'cmd');
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";

		// Determine template CSS directory
		$dir = $templatepath.DS.$template;

		// List template .css files
		jimport('joomla.filesystem.folder');
		$files = JFolder::files($dir, '\.php$', false, false);

		$view = $this->getView('templates','html');
		$view->assignRef('template',$template);
		$view->assignRef('files',$files);
		$view->assignRef('dir',$dir);

		$view->setLayout('html');
		$view->customDisplay();
	}


	function editHTML()
	{
		global $mainframe;

		// Initialize some variables
		$option		= JRequest::getCmd('option');
		$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template	= JRequest::getVar('template', '', 'method', 'cmd');

		$filename	= JRequest::getVar('filename', '', 'method', 'cmd');
		$fullpath	= $templatepath.DS.$template.DS.$filename;
		jimport('joomla.filesystem.file');

		if(JFile::exists($fullpath))
		{

			if (JFile::getExt($filename) !== 'php')
			{
				$msg = JText::_('Wrong file type given, only PHP files can be edited.');
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id.'&task=chooseHTML&template='.$template, $msg, 'error');
			}

			$content = JFile::read($templatepath.DS.$template.DS.$filename);

			if ($content !== false)
			{
				$content = htmlspecialchars($content, ENT_COMPAT, 'UTF-8');
				$edit = true;

				$view = $this->getView('template','html');
				$view->assignRef('content',$content);
				$view->assignRef('edit',$edit);
				$view->assignRef('templatepath',$templatepath);
				$view->assignRef('template',$template);
				$view->assignRef('filename',$filename);
				$view->setLayout('html');
				$view->customDisplay();
			}
			else
			{
				$msg = JText::sprintf('Operation Failed Could not open', $client->path.$filename);
				$mainframe->redirect('index.php?option='.$option, $msg);
			}
		}
		else
		{
			$content = "";
			$edit = false;
			$filename="";
			$view = $this->getView('template','html');
			$view->assignRef('content',$content);
			$view->assignRef('edit',$edit);
			$view->assignRef('templatepath',$templatepath);
			$view->assignRef('template',$template);
			$view->assignRef('filename',$filename);
			$view->setLayout('html');
			$view->customDisplay();
		}
	}

	function saveHTML()
	{
		global $mainframe;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		// Initialize some variables
		$option			= JRequest::getCmd('option');
		$templatepath 	= JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');
		$filecontent	= JRequest::getVar('filecontent', '', 'post', 'string', JREQUEST_ALLOWRAW);

		if (!$template)
		{
			$mainframe->redirect('index.php?option='.$option, JText::_('Operation Failed').': '.JText::_('No template specified.'));
		}

		if (!$filecontent)
		{
			$mainframe->redirect('index.php?option='.$option, JText::_('Operation Failed').': '.JText::_('Content empty.'));
		}

		$file = $templatepath.DS.$template.DS.$filename;

		jimport('joomla.filesystem.file');
		$return = JFile::write($file, $filecontent);

		if ($return)
		{
			$tasks=explode(".",JRequest::getCmd("task"));
			$task=array_pop($tasks);

			switch($task)
			{
				case 'saveHTML':

					$link=JRoute::_('index.php?option='.$option.'&task=templates.edit&cid[]='.$template,false);
					$msg=JText::_("SAVED");
					break;

				default:
					$link=JRoute::_('index.php?option='.$option.'&task=templates.editHTML&template='.$template.'&filename='.$filename,false);
					$msg=JText::_("APPLIED");
					break;

			}
			GApplication::redirect($link,$msg);

			//$mainframe->redirect('index.php?option='.$option.'&task=templates.edit&cid[]='.$template, JText::_('File Saved'));

		}
		else
		{
			$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseHTML', JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
		}
	}


	function cancelHTML()
	{
		global $mainframe, $option;
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseHTML',false);
	}

	function removeHTML()
	{
		global $mainframe, $option;

		$templatepath 	= JPATH_ROOT.DS."components".DS.$option.DS."templates";
		$template		= JRequest::getVar('template', '', 'post', 'cmd');
		$filename		= JRequest::getVar('filename', '', 'post', 'cmd');

		$fullpath = $templatepath.DS.$template.DS.$filename;
		chmod($fullpath,777);
		unlink($fullpath);
		$mainframe->redirect('index.php?option='.$option.'&template='.$template.'&task=templates.chooseHTML',false);
	}




	function save()
	{
		global $mainframe,$option;

		// Check for request forgeries
		JRequest::checkToken() or jexit( 'Invalid Token' );

		$template	= JRequest::getVar('template', '', 'method', 'cmd');
		$option		= JRequest::getVar('option', '', '', 'cmd');
		$client		=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));
		$menus		= JRequest::getVar('selections', array(), 'post', 'array');
		$params		= JRequest::getVar('params', array(), 'post', 'array');
		$default	= JRequest::getBool('default');
		JArrayHelper::toInteger($menus);

		if (!$template)
		{
			$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::_('No template specified.'));
		}

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		JClientHelper::setCredentialsFromRequest('ftp');
		$ftp = JClientHelper::getCredentials('ftp');

		$file = $client->path.DS.'components'.DS.$option.DS.'templates'.DS.$template.DS.'params.ini';

		jimport('joomla.filesystem.file');
		if (JFile::exists($file) && count($params))
		{
			$registry = new JRegistry();
			$registry->loadArray($params);
			$txt = $registry->toString();

			// Try to make the params file writeable
			if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0755')) {
				JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the template parameter file writable'));
			}

			$return = JFile::write($file, $txt);

			// Try to make the params file unwriteable
			if (!$ftp['enabled'] && JPath::isOwner($file) && !JPath::setPermissions($file, '0555')) {
				JError::raiseNotice('SOME_ERROR_CODE', JText::_('Could not make the template parameter file unwritable'));
			}

			if (!$return) {
				$mainframe->redirect('index.php?option='.$option.'&client='.$client->id, JText::_('Operation Failed').': '.JText::sprintf('Failed to open file for writing.', $file));
			}
		}

		/*// Reset all existing assignments
		 $query = 'DELETE FROM #__templates_menu' .
		 ' WHERE client_id = 0' .
		 ' AND template = '.$db->Quote( $template );
		 $db->setQuery($query);
		 $db->query();

		 if ($default) {
			$menus = array( 0 );
			}

			foreach ($menus as $menuid)
			{
			// If 'None' is not in array
			if ((int) $menuid >= 0)
			{
			// check if there is already a template assigned to this menu item
			$query = 'DELETE FROM #__templates_menu' .
			' WHERE client_id = 0' .
			' AND menuid = '.(int) $menuid;
			$db->setQuery($query);
			$db->query();

			$query = 'INSERT INTO #__templates_menu' .
			' SET client_id = 0, template = '. $db->Quote( $template ) .', menuid = '.(int) $menuid;
			$db->setQuery($query);
			$db->query();
			}
			}*/

		$tasks=explode(".",JRequest::getCmd("task"));
		$task=array_pop($tasks);

		switch($task)
		{
			case 'save':

				$link=JRoute::_("index.php?option=$option&task=templates",false);
				$msg=JText::_("SAVED");
				break;

			default:
				$link=JRoute::_("index.php?option=$option&task=templates.edit&cid[]=".$template,false);
				$msg=JText::_("APPLIED");
				break;

		}
		GApplication::redirect($link,$msg);
	}

}
?>