<?php
/**
 * @package Gobingoo
 * @subpackage captcha
 * @author bruce@gobingoo.com
 * @copyright www.gobingoo.com
 *
 *
 * Admin captcha settings form
 *
 */

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_ROOT.DS."administrator".DS."components".DS."com_content".DS."elements".DS."article.php");

$element=new JElementArticle(); 

?>

<div id="page-flag">
<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'FLAG_GENERAL_SETTINGS' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
	
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'ENABLE_MOODALBOX_FOR_FLAG' ); ?>::<?php echo JText::_('ENABLE_MOODALBOX_FOR_FLAG'); ?>">
				<?php echo JText::_( 'ENABLE_MOODALBOX_FOR_FLAG' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_flag_moodalbox]' , null ,  $this->config->get('enable_flag_moodalbox') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td width="300" class="key"><span class="hasTip"
				title="<?php echo JText::_( 'FLAG_ARTICLE_ID' ); ?>::<?php echo JText::_('FLAG_ARTICLE_ID'); ?>">
				<?php echo JText::_( 'FLAG_ARTICLE_ID' ); ?> </span></td>
			<td valign="top"><?php 
			echo $element->fetchElement("flag_id", $this->config->get('flag_id'), $param, "config");

			?></td>
		</tr>


		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'WIDTH_FOR_POP_BOX' ); ?>::<?php echo JText::_('WIDTH_FOR_POP_BOX'); ?>">
				<?php echo JText::_( 'WIDTH_FOR_POP_BOX' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[flag_popup_width]"
				value="<?php echo $this->config->get('flag_popup_width' );?>"
				size="45" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'HEIGHT_FOR_POP_BOX' ); ?>::<?php echo JText::_('HEIGHT_FOR_POP_BOX'); ?>">
				<?php echo JText::_( 'HEIGHT_FOR_POP_BOX' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[flag_popup_height]"
				value="<?php echo $this->config->get('flag_popup_height' );?>"
				size="45" /></td>
		</tr>
		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'ENABLE_SUSPENSION_AFTER_FLAG_LIMIT' ); ?>::<?php echo JText::_('ENABLE_SUSPENSION_AFTER_FLAG_LIMIT'); ?>">
				<?php echo JText::_( 'ENABLE_SUSPENSION_AFTER_FLAG_LIMIT' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_suspesion_after_flag_limit]' , null ,  $this->config->get('enable_suspesion_after_flag_limit') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td width="300" class="key"><span class="hasTip"
				title="<?php echo JText::_( 'FLAG_LIMIT' ); ?>::<?php echo JText::_('FLAG_LIMIT'); ?>">
				<?php echo JText::_( 'FLAG_LIMIT' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[flag_limit]"
				value="<?php echo $this->config->get('flag_limit' );?>"
				size="45" /></td>
		</tr>



	</tbody>
</table>
</fieldset>
</div>


<div class="clr"></div>
</div>
