<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');



?>
<table cellspacing="0" cellpadding="0" border="0">
	<tr>
		<td width="50%">
		<fieldset class="adminform"><legend><?php echo JText::_( 'Simple Classified Ad Search Configuration' ); ?></legend>
		<table width="100%" cellpadding="0" border="0" class="admintable">



			<tbody>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search title' ); ?>::<?php echo JText::_('If Yes, title will be included in Search'); ?>">
						<?php echo JText::_( 'Search title' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_title]' , null ,  $this->config->get('search_title') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Ad Id' ); ?>::<?php echo JText::_('If Yes, Ad Id will be included in Search'); ?>">
						<?php echo JText::_( 'Search Ad Id' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_adid]' , null ,  $this->config->get('search_adid') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search state' ); ?>::<?php echo JText::_('If Yes, State/Region will be included in Search'); ?>">
						<?php echo JText::_( 'Search State' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_state]' , null ,  $this->config->get('search_state') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Zip/Postal Code' ); ?>::<?php echo JText::_('If Yes, Zip/Postal code will be included in Search'); ?>">
						<?php echo JText::_( 'Search Zip/Postal Code' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_zipcode]' , null ,  $this->config->get('search_zipcode') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search address' ); ?>::<?php echo JText::_('If Yes, Address will be included in Search'); ?>">
						<?php echo JText::_( 'Search Address' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_address]' , null ,  $this->config->get('search_address') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Description' ); ?>::<?php echo JText::_('If Yes, Ad Description will be included in Search'); ?>">
						<?php echo JText::_( 'Search Description' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_description]' , null ,  $this->config->get('search_description') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Category' ); ?>::<?php echo JText::_('If Yes, Ad Category will be included in Search'); ?>">
						<?php echo JText::_( 'Search Category' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_category]' , null ,  $this->config->get('search_category') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Price' ); ?>::<?php echo JText::_('If Yes, Ad Price will be included in Search'); ?>">
						<?php echo JText::_( 'Search Price' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_price]' , null ,  $this->config->get('search_price') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Tags' ); ?>::<?php echo JText::_('If Yes, Ad tags will be included in Search'); ?>">
						<?php echo JText::_( 'Search Tags' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_tags]' , null ,  $this->config->get('search_tags') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Meta Description' ); ?>::<?php echo JText::_('If Yes, Ad Meta Description will be included in Search'); ?>">
						<?php echo JText::_( 'Search Meta Description' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_meta]' , null ,  $this->config->get('search_meta') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>

				<!--<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Search Extrafields' ); ?>::<?php echo JText::_('If Yes, Extrafields will also be searched'); ?>">
						<?php echo JText::_( 'Search Extrafields' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[search_extrafields]' , null ,  $this->config->get('search_extrafields') , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				--><tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Default Search text' ); ?>::<?php echo JText::_('Default Search Text'); ?>">
						<?php echo JText::_( 'Default Search Text' ); ?> </span></td>
					<td valign="top"><input type="text"
						name="config[search_text_default]"
						value="<?php echo $this->config->get('search_text_default' );?>"
						size="10" /></td>
				</tr>

				<?php GApplication::triggerEvent('onSearchSettings',array(&$this->config)); ?>

			</tbody>
		</table>
		</fieldset>
		</td>
		<td>
		<table class="admintable" cellspacing="1">
		
		<tr>
		<td>
		<fieldset class="adminform"><legend><?php echo JText::_( 'Smart search configuration' ); ?></legend>
		<table class="admintable" cellspacing="1">
			<tbody>

				<tr>
					<td style="width: 250px;" class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Enable smart country search' ); ?>::<?php echo JText::_('Enable smart category search'); ?>">
						<?php echo JText::_( 'Enable smart country search' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_smart_country]' , null ,  $this->config->get('enable_smart_country',1) , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				
				
				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Enable smart region search' ); ?>::<?php echo JText::_('Enable smart category search'); ?>">
						<?php echo JText::_( 'Enable smart region search' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_smart_region]' , null ,  $this->config->get('enable_smart_region',1) , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				
				
				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'Enable smart category search' ); ?>::<?php echo JText::_('Enable smart category search'); ?>">
						<?php echo JText::_( 'Enable smart category search' ); ?> </span></td>
					<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_smart_category]' , null ,  $this->config->get('enable_smart_category',1) , JText::_('Yes') , JText::_('No') ); ?>
					</td>
				</tr>
				
			</tbody>
		</table>
		</fieldset>
		</td>
		</tr>
		
		
		
		<tr>
		<td>
		<fieldset class="adminform"><legend><?php echo JText::_( 'No Results Configuration' ); ?></legend>
		<table class="admintable" cellspacing="1">
			<tbody>

				<tr>
					<td class="key"><span class="hasTip"
						title="<?php echo JText::_( 'No Results Text' ); ?>::<?php echo JText::_('No Results text'); ?>">
						<?php echo JText::_( 'No Results Text' ); ?> </span></td>
					<td valign="top"><textarea name="config[search_no_results]"
						rows="5" cols="45"><?php echo $this->config->get('search_no_results' );?></textarea>
					</td>
				</tr>
			</tbody>
		</table>
		</fieldset>
		</td>
		</tr>
		
		
		</table>
		</td>
	</tr>
</table>
