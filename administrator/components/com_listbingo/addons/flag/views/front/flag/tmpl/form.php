<?php 
JHTML::_('behavior.formvalidation');
$baseurl=JUri::root()."administrator/components/$option/";
?>
<link href="<?php echo $baseurl."css/moodalbox.css"?>" type="text/css" rel="stylesheet"/>
<script>
//<!--

document.formvalidator = null;
Window.onDomReady(function(){
	document.formvalidator = new JFormValidator();
});
//-->

</script>

<div class="flagFrm">


<?php echo $this->article->text;?>

<form name="josForm" action="<?php echo JRoute::_("index.php?option=$option");?>" method="post" id="josForm" name="josForm" class="form-validate" enctype="multipart/form-data">



<label id="flag_idmsg" for="flag_id"><?php echo JText::_('REPORT_AS');?></label>
<?php echo $this->report; ?>

<label id="commentsmsg" for="comment"><?php echo JText::_('COMMENTS');?></label>
<textarea name="comment" id="comment" cols="43" rows="4" class="flag_inputtextarea required"></textarea><br />

<label id="emailmsg" for="email"><?php echo JText::_('EMAIL');?></label>
<input name="email" type="text" id="email" class="flag_inputtext required" size="46" /><br />

<button class="gb_flagbtn validate" type="submit"><?php echo JText::_('REPORT'); ?></button>
<input type="hidden" name="option" value="<?php echo $option;?>" /> 
<input type="hidden" name="item_id" value="<?php echo $this->adid;?>" />
<input type="hidden" name="task" value="addons.flag.front.report" />
</form>

<div class="clear"></div>

</div>