<fieldset class="adminform">
	<legend><?php echo JText::_( 'Template Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'SHOW DETAILS' ); ?>::<?php echo JText::_('SHOW DETAILS TIP'); ?>">
					<?php echo JText::_( 'Select template' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->getTemplatesList( 'config[template]' , $this->config->get('template') ); ?>
				</td>
			</tr>
		</tbody>
	</table>
</fieldset>