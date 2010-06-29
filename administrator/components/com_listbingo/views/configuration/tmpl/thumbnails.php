<?php
defined('_JEXEC') or die('Restricted access');

$resize=array();

$resize[]=JHTML::_('select.option', '1', JText::_('Resize'), 'id', 'title');
$resize[]=JHTML::_('select.option', '0', JText::_('Crop'), 'id', 'title');

$convertto=array();

$convertto[]=JHTML::_('select.option', 'png', JText::_('PNG'), 'id', 'title');
$convertto[]=JHTML::_('select.option', 'jpg', JText::_('JPG'), 'id', 'title');
$convertto[]=JHTML::_('select.option', 'gif', JText::_('GIF'), 'id', 'title');


?>

<fieldset class="adminform"><legend><?php echo JText::_( 'Thumbnails' ); ?></legend>
<table class="admintable" cellspacing="1" width="100%">
	<tbody>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Save Original Images' ); ?>::<?php echo JText::_('Save Original Images along with thumbnails'); ?>">
				<?php echo JText::_( 'Save Original Images' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[saveoriginal]' , null ,  $this->config->get('saveoriginal') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Save Proportions' ); ?>::<?php echo JText::_('Save Width and Height proportions'); ?>">
				<?php echo JText::_( 'Save Proportions' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[saveproportion]' , null ,  $this->config->get('saveproportion') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
	
		
		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Convert To' ); ?>::<?php echo JText::_('Convert Images to'); ?>">
				<?php echo JText::_( 'Convert Thumbnails to' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.genericlist',  $convertto, 'config[convertto]', 'class="inputbox"', 'id', 'title',  $this->config->get('convertto') );;?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="key" style="text-align: left"><?php echo JText::_("Small Thumbnail")?>

			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Small Thumbnail' ); ?>::<?php echo JText::_('Save Original Images along with thumbnails'); ?>">
				<?php echo JText::_( 'Enable Small Thumbnail' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_thumbnail_sml]' , 1 ,  $this->config->get('enable_thumbnail_sml') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Width' ); ?>::<?php echo JText::_('Width of Small thumbnail'); ?>">
				<?php echo JText::_( 'Width' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[width_thumbnail_sml]"
				value="<?php echo $this->config->get('width_thumbnail_sml' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Height' ); ?>::<?php echo JText::_('Height of Small thumbnail'); ?>">
				<?php echo JText::_( 'Height' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[height_thumbnail_sml]"
				value="<?php echo $this->config->get('height_thumbnail_sml' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize' ); ?>::<?php echo JText::_('Resize Image for thumbnail'); ?>">
				<?php echo JText::_( 'Resize' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[resize_thumbnail_sml]' , 1 ,  $this->config->get('resize_thumbnail_sml') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Crop' ); ?>::<?php echo JText::_('Crop Image for thumbnail'); ?>">
				<?php echo JText::_( 'Crop' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[crop_thumbnail_sml]' , 1 ,  $this->config->get('crop_thumbnail_sml') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to width'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[x_thumbnail_sml]' , 1 ,  $this->config->get('x_thumbnail_sml') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to Height' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to Height'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to height' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[y_thumbnail_sml]' , 1 ,  $this->config->get('y_thumbnail_sml') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Suffix' ); ?>::<?php echo JText::_('Suffix of Small thumbnail'); ?>">
				<?php echo JText::_( 'Suffix' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[suffix_thumbnail_sml]"
				value="<?php echo $this->config->get('suffix_thumbnail_sml' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td colspan="2" class="key" style="text-align: left"><?php echo JText::_("Midsize Thumbnail")?>

			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Midsize Thumbnail' ); ?>::<?php echo JText::_('Enable Mid sized thumbnails'); ?>">
				<?php echo JText::_( 'Enable Midsize Thumbnail' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_thumbnail_mid]' , 1 ,  $this->config->get('enable_thumbnail_mid') , JText::_('Yes') , JText::_('No') ); ?>

			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Width' ); ?>::<?php echo JText::_('Width of Midsize  thumbnail'); ?>">
				<?php echo JText::_( 'Width' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[width_thumbnail_mid]"
				value="<?php echo $this->config->get('width_thumbnail_mid' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Height' ); ?>::<?php echo JText::_('Height of Midsize thumbnail'); ?>">
				<?php echo JText::_( 'Height' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[height_thumbnail_mid]"
				value="<?php echo $this->config->get('height_thumbnail_mid' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize' ); ?>::<?php echo JText::_('Resize Image for thumbnail'); ?>">
				<?php echo JText::_( 'Resize' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[resize_thumbnail_mid]' , 1 ,  $this->config->get('resize_thumbnail_mid') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Crop' ); ?>::<?php echo JText::_('Crop Image for thumbnail'); ?>">
				<?php echo JText::_( 'Crop' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[crop_thumbnail_mid]' , 1 ,  $this->config->get('crop_thumbnail_mid') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to width'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[x_thumbnail_mid]' , 1 ,  $this->config->get('x_thumbnail_mid') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to Height' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to Height'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to height' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[y_thumbnail_mid]' , 1 ,  $this->config->get('y_thumbnail_mid') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Suffix' ); ?>::<?php echo JText::_('Suffix of Midsize thumbnail'); ?>">
				<?php echo JText::_( 'Suffix' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[suffix_thumbnail_mid]"
				value="<?php echo $this->config->get('suffix_thumbnail_mid' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td colspan="2" class="key" style="text-align: left"><?php echo JText::_("Large Thumbnail")?>

			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Large Thumbnail' ); ?>::<?php echo JText::_('Enable Large sized thumbnails'); ?>">
				<?php echo JText::_( 'Enable Large Thumbnail' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_thumbnail_lrg]' , 1 ,  $this->config->get('enable_thumbnail_lrg') , JText::_('Yes') , JText::_('No') ); ?>

			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Width' ); ?>::<?php echo JText::_('Width of Large  thumbnail'); ?>">
				<?php echo JText::_( 'Width' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[width_thumbnail_lrg]"
				value="<?php echo $this->config->get('width_thumbnail_lrg' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Height' ); ?>::<?php echo JText::_('Height of Large thumbnail'); ?>">
				<?php echo JText::_( 'Height' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[height_thumbnail_lrg]"
				value="<?php echo $this->config->get('height_thumbnail_lrg' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize' ); ?>::<?php echo JText::_('Resize Image for thumbnail'); ?>">
				<?php echo JText::_( 'Resize' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[resize_thumbnail_lrg]' , 1 ,  $this->config->get('resize_thumbnail_lrg') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Crop' ); ?>::<?php echo JText::_('Crop Image for thumbnail'); ?>">
				<?php echo JText::_( 'Crop' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[crop_thumbnail_lrg]' , 1 ,  $this->config->get('crop_thumbnail_lrg') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to width'); ?>">
			<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?> </span></td>
		<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[x_thumbnail_lrg]' , 1 ,  $this->config->get('x_thumbnail_lrg') , JText::_('Yes') , JText::_('No') ); ?>
		</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to Height' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to Height'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to height' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[y_thumbnail_lrg]' , 1 ,  $this->config->get('y_thumbnail_lrg') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Suffix' ); ?>::<?php echo JText::_('Suffix of Large thumbnail'); ?>">
				<?php echo JText::_( 'Suffix' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[suffix_thumbnail_lrg]"
				value="<?php echo $this->config->get('suffix_thumbnail_lrg' );?>"
				size="10" /></td>
		</tr>
	</tbody>
</table>
</fieldset>
