<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<fieldset class="adminform"><legend><?php echo JText::_( 'Tab Settings' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key" style="width:250px;"><span class="hasTip"
				title="<?php echo JText::_( 'Country Tab Text' ); ?>::<?php echo JText::_('Country Tab Text'); ?>">
				<?php echo JText::_( 'Country Tab Text' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[country_tab_text]"
				value="<?php echo $this->config->get('country_tab_text' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Region Tab Text' ); ?>::<?php echo JText::_('Region Tab Text'); ?>">
				<?php echo JText::_( 'Region Tab Text' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[region_tab_text]"
				value="<?php echo $this->config->get('region_tab_text' );?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Category Tab Text' ); ?>::<?php echo JText::_('Category Tab Text'); ?>">
				<?php echo JText::_( 'Category Tab Text' ); ?> </span></td>
			<td valign="top"><input type="text"
				name="config[category_tab_text]"
				value="<?php echo $this->config->get('category_tab_text' );?>"
				size="10" /></td>
		</tr>

	</tbody>
</table>
</fieldset>
