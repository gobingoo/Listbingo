<?php
/**
 * @version		$Id: install.listbingo.php 
 * @package		LISTBINGO
 * @author    	Gobingoo http://www.gobingoo.com
 * @copyright	Copyright (c) 2009 - 2010 Gobingoo. All rights reserved.
 * @license		GNU/GPL license: http://www.gnu.org/copyleft/gpl.html
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

jimport('joomla.installer.installer');
$db = & JFactory::getDBO();
$status = new JObject();
$status->modules = array();
$status->plugins = array();
$src = $this->parent->getPath('source');

$modules = &$this->manifest->getElementByPath('modules');
if (is_a($modules, 'JSimpleXMLElement') && count($modules->children())) 
{
	foreach ($modules->children() as $module) 
	{
		$mname = $module->attributes('module');
		$client = $module->attributes('client');
		if(is_null($client)) $client = 'site';
		($client=='administrator')? $path=$src.DS.'administrator'.DS.'modules'.DS.$mname: $path = $src.DS.'modules'.DS.$mname;
		$installer = new JInstaller;
		$result = $installer->install($path);
		$status->modules[] = array('name'=>$mname,'client'=>$client, 'result'=>$result);
	}
}


$plugins = &$this->manifest->getElementByPath('plugins');
if (is_a($plugins, 'JSimpleXMLElement') && count($plugins->children())) 
{
	
	foreach ($plugins->children() as $plugin) 
	{
		$pname = $plugin->attributes('plugin');
		$pgroup = $plugin->attributes('group');
		$path = $src.DS.'plugins'.DS.$pgroup;
		$installer = new JInstaller;
		$result = $installer->install($path);
		$status->plugins[] = array('name'=>$pname,'group'=>$pgroup, 'result'=>$result);
		
		$query = "UPDATE #__plugins SET published=1 WHERE element='{$pname}' AND folder='{$pgroup}'";
		$db->setQuery($query);
		$db->query();
	}
}

?>

<?php $rows = 0;?>
<img src="<?php echo JUri::root();?>administrator/components/com_listbingo/images/feedbingo-logo.png" width="100" height="100" alt="Listbingo Component" align="right" />
<h2><?php echo JText::_('Listbingo Installation Status'); ?></h2>
<table class="adminlist">
	<thead>
		<tr>
			<th class="title" colspan="2"><?php echo JText::_('Extension'); ?></th>
			<th width="30%"><?php echo JText::_('Status'); ?></th>
		</tr>
	</thead>
	<tfoot>
		<tr>
			<td colspan="3"></td>
		</tr>
	</tfoot>
	<tbody>
		<tr class="row0">
			<td class="key" colspan="2"><?php echo 'Listbingo '.JText::_('Component'); ?></td>
			<td><strong><?php echo JText::_('Installed'); ?></strong></td>
		</tr>
		<?php if (count($status->modules)) : ?>
		<tr>
			<th><?php echo JText::_('Module'); ?></th>
			<th><?php echo JText::_('Client'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->modules as $module) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo $module['name']; ?></td>
			<td class="key"><?php echo ucfirst($module['client']); ?></td>
			<td><strong><?php echo ($module['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach;?>
		<?php endif;?>
		<?php if (count($status->plugins)) : ?>
		<tr>
			<th><?php echo JText::_('Plugin'); ?></th>
			<th><?php echo JText::_('Group'); ?></th>
			<th></th>
		</tr>
		<?php foreach ($status->plugins as $plugin) : ?>
		<tr class="row<?php echo (++ $rows % 2); ?>">
			<td class="key"><?php echo ucfirst($plugin['name']); ?></td>
			<td class="key"><?php echo ucfirst($plugin['group']); ?></td>
			<td><strong><?php echo ($plugin['result'])?JText::_('Installed'):JText::_('Not installed'); ?></strong></td>
		</tr>
		<?php endforeach; ?>
		<?php endif; ?>
	</tbody>
</table>
