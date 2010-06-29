<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');

?>
<fieldset class="adminform"><legend><?php echo JText::_( 'Security Configuration' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		
		


		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Filter email address on ad post' ); ?>::<?php echo JText::_('If Yes, email address will be replace by defined text while posting ad.'); ?>">
				<?php echo JText::_( 'Filter email address on ad post' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_email_replacement]' , null ,  $this->config->get('enable_email_replacement') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Filter bad words' ); ?>::<?php echo JText::_('If Yes, bad words will be filter from the text.'); ?>">
				<?php echo JText::_( 'Filter bad words' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_badword_filter]' , null ,  $this->config->get('enable_badword_filter') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Enable filter inside word' ); ?>::<?php echo JText::_('If Yes, bad word will be filter from the inside word as well.'); ?>">
				<?php echo JText::_( 'Enable filter inside word' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_inside_filter]' , null ,  $this->config->get('enable_inside_filter') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Replacing Text' ); ?>::<?php echo JText::_('Replacing Text'); ?>">
				<?php echo JText::_( 'Replacing Text' ); ?> </span>
			</td>
			<td valign="top"><input type="text" name="config[email_replace_text]"
				value="<?php echo $this->config->get('email_replace_text');?>"
				size="10" /></td>
		</tr>
		

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Keywords' ); ?>::<?php echo JText::_('Keywords'); ?>">
				<?php echo JText::_( 'Keywords' ); ?> </span></td>
			<td valign="top"><textarea name="config[bad_keywords]" cols="30"
				rows="10"><?php echo $this->config->get('bad_keywords');?></textarea>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Show Contact Information' ); ?>::<?php echo JText::_('If Yes, contact information is visible to user'); ?>">
				<?php echo JText::_( 'Show Contact Information' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[show_contact_information]' , null ,  $this->config->get('show_contact_information') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

	</tbody>
</table>
</fieldset>
