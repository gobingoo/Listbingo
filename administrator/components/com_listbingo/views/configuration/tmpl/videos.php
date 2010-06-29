<fieldset class="adminform">
	<legend><?php echo JText::_( 'Videos' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable videos' ); ?>::<?php echo JText::_('Enable or disable the videos system'); ?>">
						<?php echo JText::_( 'Enable videos' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[enablevideos]' , null ,  $this->config->get('enablevideos', true) , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable videos upload' ); ?>::<?php echo JText::_('Enable or disable the videos upload'); ?>">
						<?php echo JText::_( 'Enable videos upload' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[enablevideosupload]' , null ,  $this->config->get('enablevideosupload', true) , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Video creation limit' ); ?>::<?php echo JText::_('Specify how many videos can a user upload / link. Set it to 0 if you would like to disable this feature'); ?>">
						<?php echo JText::_( 'Video creation limit' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[videouploadlimit]" value="<?php echo $this->config->get('videouploadlimit' );?>" size="10" />
				</td>
			</tr>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Delete original videos' ); ?>::<?php echo JText::_('Delete the original videos after it gets converted. Enable to save memory space.'); ?>">
						<?php echo JText::_( 'Delete original videos' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[deleteoriginalvideos]' , null ,  $this->config->get('deleteoriginalvideos', false) , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Videos Root Folder Name' ); ?>::<?php echo JText::_('Videos folder name relative to Joomla root directory. i.e. images. Please do not insert a full path'); ?>">
						<?php echo JText::_( 'Videos Root Folder' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" size="40" name="config[videofolder]" value="<?php echo $this->config->get('videofolder');?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Maximum video upload size' ); ?>::<?php echo JText::_('Set the maximum file size for videos upload'); ?>">
						<?php echo JText::_( 'Maximum video upload size' ); ?>
					</span>
				</td>
				<td valign="top">
					<div><input type="text" size="3" name="config[maxvideouploadsize]" value="<?php echo $this->config->get('maxvideouploadsize', 8);?>" /> (MB)</div>
					<div><?php echo JText::sprintf('upload_max_filesize defined in php.ini %1$s', $this->uploadLimit );?></div>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'FFMPEG Path' ); ?>::<?php echo JText::_('Enter the absolute path to FFMPEG. If FFMPEG is not found, JomSocial will not able to convert videos into .flv format for storage.'); ?>">
						<?php echo JText::_( 'FFMPEG Path' ); ?>
					</span>
				</td>
				<td valign="top">
					<input name="config[ffmpegPath]" type="text" size="60" value="<?php echo $this->config->get('ffmpegPath');?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'FLVTool2 Path' ); ?>::<?php echo JText::_('Enter the absolute path to FLVTool2 for Flash Video Metadata Injection.'); ?>">
						<?php echo JText::_( 'FLVTool2 Path' ); ?>
					</span>
				</td>
				<td valign="top">
					<input name="config[flvtool2]" type="text" size="60" value="<?php echo $this->config->get('flvtool2');?>" />
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Video Quantizer Scale' ); ?>::<?php echo JText::_('Select video quality between 1 (excellent quality) and 31 (worst quality). 5, 9, 11 are recommended.'); ?>">
						<?php echo JText::_( 'Video Quantizer Scale' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->lists['qscale']; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Videos Size' ); ?>::<?php echo JText::_('Enter the videos frame size in widthxheight format'); ?>">
						<?php echo JText::_( 'Videos Size' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo $this->lists['videosSize']; ?>
				</td>
			</tr>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Custom Command' ); ?>::<?php echo JText::_('Additional command to run FFmpeg. ADVANCE USER ONLY'); ?>">
						<?php echo JText::_( 'Custom Command' ); ?>
					</span>
				</td>
				<td valign="top">
					<input name="config[customCommandForVideo]" type="text" size="60" value="<?php echo $this->config->get('customCommandForVideo');?>" />
				</td>
			</tr>
		
			
		</tbody>
	</table>
</fieldset>