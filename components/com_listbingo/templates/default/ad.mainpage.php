<?php
/**
 * ad layout for default template
 *
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

$basepath=JUri::root();
global $option;

?>


<!-- detail part starts-->
<div id="roundme" class="gb_round_corner">
<div class="gb_item_detail_wrapper <?php echo $this->row->classname; ?>">
<div class="gb_ad_globalid">

<?php echo JText::_('ID')." : ".$this->row->globalad_id;?></div>
<h2><?php echo $this->row->title;?>
<?php GApplication::triggerEvent('onAfterLoadTitle',array(& $this->row,& $this->params)); ?>
</h2>

<div class="gb_item_heading_wrapper">

<div class="gb_ad_posted_details">

<img
	src="<?php echo JUri::root()."components/$option/templates/default/images/user.png"?>"
	alt="User" /> 
	<?php 
	echo $this->row->aduser->profilelink;
	?>
	
	&nbsp;&nbsp;&nbsp;&nbsp; <img
	src="<?php echo JUri::root()."components/$option/templates/default/images/calender.png"?>"
	alt="Posted Date" /> <?php echo $this->row->created_date;?>&nbsp;&nbsp;&nbsp;&nbsp;
<img
	src="<?php echo JUri::root()."components/$option/templates/default/images/hit.png"?>"
	alt="Hit Counter" /> <?php echo $this->row->views;?>
	
	</div>

<div class="gb_ad_addons">
<ul class="gb_popup_action">
<?php GApplication::triggerEvent('onBeforeDisplayTitle',array(& $this->row,& $this->params)); ?>
	<li><img
		src="<?php echo JUri::root()."components/$option/templates/default/images/post-ad.png"?>" />
<?php 
	echo $this->row->adlink;
?>
	
	</li>

</ul>
</div>
<br class="clear" />
</div>

<div class="gb_detail_section">
<div class="gb_detail_right">
<?php 
if($this->params->get('enableimages',0))
{
?>
<?php echo $this->adimages; ?> 
<?php 
}
?>
<?php GApplication::triggerEvent('onAfterLoadDetail',array(& $this->row,& $this->params)); ?>
<?php GApplication::triggerEvent('onAfterDisplayContent',array(& $this->row,& $this->params)); ?>

</div>


<div class="gb_listing_normal_attributes">
<ul>
	<?php 
	if($this->row->hasprice && $this->params->get('enable_field_price',0))
	{
	?>
	<li>
	<div class="gb_ad_heading"><strong><?php echo JText::_('PRICE'); ?></strong></div>
	<div class="gb_ad_heading_details"><?php echo $this->price; ?></div>
	<div class="clear"></div>
	</li>
	<?php 
	}
	?>
	<?php
	if($this->showcontact)
	{
		?>
	<li>
	<div class="gb_ad_heading"><strong><?php echo JText::_('EMAIL'); ?></strong></div>
	<div class="gb_ad_heading_details"><?php echo $this->row->aduser->email; ?></div>
	<div class="clear"></div>
	</li>
	<?php	
	}
	$this->render('address',array("address"=>$this->address,"regions"=>$this->regions));
	?>
	<?php $this->render('extrainfo',array("extrainfo"=>$this->row->extrafields));?>
</ul>

<div class="description">
<h3 class="description_title"><?php echo JText::_('DESCRIPTION');?></h3>
<span class="sbody"> <?php echo $this->row->description;?> </span></div>
</div>

<?php 

if($this->params->get('enable_field_tags',0))
{
	echo $this->row->tags;
} 
?>
<br class="clear" />


</div>

</div>

<!-- detail part end--></div>
