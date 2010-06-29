<?php
$param = null;

?>
	<table class="noshow"  >
	
			
			<tr>
			
				<td width="50%">
		<fieldset class="adminform"><legend><?php
echo JText::_ ( 'Core Fields Settings' );
?></legend>
<table class="adminlist" cellspacing="1">
	<thead>
	<tr>
	<th>
	<?php echo JText::_("Field Name");?>
	</th><th>
	<?php echo JText::_("Enabled");?>
	</th>
	<th><?php echo JText::_("Required");?></th>
	</tr></thead>
	<tbody>
	
			<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Price' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Price  will be displayed. This applies to all categories' );
				?>">
						<?php
						echo JText::_ ( 'Price ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_price]', 1, $this->config->get ( 'enable_field_price' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center">---
			
			
				</td>
		</tr>
		
		<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Address1' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Address1  will be displayed.' );
				?>">
						<?php
						echo JText::_ ( 'Address1 ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_address1]', 1, $this->config->get ( 'enable_field_address1' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[required_field_address1]', 1, $this->config->get ( 'required_field_address1' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		
		<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Address2' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Address2  will be displayed.' );
				?>">
						<?php
						echo JText::_ ( 'Address2 ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_address2]', 1, $this->config->get ( 'enable_field_address2' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[required_field_address2]', 1, $this->config->get ( 'required_field_address2' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Zipcode' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, zipcode  will be displayed.' );
				?>">
						<?php
						echo JText::_ ( 'Zipcode ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_zipcode]', 1, $this->config->get ( 'enable_field_zipcode' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[required_field_zipcode]', 1, $this->config->get ( 'required_field_zipcode' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		
		<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Tags' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, tags  will be displayed.' );
				?>">
						<?php
						echo JText::_ ( 'Tags ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_tags]', 1, $this->config->get ( 'enable_field_tags' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[required_field_tags]', 1, $this->config->get ( 'required_field_tags' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		
		<tr>
			<td class="key" style="width:200px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'MetaDesc' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, metadesc  will be displayed.' );
				?>">
						<?php
						echo JText::_ ( 'Metadesc ' );
						?>
					</span></td>
			<td valign="top" align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_field_metadesc]', 1, $this->config->get ( 'enable_field_metadesc' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
					<td valign="top"  align="center"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[required_field_metadesc]', 1, $this->config->get ( 'required_field_metadesc' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
	</tbody>
</table>
</fieldset>
</td>
				<td> 
				<h2>Core Field Settings</h2>
				Enable Disable Core Fields at your will. You can set it as required or not required for each core fields. 
				</td>
				
			</tr>
			
		</table>