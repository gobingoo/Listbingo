<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
<fieldset class="adminform"><legend><?php echo JText::_( 'Debug Configuration' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key" style="width:250px;"><span class="hasTip"
				title="<?php echo JText::_( 'Error Level' ); ?>::<?php echo JText::_('Error Level'); ?>">
				<?php echo JText::_( 'Error Level' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[error_level]' , null ,  $this->config->get('error_level') , JText::_('Live') , JText::_('Debug Mode') ); ?>
			</td>
		</tr>

	</tbody>
</table>
</fieldset>
