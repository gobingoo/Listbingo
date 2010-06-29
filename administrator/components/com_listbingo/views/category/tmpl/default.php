<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: default.php 2010-01-10 00:57:37 svn $
 * @author gobingoo.com
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
$titlestring=($this->edit)?'Edit Category':'Add Category';
JToolBarHelper::title(JText::_($titlestring), 'category.png');
JToolBarHelper::save("categories.save");
JToolBarHelper::apply("categories.apply");
JToolBarHelper::cancel("categories");

gbimport("css.icons");

$editor=&JFactory::getEditor();

?>


<form name="adminForm" id="adminForm" action="index.php" method="post"  enctype="multipart/form-data">
<input type="hidden" name="id" id="id"
	value="<?php echo $this->row->id?>" />
<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_('CATEGORY_DETAILS');?></legend>
<table width="100%" cellpadding="5" class="admintable">
	<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('TITLE');?></td>
		<td width="40%"><input name="title" type="text" class="inputbox"
			id="title" value="<?php echo $this->row->title?>" size="45" /></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td valign="top" class="key"><?php echo JText::_('ALIAS');?></td>
		<td><input name="alias" type="text" class="inputbox" id="alias"
			value="<?php echo $this->row->alias?>" size="45" /></td>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td valign="top" class="key"><?php echo JText::_('IS_PRICE_APPLICABLE');?></td>
		<td><?php echo $this->lists['hasprice'];?></td>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<td valign="top" class="key"><?php echo JText::_('ACCESS');?></td>
		<td><?php echo $this->lists['access'];?></td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td valign="top" class="key"><?php echo JText::_('PUBLISHED');?></td>
		<td><?php echo $this->lists['published'];?></td>
		<td>&nbsp;</td>
	</tr>
</table>

<table width="100%" cellpadding="5" class="admintable">

	<tr>
		<td colspan="3" align="left" valign="top"><strong><?php echo JText::_('DESCRIPTION');?></strong></td>
	</tr>
	<tr>
		<td colspan="3" valign="top"><?php echo $editor->display('description',$this->row->description,'100%','250','40','5'); ?></td>
	</tr>
</table>
</fieldset>
</div>

<div class="col width-50">

<?php 
if($this->params->get('category_enable_logo')==1)
{
?>
<div id="imageholder">
<fieldset class="adminform">
  <legend><?php echo JText::_('LOGO_IMAGE');?></legend>
<table width="100%" cellpadding="5" class="admintable">		

	<tr>

		<td valign="top" class="key"><?php echo JText::_('EXISTING_LOGO');?></td>
		<td><img src="<?php echo JUri::root().$this->row->logo;?>"/></td>
		<td>&nbsp;</td>

	</tr>
	
	<tr>

		<td valign="top" class="key"><?php echo JText::_('LOGO');?></td>
		<td><input type="file" size="35" name="logo" class="inputbox"/></td>
		<td>&nbsp;</td>

	</tr>
</table>
</fieldset>
</div>
<?php 
}
?>

<fieldset class="adminform"><legend><?php echo JText::_('ASSIGN_PARENT');?></legend>
<table width="100%" cellpadding="5" class="admintable">

	<tr>
		<td valign="top" class="key"><?php echo JText::_('PARENT_CATEGORY');?></td>
		<td><?php echo $this->lists['parent'];?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td valign="top" class="key"><?php echo JText::_('RELATED_CATEGORY');?></td>
		<td><?php echo $this->lists['related'];?></td>
		<td>&nbsp;</td>
	</tr>
</table>
</fieldset>
</div>
<input type="hidden" name="option" value="<?php echo $option?>" /> 
<input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
<input
	type="hidden" name="task" value="categories" /></form>
