<?php
global $option;
$returnurl=base64_encode(JRoute::_(JRequest::getURI()));
$changelink=JRoute::_("index.php?option=$option&task=regions.select&type=country");

$featuredlink=JRoute::_("index.php?".ListbingoHelper::getSearchUrl("featured"));
$latestlink=JRoute::_("index.php?".ListbingoHelper::getSearchUrl("latest"));
$pricelink=JRoute::_("index.php?".ListbingoHelper::getSearchUrl("price"));
$statelink=JRoute::_("index.php?".ListbingoHelper::getSearchUrl("state"));
$listlink=JRoute::_("index.php?".ListbingoHelper::getTaskSearchUrl("ads.search"));

$task=JRequest::getCMD('task');
?>
<div id="roundme_filter" class="gb_filter_round_corner">
<div class="gb_result_status">
<div class="gb_results"><?php echo $this->pagination->getResultsCounter();?>
<?php
$cat="";
if(isset($this->filter->searchtxt))
{

	if(JRequest::getInt('catid',0))
	{
		if(is_array($this->categories) && !empty($this->categories))
		{
			$cat = " ".$this->categories[0]->title;

		}
	}

	echo JText::sprintf("RESULTS_FOR",$this->filter->searchtxt.$cat,$this->filter->regiontitle);
}
else
{
	echo JText::sprintf("RESULTS",$this->filter->regiontitle);
}
?></div>

<div class="gb_views"><?php 
ob_start();
$views= GApplication::triggerEvent('onViewsLoad',array(& $this->params));
$viewcontent=ob_get_contents();
ob_end_clean();
?> <?php 
if(count($views)>0)
{
?> <a href="<?php echo $listlink;?>"
<?php echo strpos($task,"ads")===0?"class='gb_active gbdifferentviews'":"class='gbdifferentviews'";?>>
<span><?php echo JText::_("LIST_VIEW");?></span></a> 
<?php echo $viewcontent; ?>
<?php 
}
?>
<div class="clear"></div>
</div>

</div>

</div>

<div class="gb_sortby"><strong><?php echo JText::_('SORT_BY');?> :</strong>
&nbsp; <a href="<?php echo $latestlink;?>"><?php echo JText::_("LATEST_ADS");?></a>
| <a href="<?php echo $pricelink;?>"><?php echo JText::_("PRICE");?></a>
</div>



<br class="clear" />

