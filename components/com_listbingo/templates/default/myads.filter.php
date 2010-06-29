<?php 
global $option, $listitemid;
?>
<div id="roundme_filter" class="gb_filter_round_corner">

<div class="gb_result_status">
<div class="gb_results">

<?php echo $this->pagination->getResultsCounter();?>

<?php 
$this->render('ads.pagination');
?>
<div class="gb_myads_filter">
<form onSubmit="checkForm()" name="frmGBSearch" id="frmGBSearch" method="get" action="<?php JRoute::_("index.php?Itemid=$listitemid");?>">
<input type="hidden" name="option" value="com_listbingo"> 
<input type="hidden" name="task" value="myads" />
<input type="hidden" name="Itemid" value="<?php echo $listitemid; ?>" />

<input type="text" name="q" id="q" value="<?php echo $this->filter->searchtxt;?>" size="10" class="inputbox" />
<?php echo $this->lists['categories'];?>
<?php echo $this->lists['status'];?>
<input type="submit" name="myadsearchbtn" id="myadsearchbtn" value="<?php echo JText::_('GO');?>" />                     
</form>
</div>

</div>

</div>
</div>
<br class="clear" />

