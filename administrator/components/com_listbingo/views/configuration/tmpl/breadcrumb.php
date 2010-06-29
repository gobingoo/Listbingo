<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Breadcrumb Configuration' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
		
			<tr>
				<td class="key" style="width:250px;">
					<span class="hasTip" title="<?php echo JText::_( 'Enable country for breadcrumb' ); ?>::<?php echo JText::_('If Yes, Country will be shown in Joomla breadcrumb'); ?>">
					<?php echo JText::_( 'Enable country for breadcrumb' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[enable_country_breadcrumb]' , null ,  $this->config->get('enable_country_breadcrumb') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable region for breadcrumb' ); ?>::<?php echo JText::_('If Yes, Region will be shown in Joomla breadcrumb'); ?>">
					<?php echo JText::_( 'Enable region for breadcrumb' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[enable_region_breadcrumb]' , null ,  $this->config->get('enable_region_breadcrumb') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Enable category for breadcrumb' ); ?>::<?php echo JText::_('If Yes, Category will be shown in Joomla breadcrumb'); ?>">
					<?php echo JText::_( 'Enable Category for breadcrumb' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[enable_category_breadcrumb]' , null ,  $this->config->get('enable_category_breadcrumb') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			
		</tbody>
	</table>
</fieldset>