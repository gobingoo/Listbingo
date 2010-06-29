<?php
/**
 * @package Gobingoo
 * @subpackage captcha
 * @author bruce@gobingoo.com
 * @copyright www.gobingoo.com
 *
 *
 * Admin pms settings form
 *
 */

defined('_JEXEC') or die('Restricted access');

require_once(JPATH_ROOT.DS."administrator".DS."components".DS."com_content".DS."elements".DS."article.php");

$element=new JElementArticle(); 

?>

<div id="page-pms">
<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'PMS_GENERAL_SETTINGS' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'ENABLE_MOODALBOX_FOR_PMS' ); ?>::<?php echo JText::_('ENABLE_MOODALBOX_FOR_PMS'); ?>">
				<?php echo JText::_( 'ENABLE_MOODALBOX_FOR_PMS' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_pms_moodalbox]' , null ,  $this->config->get('enable_pms_moodalbox') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		
		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'WIDTH_FOR_POP_BOX' ); ?>::<?php echo JText::_('WIDTH_FOR_POP_BOX'); ?>">
				<?php echo JText::_( 'WIDTH_FOR_POP_BOX' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[pms_popup_width]"
				value="<?php echo $this->config->get('pms_popup_width' );?>"
				size="45" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'HEIGHT_FOR_POP_BOX' ); ?>::<?php echo JText::_('HEIGHT_FOR_POP_BOX'); ?>">
				<?php echo JText::_( 'HEIGHT_FOR_POP_BOX' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[pms_popup_height]"
				value="<?php echo $this->config->get('pms_popup_height' );?>"
				size="45" /></td>
		</tr>



	</tbody>
</table>
</fieldset>
</div>


<div class="clr"></div>
</div>
