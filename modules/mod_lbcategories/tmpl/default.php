<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$basepathmodule=JUri::root()."modules/mod_lbcategories/";
$document = JFactory::getDocument();

$document->addStylesheet($basepathmodule."css/default.css");
$option="com_listbingo";
$indexing= array();

$k=0;

foreach($list as $l){

	$indexing[$l->id]= $k;
	foreach($l->child as $c)
	{
		$indexing[$c->id]= $k;
	}
	$k++;
}

if(!JRequest::getInt('catid'))
{
	$indexid = 0;
}
else
{
	if(!array_key_exists(JRequest::getInt('catid'),$indexing))
	{
		$indexid = 0;
	}
	else
	{
		$indexid = $indexing[JRequest::getInt('catid')];
	}
}

//$indexid = JRequest::getInt('catid')? $indexing[JRequest::getInt('catid')]:0;




?>

<script type="text/javascript">
<!--
window.addEvent('domready', function() {
	myaccordion('<?php echo $indexid ?>');
});

-->
</script>
<script	type="text/javascript"	src="<?php echo $basepathmodule."js/accordion.js"; ?>"></script>
<dl class="accordion">
<?php
if(count($list)>0)
{
	foreach($list as $l)
	{

		$adcount = 0;

		foreach($indcount as $i=>$val)
		{
			if(in_array($i,$l->adcat))
			{
				$adcount = $adcount+$val;
			}
		}


		$active="";
		$open="";
		if(JRequest::getInt('catid')==$l->id)
		{
			//echo $open="open";
			$active="class=\"gb_toggler_active\"";
		}
		?>
	<dt class="accordion_toggler_1">
	<a <?php echo $active;?> href="<?php echo JRoute::_("index.php?option=$option&task=categories.select&catid=".$l->id); ?>">
	<?php 
	echo $l->title; 
	if($params->get('enable_count'))
	{
		echo " (".$adcount.")";
	} 
	?>
	</a>
	</dt>
	<dd class=" accordion_content_1">
	<dl>
	<?php
	if(count($l->child)>0)
	{
		foreach($l->child as $c)
		{

			$count = 0;

			if(count($c->adcat2)>0)
			{
				foreach($indcount as $i=>$val)
				{
					if(in_array($i,$c->adcat2))
					{
						$count = $count+$val;
					}
				}
			}

			$active="";

			if(JRequest::getInt('catid')==$c->id)
			{

				$active="class=\"gb_toggler_active\"";
			}
			?>
		<dt class="accordion_toggler_2">
		<a <?php echo $active;?> href="<?php echo JRoute::_("index.php?option=$option&task=categories.select&catid=".$c->id); ?>">
		<?php 
		echo $c->title;  
		if($params->get('enable_count'))
		{
			echo " (".$count.")";
		} 
		?>
		</a>
		</dt>
		<?php
		}
			
	}
	?>
	</dl>
	</dd>
	<?php
	}
}
?>
</dl>
