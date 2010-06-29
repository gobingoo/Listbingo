<?php 
JHTML::_('behavior.formvalidation');
$baseurl=JUri::root()."administrator/components/$option/";
?>
<script type="text/javascript">
//<!--

document.formvalidator = null;
Window.onDomReady(function(){
	document.formvalidator = new JFormValidator();
});
//-->

</script>

<link href="<?php echo $baseurl."css/moodalbox.css"?>" type="text/css" rel="stylesheet"/>
<div class="highslide-maincontent" id="replyForm">
<div class="replyFrm">

<form name="josForm" action="<?php echo JRoute::_("index.php?option=$option");?>" method="post" id="josForm" name="josForm" class="form-validate" enctype="multipart/form-data">
<label id="contact_namemsg" for="contact_name"><?php echo JText::_('YOUR_NAME');?></label>
<input name="contact_name" type="text" id="contact_name" class="reply_inputtext required" size="47"/><br />

<label id="contact_emailmsg" for="contact_email"><?php echo JText::_('YOUR_EMAIL');?></label>
<input name="contact_email" type="text" id="contact_email" class="reply_inputtext required"  size="47"/><br />

<label id="messagemsg" for="message"><?php echo JText::_('MESSAGE');?></label>
<textarea name="message" id="message" cols="45" rows="10" class="reply_inputtextarea required"></textarea><br />

<button class="gb_flagbtn validate" type="submit"><?php echo JText::_('SEND'); ?></button>
<input type="hidden" name="option" value="<?php echo $option;?>" /> 
<input type="hidden" name="message_to" value="<?php echo $this->ad->user_id;?>" />
<input type="hidden" name="ad_id" value="<?php echo $this->ad->id;?>" /> 
<input type="hidden" name="task" value="addons.pms.front.send" />
</form>

<div class="clear"></div>

</div>
</div>