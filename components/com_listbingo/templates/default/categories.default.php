<?php
/**
 * List layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */


defined('_JEXEC') or die('Restricted access');

?>
<?php $this->render('regions.navigation'); ?>
<div class="gb_category_listing_wrapper">

<div id="roundme" class="gb_round_corner">

<div class="gb_form_heading">
<h3><?php echo JText::_('BROWSE_CATEGORY');?></h3>
</div>

<?php

$n=count($this->categories);
if($n>0)
{
	$k=0;

	for($i=0;$i<$n;$i++)
	{
		$cat=$this->categories[$i];
		?>

<div <?php if($n>1){ ?> class="gb_category_listing" <?php } else { ?>
	class="gb1_category_listing" <?php } ?>><?php 
	$this->render('categories.item',array("cat"=>$cat));
	?></div>

	<?php

	}
}
else
{

	echo JText::_('NO_CATEGORIES');

}

?> <?php
if($n>1)
{
	?><br class="clear" />
	<?php
}
?></div>
</div>

