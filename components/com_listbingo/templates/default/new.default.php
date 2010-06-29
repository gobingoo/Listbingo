<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * post new ad subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');
?>

<script language="javasscript" type="text/javascript">
//<!--
var imgcount = parseInt(<?php echo count($this->row->images); ?>)+1;
var maxlimit = parseInt(<?php echo $this->max_image_upload_limit; ?>);
var alertmsg = '<?php echo JText::_('Image upload limit exceed');?>';
var images = '<?php echo JText::_('IMAGES'); ?>';
//-->
</script>

<?php


if (($this->params->get ( 'enableimages' ))) {
if($this->max_image_upload_limit>count($this->row->images))
{
	$this->addJSI("adinput");
}
}

$suffix=$this->suffix;

if($this->categories[0]->child)
{
	$this->render('categories.default',array('categories'=>$this->categories));
	?>
<br class="clear" />
	<?php
}
else
{
	$this->render('regions.navigation');
}
?>

<div id="roundme" class="gb_round_corner">

<div class="gb_form_heading">
<div class="gb_category_parents"><?php echo $this->parents; ?></div>
<h3><?php 
if(!$this->row->id)
{
	echo JText::_('POST_AD');
}
else
{
	echo JText::_('EDIT_YOUR_FREE_AD');
}
?></h3>

</div>

<?php

if($this->params->get('show_category_alert'))
{
	?>
<div class="gb_alert">
<h4><?php echo JText::_('ABOUT')." ".$this->catinfo->title; ?></h4>
	<?php echo $this->catinfo->description;?></div>
	<?php
}
?> <?php $this->render('form'); ?></div>

