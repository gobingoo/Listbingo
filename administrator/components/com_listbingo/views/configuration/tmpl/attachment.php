<fieldset class="adminform"><legend><?php echo JText::_( 'Attachments' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
<tr>
	<td class="key"><span class="hasTip"
		title="<?php echo JText::_( 'Save Attachments' ); ?>::<?php echo JText::_('Save Attacments to this folder'); ?>">
		<?php echo JText::_( 'Attachments Path' ); ?> </span></td>
	<td valign="top">
	<input type="text" name="config[attachment_path]" value="<?php echo $this->config->get('attachment_path');?>"	size="30" />
		
	</td>
</tr>

<tr>
	<td class="key"><span class="hasTip"
		title="<?php echo JText::_( 'Attachment Prefix' ); ?>::<?php echo JText::_('Attachment Prefix'); ?>">
		<?php echo JText::_( 'Attachment Prefix' ); ?> </span></td>
	<td valign="top">
	<input type="text" name="config[attachment_prefix]" value="<?php echo $this->config->get('attachment_prefix');?>"	size="30" />
		
	</td>
</tr>
</tbody>
</table>
</fieldset>