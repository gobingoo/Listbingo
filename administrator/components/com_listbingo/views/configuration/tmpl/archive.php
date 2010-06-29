<?php 

?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Archive Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
		<tr>
			<td width="100%" class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Auto Archive Ads' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Ads will be automatically archived' );
				?>">
						<?php
						echo JText::_ ( 'Auto Archive Ads' );
						?>
					</span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[auto_archive]', 1, $this->config->get ( 'auto_archive' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		
			<tr>
			<td width="100%" class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Archive Ads in' );
				?>::<?php
				echo JText::_ ( 'Set the number of days to auto archive ads' );
				?>">
						<?php
						echo JText::_ ( 'Auto Archive Ads in' );
						?>
					</span></td>
			<td valign="top"><input type="text" name="config[archive_days]" value="<?php echo $this->config->get('archive_days');?>" size="5" /> Days
			
			
				</td>
		</tr>

		</tbody>
	</table>
</fieldset>