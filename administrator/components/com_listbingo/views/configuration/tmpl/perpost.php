<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
$posting_scheme=array();

$posting_scheme[]=JHTML::_('select.option', '0', JText::_('Free to Post'), 'id', 'title');
$posting_scheme[]=JHTML::_('select.option', '1', JText::_('Pay Per Post'), 'id', 'title');
$posting_scheme[]=JHTML::_('select.option', '2', JText::_('Package Based'), 'id', 'title');


if(isset($this->validcurrencylist) && ($this->validcurrencylist))
{
	$currencies1=array();
	$currencies1[] = JHTML::_('select.option', '', JText::_('Select Currency'), 'value', 'text');
	$currencies=array_merge($currencies1,$this->lists['currencies']);
	$defaultcurrency = JHTML::_('select.genericlist',  $currencies, 'config[default_currency]', 'class="inputbox"', 'value', 'text',  $this->config->get('default_currency') );
}
else
{
	$curr = $this->config->get('default_currency','$:AUD');
	$defaultcurrency = "<input type=\"text\" name=\"config[default_currency]\"	value=\"$curr\" size=\"10\" />&nbsp;".JText::_('Proper format is <strong>currency symbol</strong>:<strong>currency</strong> (Example: $:USD)');
}
?>


<fieldset class="adminform"><legend><?php echo JText::_( 'Payment/Post Configuration' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Posting Scheme' ); ?>::<?php echo JText::_('Posting Scheme. Admin will be able to set 3 posting secheme. <br/>1. Free Posting <br/>2. Pay per post<br/>3.Packages'); ?>">
				<?php echo JText::_( 'Select Posting Scheme' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.radiolist',  $posting_scheme, 'config[posting_scheme]', 'class="inputbox"', 'id', 'title',  $this->config->get('posting_scheme') );;?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Select Currency' ); ?>::<?php echo JText::_('Select Default Currency. The setting will work only if posting scheme is not set Free'); ?>">
				<?php echo JText::_( 'Select Default Currency' ); ?> </span></td>
			<td valign="top"><?php echo $defaultcurrency;?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Selectable Currency' ); ?>::<?php echo JText::_('If Yes, Currency Selection will be available otherwise default currency will be used'); ?>">
				<?php echo JText::_( 'Selectable Currency' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[currency_selectable]' , null ,  $this->config->get('currency_selectable') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable Cartbingo' ); ?>::<?php echo JText::_('If Yes, Cartbingo will be used to handle payments'); ?>">
				<?php echo JText::_( 'Enable Cartbingo' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_cartbingo]' , null ,  $this->config->get('enable_cartbingo') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Number of Images per Post' ); ?>::<?php echo JText::_('Set number of Images per post.'); ?>">
				<?php echo JText::_( 'Number of Images' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[images_number]"
				value="<?php echo $this->config->get('images_number');?>" size="10" />
			</td>
		</tr>

	</tbody>
</table>
</fieldset>
