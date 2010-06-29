<?php
/**
 * Search layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

if(JRequest::getInt('rid',0))
{
	?>
<div id="roundme" class="gb_round_corner">
<div class="gb_form_heading">
<h3><?php echo JText::_('SELECT_REGIONS');?></h3>
</div>
	<?php
	$regions = $this->regions;
}
else
{
	$regions = $this->subregions;
}

if(count($regions))
{

	?>
<ul class="gbInnerHorizontalList">
<?php

foreach($regions as $c)
{
	$link=JRoute::_("index.php?option=$option&task=regions.region&rid=$c->id&time=".time());
	?>
	<li><a href="<?php echo $link;?>" class="gblink"><span><?php echo JText::_($c->title);?></span></a>

	<?php
	if(count($c->children)>0)
	{
		$this->render('expanded',array("subregions"=>$c->children));
	}
	?></li>
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
if(JRequest::getInt('rid',0))
{
	echo "</div>";
}
?>