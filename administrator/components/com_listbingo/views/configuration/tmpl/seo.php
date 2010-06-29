<fieldset class="adminform">
	<legend><?php echo JText::_( 'SEO' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable SEF' ); ?>::<?php echo JText::_('If Set to yes, Ad links are Search engine friendly. Works out of the box without any sef component'); ?>">
				<?php echo JText::_( 'Enable SEF' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_sef]' , null ,  $this->config->get('enable_sef') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Ad Detail SEO Link Format' ); ?>::<?php echo JText::_('SEO Link Format for Ad Detail page'); ?>">
						<?php echo JText::_( 'Ad Link Format' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text"
				name="config[seo_ad_link]"
				value="<?php echo $this->config->get('seo_ad_link' );?>"
				size="40" />
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Listbingo Base' ); ?>::<?php echo JText::_('Use this as base for listbingo urls'); ?>">
						<?php echo JText::_( 'Listbingo base' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text"
				name="config[seo_base]"
				value="<?php echo $this->config->get('seo_base' );?>"
				size="40" />
				</td>
			</tr>
			
			
		</tbody>
	</table>
</fieldset>