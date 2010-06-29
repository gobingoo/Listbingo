<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
$resize=array();

$resize[]=JHTML::_('select.option', '1', JText::_('Resize'), 'id', 'title');
$resize[]=JHTML::_('select.option', '0', JText::_('Crop'), 'id', 'title');

$convertto=array();

$convertto[]=JHTML::_('select.option', 'png', JText::_('PNG'), 'id', 'title');
$convertto[]=JHTML::_('select.option', 'jpg', JText::_('JPG'), 'id', 'title');
$convertto[]=JHTML::_('select.option', 'gif', JText::_('GIF'), 'id', 'title');

?>

<fieldset class="adminform"><legend><?php echo JText::_( 'Logo Settings' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
	
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Show Related Categories' ); ?>::<?php echo JText::_('If Yes, Related Category will be displayed'); ?>">
				<?php echo JText::_( 'Show Related Categories' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_related_categories]' , null ,  $this->config->get('enable_related_categories') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Logo' ); ?>::<?php echo JText::_('If Yes, Category logo will be displayed'); ?>">
				<?php echo JText::_( 'Enable Logo' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[category_enable_logo]' , null ,  $this->config->get('category_enable_logo') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Convert To' ); ?>::<?php echo JText::_('Convert Images to'); ?>">
				<?php echo JText::_( 'Convert Thumbnails to' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.genericlist',  $convertto, 'config[category_convertto]', 'class="inputbox"', 'id', 'title',  $this->config->get('category_convertto') );;?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Width' ); ?>::<?php echo JText::_('Width of Small thumbnail'); ?>">
				<?php echo JText::_( 'Width' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[width_category_logo]"
				value="<?php echo $this->config->get('width_category_logo' );?>"
				size="10" /></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Height' ); ?>::<?php echo JText::_('Height of Small thumbnail'); ?>">
				<?php echo JText::_( 'Height' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[height_category_logo]"
				value="<?php echo $this->config->get('height_category_logo' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize' ); ?>::<?php echo JText::_('Resize Image for thumbnail'); ?>">
				<?php echo JText::_( 'Resize' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[resize_category_logo]' , 1 ,  $this->config->get('resize_category_logo') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Crop' ); ?>::<?php echo JText::_('Crop Image for thumbnail'); ?>">
				<?php echo JText::_( 'Crop' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[crop_category_logo]' , 1 ,  $this->config->get('crop_category_logo') , JText::_('Yes') , JText::_('No') ); ?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to width'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to width' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[x_category_logo]' , 1 ,  $this->config->get('x_category_logo') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Resize/Crop in proportion to Height' ); ?>::<?php echo JText::_('Resize/Crop in proportoin to Height'); ?>">
				<?php echo JText::_( 'Resize/Crop in proportion to height' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[y_category_logo]' , 1 ,  $this->config->get('y_category_logo') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Suffix' ); ?>::<?php echo JText::_('Suffix of Small thumbnail'); ?>">
				<?php echo JText::_( 'Suffix' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[suffix_category_logo]"
				value="<?php echo $this->config->get('suffix_category_logo' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Logo Path' ); ?>::<?php echo JText::_('Save Logo to this path'); ?>">
				<?php echo JText::_( 'Logo Path' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[path_category_logo]"
				value="<?php echo $this->config->get('path_category_logo' );?>"
				size="45" /></td>
		</tr>

	</tbody>
</table>
</fieldset>
