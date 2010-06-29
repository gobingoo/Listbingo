<?php
defined('JPATH_BASE') or die();
gbaddons("pms.css.layout");
global $option;
$inboxlink=JRoute::_("index.php?option=$option&task=addons.pms.my");
?>
<div class="msgbuttons">
<a class="btnInbox" href="<?php echo $inboxlink;?>"><span><?php echo JText::_("BACK_TO_INBOX");?></span></a>
</div>
<div class="clear"></div>
<div id="roundme" class="gb_pms_round_corner">
<?php 
if(is_null($this->row))
{
	?>
	
	<div class="gb_pms_detail_wrapper">

<h2><?php echo JText::_("MESSAGE_NO_LOAD"); ?></h2>

</div>
<p>
		<?php 
		echo JText::_("MESSAGE_NO_LOAD_REASON");
		?>
		</p>

	<?php 
}
else
{
?>



<div class="gb_pms_detail_wrapper">
<span><strong><?php  echo ListbingoHelper::getDate($this->row->message_date,$this->params); ?></strong></span>
<h2><?php echo JText::_('INQUIRY_FOR')." ".$this->row->ad; ?></h2>

</div>


<div class="gb_pms_details">
<label><?php echo JText::_('FROM'); ?>:</label> <strong><?php echo $this->row->contact_name; ?> 
&lt;<a href="mailto:<?php echo $this->row->contact_email; ?>"><?php echo $this->row->contact_email; ?></a>&gt;</strong>


</div>

<div class="gm_message">
 <?php echo $this->row->message; ?>
</div>


<?php 
}
?></div>