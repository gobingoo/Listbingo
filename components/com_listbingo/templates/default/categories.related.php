<?php
/**
 * List layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */

defined('_JEXEC') or die('Restricted access');

if(count($this->relatedcat)>0)
{
?>

<div class="gb_category_listing_wrapper">

<div id="roundme" class="gb_round_corner">

<div class="gb_form_heading">
<h3><?php echo JText::_('RELATED_CATEGORIES');?></h3>
</div>
<div class="gb_related_cat_listing">
<ul class="gbInnerRelatedCatList">
<?php


	foreach($this->relatedcat as $rc)
	{
		$rclink = JRoute::_('index.php?option='.$option.'&task=categories.select&catid='.$rc->id,false);
		?>
		<li><a href="<?php echo $rclink;?>"><?php echo $rc->title;?></a></li>
		<?php	
	}


?>
</ul>
<br class="clear" />
</div>
<br class="clear" />
</div>
</div>
<br class="clear" />
<?php 
}
?>
