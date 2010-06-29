<?php 

// no direct access
defined('_JEXEC') or die('Restricted access');

/**
 * @package		Joomla
 * @subpackage	Templates
 */
class GTemplatesHelper
{
	

	function parseXMLTemplateFiles($templateBaseDir)
	{
		// Read the template folder to find templates
		
		jimport('joomla.filesystem.folder');
		$templateDirs = JFolder::folders($templateBaseDir);

		$rows = array();

		// Check that the directory contains an xml file
		foreach ($templateDirs as $templateDir)
		{
			if(!$data = GTemplatesHelper::parseXMLTemplateFile($templateBaseDir, $templateDir)){
				continue;
			} else {
				$rows[] = $data;
			}
		}

		return $rows;
	}

	function parseXMLTemplateFile($templateBaseDir, $templateDir)
	{
		// Check of the xml file exists
		if(!is_file($templateBaseDir.DS.$templateDir.DS.'template.xml')) {
			return false;
		}

		 $xml = JApplicationHelper::parseXMLInstallFile($templateBaseDir.DS.$templateDir.DS.'template.xml');

		if ($xml['type'] != 'template') {
			return false;
		}

		$data = new StdClass();
		$data->directory = $templateDir;

		foreach($xml as $key => $value) {
			$data->$key = $value;
		}

		$data->checked_out = 0;
		$data->mosname = JString::strtolower(str_replace(' ', '_', $data->name));

		return $data;
	}

	function createMenuList($template)
	{
		$db =& JFactory::getDBO();

		// get selected pages for $menulist
		$query = 'SELECT menuid AS value' .
				' FROM #__templates_menu' .
				' WHERE client_id = 0' .
				' AND template = '.$db->Quote($template);
		$db->setQuery($query);
		$lookup = $db->loadObjectList();
		if (empty( $lookup )) {
			$lookup = array( JHTML::_('select.option',  '-1' ) );
		}

		// build the html select list
		$options	= JHTML::_('menu.linkoptions');
		$result		= JHTML::_('select.genericlist',   $options, 'selections[]', 'class="inputbox" size="15" multiple="multiple"', 'value', 'text', $lookup, 'selections' );
		return $result;
	}
}

?>