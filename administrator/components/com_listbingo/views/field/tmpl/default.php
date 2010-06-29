<?php
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Extrafield':'Add Extrafield';
JToolBarHelper::title(JText::_($titlestring), 'fields.png');
JToolBarHelper::save("fields.save");
JToolBarHelper::apply("fields.apply");
JToolBarHelper::cancel("fields");

gbimport("css.icons");

$editor=&JFactory::getEditor();

?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
<input type="hidden" name="id" id="id"
	value="<?php echo $this->row->id?>" />
<table width="100%" cellpadding="5" cellspacing="0" border="0">
	<tr>
		<td width="65%" valign="top">
		<fieldset class="adminform"><legend>Extrafield Details</legend>
		<table width="100%" cellpadding="5" class="admintable">
			<tr>
				<td width="10%" valign="top" class="key"><?php echo JText::_('TITLE');?></td>
				<td width="40%"><input name="title" type="text" class="inputbox"
					id="title" value="<?php echo $this->row->title?>" size="45" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="top" class="key"><?php echo JText::_('TYPE');?></td>
				<td><?php echo $this->lists['types'];?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td width="10%" valign="top" class="key"><?php echo JText::_('DEFAULT_VALUE');?></td>
				<td width="40%"><input name="default_value" type="text"
					class="inputbox" id="default_value"
					value="<?php echo $this->row->default_value?>" size="45" /></td>
				<td>&nbsp;</td>
			</tr>

			
			
				<tr>
				<td valign="top" class="key"><?php echo JText::_('ACCESS');?></td>
				<td><?php echo $this->lists['access'];?></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="top" class="key"><?php echo JText::_('REQUIRED');?></td>
				<td><?php echo $this->lists['required'];?>&nbsp;(<?php echo JText::_('If Yes, the field is compulsory in the form');?>)</td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="top" class="key"><?php echo JText::_('PUBLISHED');?></td>
				<td><?php echo $this->lists['published'];?></td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td colspan="3" align="left" valign="top"><strong><?php echo JText::_('DESCRIPTION');?></strong></td>
			</tr>
			<tr>
				<td colspan="3" valign="top"><?php echo $editor->display('description',$this->row->description,'100%','250','40','5'); ?></td>
			</tr>
		</table>
		</fieldset>
		</td>
		<td valign="top">
		
		<fieldset class="adminform"><legend><?php echo JText::_('FIELD_PARAMETERS');?></legend>
		<table width="100%" cellpadding="5" class="admintable">
			
		
			
			<!--

			<tr>
				<td valign="top" class="key"><?php echo JText::_('INFOBAR');?></td>
				<td><?php echo $this->lists['infobar'];?></td>
				<td>&nbsp;</td>
			</tr>

			<tr>
				<td valign="top" class="key"><?php echo JText::_('ICON_FOR_INFOBAR');?></td>
				<td><?php echo $this->lists['image_list'];?></td>
				<td>&nbsp;</td>
			</tr>


			-->
			<tr>
				<td valign="top" class="key"><?php echo JText::_('HIDE_CAPTION');?></td>
				<td><?php echo $this->lists['hidecaption'];?></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td valign="top" class="key"><?php echo JText::_('SHOW_IN_SUMMARY');?></td>
				<td><?php echo $this->lists['view_in_summary'];?></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td valign="top" class="key"><?php echo JText::_('SHOW_IN_DETAIL');?></td>
				<td><?php echo $this->lists['view_in_detail'];?></td>
				<td>&nbsp;</td>
			</tr>
			
			
			<tr>
				<td width="10%" valign="top" class="key" rowspan="2"><?php echo JText::_('EDIT_PREFIX_SUFFIX');?></td>
				<td width="40%"><input name="edit_prefix" type="text" class="inputbox"
					id="edit_prefix" value="<?php echo $this->row->edit_prefix?>" size="30" /></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td width="40%"><input name="edit_suffix" type="text" class="inputbox"
					id="edit_suffix" value="<?php echo $this->row->edit_suffix?>" size="30" /></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td width="10%" valign="top" class="key" rowspan="2"><?php echo JText::_('VIEW_PREFIX_SUFFIX');?></td>
				<td width="40%"><input name="view_prefix" type="text" class="inputbox"
					id="view_prefix" value="<?php echo $this->row->view_prefix?>" size="30" /></td>
				<td>&nbsp;</td>
				</tr>
				<tr>
				<td width="40%"><input name="view_suffix" type="text" class="inputbox"
					id="view_suffix" value="<?php echo $this->row->view_suffix?>" size="30" /></td>
				<td>&nbsp;</td>
				</tr>
				
				<tr>
					<td width="10%" valign="top" class="key" rowspan="2"><?php echo JText::_('SIZE');?></td>
				<td width="40%"><input name="size" type="text" class="inputbox"
					id="size" value="<?php echo $this->row->size?>" size="10" /></td>
				<td>&nbsp;</td>
				</tr>
			
		</table>
		</fieldset>
		<fieldset class="adminform"><legend><?php echo JText::_('APPLY_TO_SETTINGS_CATEGORIES');?></legend>
		<?php echo JText::_('SELECT_CAT_TO_GET_VISIBLE');?> <br />
		<?php echo $this->lists['categories'];?></fieldset>
		</td>
	</tr>
</table>
<input type="hidden" name="option" value="<?php echo $option?>" /> 
<input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
<input
	type="hidden" name="task" value="fields" /></form>
