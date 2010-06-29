<?php

$adcount = 0;
if(isset($this->indcount) && count($this->indcount)>0)
{
	foreach($this->indcount as $i=>$val)
	{
		if(in_array($i,$this->cat->adcat))
		{
			$adcount = $adcount+$val;
		}
	}
}

$basepath=JUri::root();

if(!empty($this->wherewasi))
{
	if(!$this->params->get('enable_root_cat_post'))
	{
		if($this->cat->parent_id)
		{
			$link=JRoute::_('index.php?option='.$option.'&task=categories.select&catid='.$this->cat->slug.'&time='.time());
		}
		else
		{
			$link = "#";
		}
	}
	else
	{
		$link=JRoute::_('index.php?option='.$option.'&task=categories.select&catid='.$this->cat->slug.'&time='.time());
	}
}
else
{
	$link=JRoute::_('index.php?option='.$option.'&task=categories.select&catid='.$this->cat->slug.'&time='.time());
}
if($this->cat->logo && $this->params->get('category_enable_logo'))
{

	?>
<a href="<?php echo $link; ?>" style="background: url(<?php echo $basepath.$this->cat->logo; ?>) no-repeat left top; padding:7px 0px 7px 30px">
<?php echo $this->cat->title; ?> <?php
if($this->params->get('enable_adcount'))
{
	echo "(".$adcount.")";
}
?> </a>
<?php
}
else
{
	?>
<a href="<?php echo $link; ?>"> <?php echo $this->cat->title; ?> <?php 
if($this->params->get('enable_adcount'))
{
	echo "(".$adcount.")";
}
?> </a>
<?php
}
?>

<?php
if(isset($this->cat->child) && count($this->cat->child)>0 )
{

	?>

<ul class="gbInnerHorizontalList">
<?php

foreach($this->cat->child as $child)
{
	$this->render('categories.expanded',array('child'=>$child));
}
?>
</ul>
<br class="clear" />
<?php
}
else
{
	//echo JText::_('NOTHING_AVAILABLE');
}

?>