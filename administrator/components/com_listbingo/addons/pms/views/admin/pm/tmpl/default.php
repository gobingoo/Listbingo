<?php
/**
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * @author bruce@gobingoo.com
 * @copyright www.gobingoo.com
 *
 * pms default listing view for admin
 *
 * code Bruce
 */

defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - PMS'), 'message.png');
GHelper::cpanel('default','home');
JToolBarHelper::divider();
JToolBarHelper::cancel("addons.pms.admin");
gbaddons("pms.css.icons");

?>
<form name="adminForm" id="adminForm" action="index.php" method="post"
	enctype="multipart/form-data"><input type="hidden" name="id" id="id"
	value="<?php echo $this->row->id?>" />
<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_('SENDER_RECEIVER_DETAILS');?></legend>
<table width="100%" cellpadding="5" class="admintable">
	<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('TITLE');?></td>
		<td width="40%"><?php echo $this->row->ad;?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('SENDER');?></td>
		<td width="40%"><?php echo $this->row->message_from?$this->row->susername:JText::_('GUEST');?></td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('RECEIVER');?></td>
		<td width="40%"><?php echo $this->row->rusername;?></td>
		<td>&nbsp;</td>
	</tr>

	<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('DATE');?></td>
		<td width="40%"><?php echo date("d M, Y", strtotime($this->row->message_date));?></td>
		<td>&nbsp;</td>
	</tr>

</table>
</fieldset>
</div>

<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_('MESSAGE_DETAILS');?></legend>
<table width="100%" cellpadding="5" class="admintable">
	<!--<tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('SUBJECT');?></td>
		<td width="40%"><?php echo $this->row->subject;?></td>
		<td>&nbsp;</td>
	</tr>
	--><tr>
		<td width="10%" valign="top" class="key"><?php echo JText::_('MESSAGE');?></td>
		<td width="40%"><?php echo $this->row->message;?></td>
		<td>&nbsp;</td>
	</tr>
</table>
</fieldset>
</div>
<input type="hidden" name="option" value="<?php echo $option?>" /> <input
	type="hidden" name="task" value="" /></form>