<fieldset class="adminform">
	<legend><?php echo JText::_( 'Locale Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Time Offset' ); ?>::<?php echo JText::_('Select Time offset for day light saving'); ?>">
						<?php echo JText::_( 'Time Offset' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[time_offset]" value="<?php echo $this->config->get('time_offset');?>" size="5" />
				</td>
			</tr>
			
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Date Format' ); ?>::<?php echo JText::_('Date format for site'); ?>e.g. %a=Sun, %d=00-31, %b=Jan, %Y=2010, %m=0-12, %H=00-23, %I=0-12, %M=00-59, %S=00-59, %T=HH:MM:SS ">
						<?php echo JText::_( 'Date Format' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[date_format]" value="<?php echo $this->config->get('date_format');?>" size="20" />
					
				</td>
			</tr>
			
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Date Only format' ); ?>::
					<?php echo JText::_('Date only format for site. This will be used where only dates are visible'); ?>e.g. %a=Sun, %d=00-31, %b=Jan, %Y=2010, %m=0-12, %H=00-23, %I=0-12, %M=00-59, %S=00-59, %T=HH:MM:SS">
						<?php echo JText::_( 'Date Only Format' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[dateonlyformat]" value="<?php echo $this->config->get('dateonlyformat');?>" size="20" />
				
				</td>
			</tr>
			
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Time Only format' ); ?>::<?php echo JText::_('Time only format for site. This will be used where only dates are visible'); ?>
					e.g. %a=Sun, %d=00-31, %b=Jan, %Y=2010, %m=0-12, %H=00-23, %I=0-12, %M=00-59, %S=00-59, %T=HH:MM:SS">
						<?php echo JText::_( 'Time Only Format' ); ?>
					</span>
					
				</td>
				<td valign="top">
					<input type="text" name="config[timeonlyformat]" value="<?php echo $this->config->get('timeonlyformat');?>" size="20" />
					
				</td>
			</tr>
			
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Currency Format' ); ?>::<?php echo JText::_('Currency Format '); ?>">
						<?php echo JText::_( 'Currency Format' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[currency_format]" value="<?php echo $this->config->get('currency_format');?>" size="20" />
					%C=Currency
					%S=Currency Symbol
					$V=value
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Decimals' ); ?>::<?php echo JText::_('Decimals '); ?>">
						<?php echo JText::_( 'Decimals' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[decimals]" value="<?php echo $this->config->get('decimals');?>" size="5" />
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Decimal Separator' ); ?>::<?php echo JText::_('Decimal Separator '); ?>">
						<?php echo JText::_( 'Decimal Separator' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[decimal_separator]" value="<?php echo $this->config->get('decimal_separator');?>" size="5" />
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Value Separator' ); ?>::<?php echo JText::_('Value Separator. Thousand Separator '); ?>">
						<?php echo JText::_( 'Value Separator' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[value_separator]" value="<?php echo $this->config->get('value_separator');?>" size="5" />
				</td>
			</tr>
			
			
		</tbody>
	</table>
</fieldset>