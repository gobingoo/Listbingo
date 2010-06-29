<?php
/**
 * Region and Country layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

?>

<script type="text/javascript">
//<!--
_EVAL_SCRIPTS=true;

window.addEvent('domready', init);

function init() 
{
	myTabs1 = 
		new mootabs('myTabs', {height: '350px', width: '100%', useAjax: false, ajaxUrl: '',
			 ajaxLoadingText: 'Loading...'});
}
//-->
</script>

<div id="myTabs">
<ul class="mootabs_title">
	<?php 
	if($this->params->get('region_selection'))
	{
	?>
	<li title="Regions"><span><?php echo JText::_('REGIONS_IN')." ".$this->countrytitle;?></span></li>
	<?php 
	}
	?>
	<?php 
	if($this->params->get('country_selection'))
	{
	?>
	<li title="Countries"><span><?php echo JText::_('COUNTRIES');?></span></li>
	<?php 
	}
	?>
</ul>

<?php 
if($this->params->get('region_selection'))
{
?>
<div id="Regions" class="mootabs_panel">
<div id="tab1">
<h3><?php echo JText::_('SELECT_REGIONS');?></h3>
<?php

if(count($this->regions)>0)
{
	?>
<ul class="gbHorizontalList">
<?php
foreach($this->regions as $c)
{
	$link=JRoute::_("index.php?option=$option&task=regions.expand&rid=$c->id&time=".time());
	?>

	<li><a href="<?php echo $link;?>" class="gblink"><span><?php echo JText::_($c->title);?></span></a>

	<?php
	if(isset($c->children)&&count($c->children)>0)
	{
		$this->render('expanded',array("subregions"=>$c->children));
	}
	?>
	</li>

	<?php

}
?>

</ul>

<?php
}
else
{
	echo JText::_("NO_REGIONS");

}
?>
</div>
</div>
<?php 
}
?>


<?php 
if($this->params->get('country_selection'))
{
?>
<div id="Countries" class="mootabs_panel">
<div id="tab2">
<h3><?php echo JText::_('SELECT_COUNTRY');?></h3>
<?php
if(count($this->countries)>0)
{
	
	?>
<ul class="gbHorizontalList">
<?php
foreach($this->countries as $c)
{
	$link=JRoute::_("index.php?option=$option&task=regions&cid=$c->id"."&time=".time());
	?>
	<li><a href="<?php echo $link;?>" class="gblink"><span><?php echo JText::_($c->title);?></span></a>
	</li>
	<?php

}
?>

</ul>
<?php
}
else
{
	echo JText::_("NO_COUNTRIES");

}
?>
</div>
</div>
<?php 
}
?>
</div>
