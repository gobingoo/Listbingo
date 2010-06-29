<?php
// Disallow direct access to this file
defined ( '_JEXEC' ) or die ( 'Restricted access' );
$listthumbnail = array ();

$listthumbnail [] = JHTML::_ ( 'select.option', 'suffix_thumbnail_sml', JText::_ ( 'Small Thumbnail' ), 'id', 'title' );
$listthumbnail [] = JHTML::_ ( 'select.option', 'suffix_thumbnail_mid', JText::_ ( 'Mid size Thumbnail' ), 'id', 'title' );
$listthumbnail [] = JHTML::_ ( 'select.option', 'suffix_thumbnail_lrg', JText::_ ( 'Large Thumbnail' ), 'id', 'title' );
?>
<fieldset class="adminform"><legend><?php
echo JText::_ ( 'BASIC_CONFIGURATION' );
?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key" style="width: 250px;"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'DEFAULT_LISTING_LAYOUT' );
				?>::<?php
				echo JText::_ ( 'DEFAULT_LISTING_LAYOUT' );
				?>">
				<?php
				echo JText::_ ( 'DEFAULT_LISTING_LAYOUT' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[default_listing_layout]', null, $this->config->get ( 'default_listing_layout' ), JText::_ ( 'List View' ), JText::_ ( 'Simple View' ) );
			?>
			</td>
		</tr>


		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'ENABLE_ROOT_CAT_POST' );
				?>::<?php
				echo JText::_ ( 'ENABLE_ROOT_CAT_POST' );
				?>">
				<?php
				echo JText::_ ( 'ENABLE_ROOT_CAT_POST' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_root_cat_post]', null, $this->config->get ( 'enable_root_cat_post' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'ENABLE_CATEGORY_IN_FORM' );
				?>::<?php
				echo JText::_ ( 'ENABLE_CATEGORY_IN_FORM' );
				?>">
				<?php
				echo JText::_ ( 'ENABLE_CATEGORY_IN_FORM' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_cat_in_form]', null, $this->config->get ( 'enable_cat_in_form' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'New Post Assumption' );
				?>::<?php
				echo JText::_ ( 'This is number of days for tracking any post as new post' );
				?>">
				<?php
				echo JText::_ ( 'No. of days for new post assumption' );
				?> </span></td>
			<td valign="top"><input type="text"
				name="config[new_post_assumption]"
				value="<?php
				echo $this->config->get ( 'new_post_assumption' );
				?>"
				size="10" /> &nbsp;<?php
				echo JText::_ ( 'DAYS' );
				?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'SHOW_CATEGORY_DESCRIPTION' );
				?>::<?php
				echo JText::_ ( 'SHOW_CATEGORY_INFO' );
				?>">
				<?php
				echo JText::_ ( 'SHOW_CATEGORY_DESCRIPTION' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[show_category_alert]', null, $this->config->get ( 'show_category_alert' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Thumbnail for list layout' );
				?>::<?php
				echo JText::_ ( 'Thumbnail to use in list layout' );
				?>">
				<?php
				echo JText::_ ( 'Thumbnail for list layout' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.genericlist', $listthumbnail, 'config[listlayout_thumbnail]', 'class="inputbox"', 'id', 'title', $this->config->get ( 'listlayout_thumbnail' ) );
			;
			?></td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'List introtext length' );
				?>::<?php
				echo JText::_ ( 'Length of intro text in list layout' );
				?>">
				<?php
				echo JText::_ ( 'List introtext length' );
				?> </span></td>
			<td valign="top"><input type="text" name="config[intro_length]"
				value="<?php
				echo $this->config->get ( 'intro_length' );
				?>" size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Enable Ad Count in Parent Category' );
				?>::<?php
				echo JText::_ ( 'If Yes, total ad count will be in shown in the parent category' );
				?>">
				<?php
				echo JText::_ ( 'Enable Ad Count in Parent Category' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_adcount]', null, $this->config->get ( 'enable_adcount' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>




		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Auto submit Listing' );
				?>::<?php
				echo JText::_ ( 'If Yes, Ad listing will be auto submitted' );
				?>">
				<?php
				echo JText::_ ( 'Auto submit Listing' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[auto_submit_listing]', null, $this->config->get ( 'auto_submit_listing' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Moderate Post Edit' );
				?>::<?php
				echo JText::_ ( 'If Yes, Ad edit will be moderated' );
				?>">
				<?php
				echo JText::_ ( 'Moderate Post Edit' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[moderate_edit]', null, $this->config->get ( 'moderate_edit' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Auto expire Listings' );
				?>::<?php
				echo JText::_ ( 'If Yes, Property listing will auto expire in the days set below' );
				?>">
				<?php
				echo JText::_ ( 'Auto expire listings' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[auto_expire_listings]', null, $this->config->get ( 'auto_expire_listings' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Expiry days for listings' );
				?>::<?php
				echo JText::_ ( 'Number of days listing will expire automatically' );
				?>">
				<?php
				echo JText::_ ( 'Expiry days for listings' );
				?> </span></td>
			<td valign="top"><input type="text" name="config[expiry_days]"
				value="<?php
				echo $this->config->get ( 'expiry_days' );
				?>" size="10" />
			</td>
		</tr>
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Days before expiry alert' );
				?>::<?php
				echo JText::_ ( 'Number of days before alert mail will be sent out' );
				?>">
				<?php
				echo JText::_ ( 'Days before expiry alert' );
				?> </span></td>
			<td valign="top"><input type="text" name="config[days_before_expiry]"
				value="<?php
				echo $this->config->get ( 'days_before_expiry' );
				?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Ads per page' );
				?>::<?php
				echo JText::_ ( 'Ads per page to show' );
				?>">
				<?php
				echo JText::_ ( 'Ads per page' );
				?> </span></td>
			<td valign="top"><input type="text" name="config[ads_per_page]"
				value="<?php
				echo $this->config->get ( 'ads_per_page' );
				?>" size="10" />
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Enable intro text for listing' );
				?>::<?php
				echo JText::_ ( 'If Yes, intro description for listing will be shown' );
				?>">
				<?php
				echo JText::_ ( 'Enable intro text for listing' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_listing_introtext]', null, $this->config->get ( 'enable_listing_introtext' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Intro text length for listings' );
				?>::<?php
				echo JText::_ ( 'Intro text length for listings' );
				?>">
				<?php
				echo JText::_ ( 'Intro text length for listings' );
				?> </span>
			</td>
			<td valign="top"><input type="text"
				name="config[listing_introtext_length]"
				value="<?php
				echo $this->config->get ( 'listing_introtext_length' );
				?>"
				size="10" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Show expiry date in the form' );
				?>::<?php
				echo JText::_ ( 'Show expiry date in the form' );
				?>">
				<?php
				echo JText::_ ( 'Show expiry date in the form' );
				?> </span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[show_expiry_date]', null, $this->config->get ( 'show_expiry_date' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			</td>
		</tr>


	</tbody>
</table>
</fieldset>
