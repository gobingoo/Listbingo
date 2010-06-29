<?php
/**
 * Search layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Alex
 */
defined('_JEXEC') or die('Restricted access');

?>
<div id="roundme" class="gb_round_corner">
<div class="gb_form_heading">
<h3><?php echo JText::_('SELECT_COUNTRIES');?></h3>
</div>

<?php
if(count($this->countries)>0)
{
	
	?>
<ul class="gbHorizontalList">
<?php
foreach($this->countries as $c)
{
	$link=JRoute::_("index.php?option=$option&task=regions.country&cid=$c->id"."&time=".time());
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
<br class="clear" />
</div>