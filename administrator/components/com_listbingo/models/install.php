<?php


// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die( 'Restricted access' );

gbimport("gobingoo.model");
jimport( 'joomla.installer.installer' );
jimport('joomla.installer.helper');

/**
 * Extension Manager Install Model
 *
 * @package		Joomla
 * @subpackage	Installer
 * @since		1.5
 */
class ListbingoModelInstall extends GModel
{
	/** @var object JTable object */
	var $_table = null;

	/** @var object JTable object */
	var $_url = null;

	/**
	 * Overridden constructor
	 * @access	protected
	 */
	function __construct()
	{
		parent::__construct();

	}

	function install()
	{
			
		global $mainframe,$option;

		$this->setState('action', 'install');

		switch(JRequest::getWord('installtype'))
		{
			case 'folder':
				$package = $this->_getPackageFromFolder();
				break;

			case 'upload':
				$package = $this->_getPackageFromUpload();
				break;

			case 'url':
				$package = $this->_getPackageFromUrl();
				break;

			default:
				$this->setState('message', 'No Install Type Found');
				return false;
				break;
		}



		// Was the package unpacked?
		if (!$package) {
			$this->setState('message', 'Unable to find install package');
			return false;
		}

		// Get a database connector
		//$db = & JFactory::getDBO();

		// Get an installer instance
		$installer =& JInstaller::getInstance();

		switch($package['type'])
		{
			case 'addon':
				$adaptherPath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."libraries".DS."adapters".DS."addon.php";
				require_once($adaptherPath);
				$adapterobj=new JInstallerAddon($installer);
				$installer->setAdapter('addon',$adapterobj);
				break;

			case 'template':
				$adaptherPath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."libraries".DS."adapters".DS."template.php";
				require_once($adaptherPath);
				$templateobj=new JInstallerTemplate($installer);
				//var_dump($templateobj);exit;
				$installer->setAdapter('template',$templateobj);
				break;
		}

		// Install the package
		if (!$installer->install($package['dir'])) {
			//echo "here";exit;
			// There was an error installing the package
			$msg = JText::sprintf('ADDON_INSTALL_ERROR', JText::_($package['type']), JText::_('Error'));
			$result = false;
		} else {
			//echo "else";exit;
			// Package installed sucessfully
			$msg = JText::sprintf('ADDON_INSTALL_SUCCESS', JText::_($package['type']), JText::_('Success'));
			$result = true;
		}



		// Set some model state values
		$mainframe->enqueueMessage($msg);
		$this->setState('name', $installer->get('name'));
		$this->setState('result', $result);
		$this->setState('message', $installer->message);
		$this->setState('extension.message', $installer->get('extension.message'));

		// Cleanup the install files
		if (!is_file($package['packagefile'])) {
			$config =& JFactory::getConfig();
			$package['packagefile'] = $config->getValue('config.tmp_path').DS.$package['packagefile'];
		}

		JInstallerHelper::cleanupInstall($package['packagefile'], $package['extractdir']);

		return $result;
	}

	/**
	 * @param string The class name for the installer
	 */
	function _getPackageFromUpload()
	{
		// Get the uploaded file information
		$userfile = JRequest::getVar('install_package', null, 'files', 'array' );

		// Make sure that file uploads are enabled in php
		if (!(bool) ini_get('file_uploads')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLFILE'));
			return false;
		}

		// Make sure that zlib is loaded so that the package can be unpacked
		if (!extension_loaded('zlib')) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLZLIB'));
			return false;
		}

		// If there is no uploaded file, we have a problem...
		if (!is_array($userfile) ) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('No file selected'));
			return false;
		}

		// Check if there was a problem uploading the file.
		if ( $userfile['error'] || $userfile['size'] < 1 )
		{
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('WARNINSTALLUPLOADERROR'));
			return false;
		}

		// Build the appropriate paths
		$config =& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path').DS.$userfile['name'];
		$tmp_src	= $userfile['tmp_name'];

		// Move uploaded file
		jimport('joomla.filesystem.file');
		$uploaded = JFile::upload($tmp_src, $tmp_dest);

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest);

		return $package;
	}

	/**
	 * Install an extension from a directory
	 *
	 * @static
	 * @return boolean True on success
	 * @since 1.0
	 */
	function _getPackageFromFolder()
	{
		// Get the path to the package to install
		$p_dir = JRequest::getString('install_directory');
		$p_dir = JPath::clean( $p_dir );

		// Did you give us a valid directory?
		if (!is_dir($p_dir)) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Please enter a package directory'));
			return false;
		}

		// Detect the package type
		$type = JInstallerHelper::detectType($p_dir);

		// Did you give us a valid package?
		if (!$type) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Path does not have a valid package'));
			return false;
		}

		$package['packagefile'] = null;
		$package['extractdir'] = null;
		$package['dir'] = $p_dir;
		$package['type'] = $type;

		return $package;
	}

	/**
	 * Install an extension from a URL
	 *
	 * @static
	 * @return boolean True on success
	 * @since 1.5
	 */
	function _getPackageFromUrl()
	{
		// Get a database connector
		$db = & JFactory::getDBO();

		// Get the URL of the package to install
		$url = JRequest::getString('install_url');

		// Did you give us a URL?
		if (!$url) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Please enter a URL'));
			return false;
		}

		// Download the package at the URL given
		$p_file = JInstallerHelper::downloadPackage($url);

		// Was the package downloaded?
		if (!$p_file) {
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Invalid URL'));
			return false;
		}

		$config =& JFactory::getConfig();
		$tmp_dest 	= $config->getValue('config.tmp_path');

		// Unpack the downloaded package file
		$package = JInstallerHelper::unpack($tmp_dest.DS.$p_file);

		return $package;
	}
}