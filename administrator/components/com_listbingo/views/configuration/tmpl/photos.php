<fieldset class="adminform"><legend><?php echo JText::_( 'Folder Permission' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
<tr>
	<td class="key"><span class="hasTip"
		title="<?php echo JText::_( 'Folder Permissions' ); ?>::<?php echo JText::_('Set folder permissions.'); ?>">
		<?php echo JText::_( 'Folder Permissions' ); ?> </span></td>
	<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[usesystemfolderpermissions]' , null ,  $this->config->get('usesystemfolderpermissions' , true ) , JText::_('Use system default') , JText::_('Enable all (CHMOD 0777)') ); ?>
	</td>
</tr>
</tbody>
</table>
</fieldset>



<fieldset class="adminform"><legend><?php echo JText::_( 'Images' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
		<tr>
			<td width="300" class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Images' ); ?>::<?php echo JText::_('Enable or disable the Images system'); ?>">
				<?php echo JText::_( 'Enable Images' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enableimages]' , null ,  $this->config->get('enableimages') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Images Path' ); ?>::<?php echo JText::_('Set the path for storing Images'); ?>">
				<?php echo JText::_( 'Path to uploaded Images' ); ?> </span></td>
			<td valign="top"><input type="text" size="40"
				name="config[imagespath]"
				value="<?php echo $this->config->get('imagespath');?>" /></td>
		</tr>
		<!--<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Images upload limit' ); ?>::<?php echo JText::_('Specify how many Images can a user upload. Set it to 0 if you would like to disable this feature'); ?>">
				<?php echo JText::_( 'Images creation limit' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[photouploadlimit]"
				value="<?php echo $this->config->get('photouploadlimit' );?>"
				size="10" /></td>
		</tr>
		--><tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Maximum photo upload size' ); ?>::<?php echo JText::_('Set the maximum file size for Images upload'); ?>">
				<?php echo JText::_( 'Maximum photo upload size' ); ?> </span></td>
			<td valign="top">
			<div><input type="text" size="3" name="config[maxuploadsize]"
				value="<?php echo $this->config->get('maxuploadsize');?>" /> (MB)</div>
			<div><?php echo JText::sprintf('upload_max_filesize defined in php.ini %1$s', $this->uploadLimit );?></div>
			</td>
		</tr>


		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Image file prefix' ); ?>::<?php echo JText::_('Image file prefix that will be used on files'); ?>">
				<?php echo JText::_( 'Image file prefix' ); ?> </span></td>
			<td valign="top"><input type="text" size="10" name="config[prefix]"
				value="<?php echo $this->config->get('prefix');?>" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Auto Publish Images' ); ?>::<?php echo JText::_('Auto Publish Images. Use this feature to moderate images'); ?>">
				<?php echo JText::_( 'Auto Publish Images' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[images_autopublish]' , null ,  $this->config->get('images_autopublish') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

	</tbody>
</table>
</fieldset>
