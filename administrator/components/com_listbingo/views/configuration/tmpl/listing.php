<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<fieldset class="adminform">
	<legend><?php echo JText::_( 'Pay per post configuration' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Number of Free Post' ); ?>::<?php echo JText::_('Set number of free post for a user. A user will be able to post this number of listing for free'); ?>">
					<?php echo JText::_( 'Number of Free Post' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[freepost]" value="<?php echo $this->config->get('freepost');?>" size="10" />
				</td>
			</tr>
			
			
			<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Price for posting' ); ?>::<?php echo JText::_('Price for posting. The default currency will be used'); ?>">
					<?php echo JText::_( 'Price per post' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[price_per_post]" value="<?php echo $this->config->get('price_per_post');?>" size="10" />
				</td>
			</tr>
			
			<!--<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Price for Featured' ); ?>::<?php echo JText::_('Price for featured. The default currency will be used'); ?>">
					<?php echo JText::_( 'Price per featured' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[price_per_featured]" value="<?php echo $this->config->get('price_per_featured');?>" size="10" />
				</td>
			</tr>
						<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Featured is cumulative' ); ?>::<?php echo JText::_('If Yes, the price for featured is sum of pay per post and featured.'); ?>">
					<?php echo JText::_( 'Featured is cumulative' ); ?>
					</span>
				</td>
				<td valign="top">
					<?php echo JHTML::_('select.booleanlist' , 'config[cumulative_featured]' , null ,  $this->config->get('cumulative_featured') , JText::_('Yes') , JText::_('No') ); ?>
				</td>
			</tr>
			
			-->
		</tbody>
	</table>
</fieldset>