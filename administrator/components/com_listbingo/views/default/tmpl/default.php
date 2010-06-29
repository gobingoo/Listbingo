<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Control Panel'), 'home.png');

jimport('joomla.html.pane');
gbimport("css.icons");

?>
<style>
.auth {
	border: 1px solid #CCCCCC;
	background-color: #f5f5f5;
	color: #0000CC;
	padding: 5px;
}

.auth2 {
	border: 1px solid #CCCCCC;
	background-color: #f5f5f5;
	color: #00cc22;
	padding: 5px;
}
</style>
<table width="100%" cellpadding="5" cellspacing="5" border="0">
	<tr>
		<td valign="top" width="20%">
		<div><img
			src="<?php echo JUri::root()?>administrator/components/<?php echo $option;?>/images/feedbingo-logo.png" /></div>
		<div><?php echo JText::_('SLOGAN');?> <a
			href="http://www.gobingoo.com" target="_blank"><strong>www.gobingoo.com</strong></a><br />

		</div>
		</td>
		<td width="50%" valign="top">


		<div id="cpanel"><?php
		$link = "index.php?option=$option&task=settings";
		ListbingoHelper::quickiconButton( $link, 'setting.png', JText::_( 'Settings' ) );

		$link = "index.php?option=$option&task=categories";
		ListbingoHelper::quickiconButton( $link, 'category.png', JText::_( 'Categories' ) );

		$link = "index.php?option=$option&task=fields";
		ListbingoHelper::quickiconButton( $link, 'fields.png', JText::_( 'Extrafields' ) );

		$link = "index.php?option=$option&task=options";
		ListbingoHelper::quickiconButton( $link, 'options.png', JText::_( 'Field Options' ) );

		$link = "index.php?option=$option&task=countries";
		ListbingoHelper::quickiconButton( $link, 'country.png', JText::_( 'Countries' ) );

		$link = "index.php?option=$option&task=regions";
		ListbingoHelper::quickiconButton( $link, 'regions.png', JText::_( 'Regions' ) );

		$link = "index.php?option=$option&task=ads";
		ListbingoHelper::quickiconButton( $link, 'ad.png', JText::_( 'Ads' ) );

		$link = "index.php?option=$option&task=templates";
		ListbingoHelper::quickiconButton( $link, 'template.png', JText::_( 'Templates' ) );

		$link = "index.php?option=$option&task=plugins";
		ListbingoHelper::quickiconButton( $link, 'plugins.png', JText::_( 'Addons' ) );

		$link = "index.php?option=$option&task=emails";
		ListbingoHelper::quickiconButton( $link, 'email.png', JText::_( 'Email Format' ) );

		GApplication::triggerEvent('onAdminCpanelDisplay');

		?></div>
		<br style="clear: both;" />
		<br />

		</td>
		<td valign="top"><?php 
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane("adstats-pane");
		echo $pane->startPanel( "Ads Statistics", 'ads-stats' );		?>
		<table width="100%" class="adminlist ">

			<tr>
				<td><a
					href="<?php echo JRoute::_('index.php?option='.$option.'&task=ads',false);?>"><?php echo JText::_('TOTAL_ADS');?></a></td>
				<td><?php echo (int)$this->adstats->totalcount; ?></td>
			</tr>


			<tr>
				<td><a
					href="<?php echo JRoute::_('index.php?option='.$option.'&task=ads&new=1',false);?>"><?php echo JText::_('TOTAL_NEW_POSTS');?></a></td>
				<td><?php echo (int)$this->adstats->newpostcount; ?></td>
			</tr><!--

			<tr>
				<td><a
					href="<?php echo JRoute::_('index.php?option='.$option.'&task=ads&featured=1',false);?>"><?php echo JText::_('TOTAL_FEATURED_ADS');?></a></td>
				<td><?php echo (int)$this->adstats->featuredcount; ?></td>
			</tr>

			--><tr>
				<td><a
					href="<?php echo JRoute::_('index.php?option='.$option.'&task=ads&status=1',false);?>"><?php echo JText::_('TOTAL_PUBLISHED_ADS');?></a></td>
				<td><?php echo (int)$this->adstats->publishedcount; ?></td>
			</tr>

			<tr>
				<td><a
					href="<?php echo JRoute::_('index.php?option='.$option.'&task=ads&status=0',false);?>"><?php echo JText::_('TOTAL_UNPUBLISHED_ADS');?></a></td>
				<td><?php echo (int)$this->adstats->unpublishedcount; ?></td>
			</tr>

			<?php GApplication::triggerEvent('onAdminCpanelStatDisplay',array(&$this->adstats,& $this->params)); ?>
		</table>
		<?php

		echo $pane->endPanel();
		echo $pane->endPane();
		?></td>
	</tr>
	<tr>
		<td colspan="2"><?php echo JText::_('LEARN_MORE_ABOUT');?> <strong><?php echo JText::_('LISTBINGO');?></strong>
		<?php echo JText::_('AT');?> <a href="http://www.gobingoo.com"
			target="_blank"><strong>www.gobingoo.com</strong></a> <br />
		</td>
		<td align="right">

		<div class="copyright"><img
			src="<?php echo JUri::root()?>administrator/components/<?php echo $option;?>/images/product-of-gobingoo.png" />
		</div>
		</td>
	</tr>
</table>
