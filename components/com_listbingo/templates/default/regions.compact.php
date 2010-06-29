<?php
/**
 * Search layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

?>

<?php $this->render('navigation',array("params"=>$this->params));?>

<div id="roundme" class="gb_round_corner">
<div class="gb_form_heading">
<h3><?php echo JText::_('SELECT_REGIONS');?></h3>
</div>


<?php

if(count($this->regions)>0)
{
	?>
<ul class="gbHorizontalList">
<?php
foreach($this->regions as $c)
{
/*	if(isset($c->children)&&count($c->children)>0)
	{
		$link=JRoute::_("index.php?option=$option&task=regions.expand&rid=$c->id&time=".time());
	}
	else
	{
		$link=JRoute::_("index.php?option=$option&task=regions.region&rid=$c->id&time=".time());
	}	*/
	
	?>

	<li><a href="<?php echo $c->link;?>" class="gblink"><span><?php echo JText::_($c->title);?></span></a>

	<?php
	if($this->params->get('expand_directory'))
	{
	if(isset($c->children)&&count($c->children)>0)
	{
		$this->render('expanded',array("subregions"=>$c->children));
	}
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