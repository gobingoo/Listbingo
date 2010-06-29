<div class="lb_regions_wrapper"><?php 
$c = $mainframe->getUserState($option.'country');

$clink = JRoute::_("index.php?option=com_listbingo&task=countries",false);
$rlink = JRoute::_("index.php?option=com_listbingo&task=regions&cid=".$c,false);

if($params->get('country') && $params->get('region'))
{

	if(!empty($lists[0]))
	{
		echo "<a href=\"$clink\">".$lists[0]->title."</a>"; // displays country
	}

	if(!empty($lists[0]) && !empty($lists[1]))
	{
		echo " >> <a href=\"$rlink\">".$lists[1]->title."</a>"; // displays region
	}

	if(empty($lists[0]) && empty($lists[1]))
	{
		echo JText::_('COUNTRY_REGION_NOT_SET');
	}
}
if(!$params->get('country') && $params->get('region'))
{

	if(!empty($lists[0]) && !empty($lists[1]))
	{
		echo "<a href=\"$rlink\">".$lists[1]->title."</a>"; // displays regions
	}
	else
	{
		echo JText::_('REGION_NOT_SET');
	}
}
if($params->get('country') && !$params->get('region'))
{

	if(!empty($lists[0]))
	{
		echo "<a href=\"$clink\">".$lists[0]->title."</a>";  // displays country
	}

	else
	{
		echo JText::_('COUNTRY_NOT_SET');
	}
}
?>
</div>
