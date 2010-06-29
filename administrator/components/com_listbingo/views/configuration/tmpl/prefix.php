<fieldset class="adminform">
	<legend><?php echo JText::_( 'PREFIX' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
		
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'GLOBAL_ID_PREFIX' ); ?>::<?php echo JText::_('GLOBAL_ID_PREFIX'); ?>">
						<?php echo JText::_( 'GLOBAL_ID_PREFIX' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text"
				name="config[global_prefix]"
				value="<?php echo $this->config->get('global_prefix' );?>"
				size="40" />
				</td>
			</tr>
			
			
		</tbody>
	</table>
</fieldset>