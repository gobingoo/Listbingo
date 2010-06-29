<?php
$link=JRoute::_('index.php?option='.$option.'&task=categories.select&catid='.$this->child->slug.'&time='.time());

$count = 0;

if(isset($this->child->adcat2) && count($this->child->adcat2)>0)
{
	foreach($this->indcount as $i=>$val)
	{
		if(in_array($i,$this->child->adcat2))
		{
			$count = $count+$val;
		}
	}
}
?>

<li>
<a href="<?php echo $link; ?>">
<span>
<?php echo $this->child->title; ?>

<?php 
if($this->params->get('enable_adcount'))
{
	echo "(".$count.")"; 
}
?>

</span>
</a>
</li>


