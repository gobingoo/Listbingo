<?php

$suffix=$this->params->get($this->params->get('listlayout_thumbnail'));
$link = JRoute::_("index.php?option=$option&task=ads.view&adid=".$this->row->id);
$editlink = JRoute::_("index.php?option=$option&task=ads.edit&catid=".$this->row->category_id."&adid=".$this->row->id);
$closelink = JRoute::_("index.php?option=$option&task=ads.close&adid=".$this->row->id);
$managelink = JRoute::_('index.php?option='.$option.'&task=ads.images&adid='.$this->row->id.'&format=raw');

?>

<div class="record" id="record-<?php echo $this->row->id; ?>">

<div class="gb_listings_content" id="listings">
<div class="gb_listing normal_listing">
<div class="gb_wrapper">
<div class="gb_double_wrapper">

<div class="gb_thumbnail">
<div class="gb_thumbnail_wrapper" title="<?php echo $this->row->title;?>">

<?php 


$baseurl=JUri::root();
$adminbaseurl=JUri::root()."administrator/components/$option/images/";

$basepath = JPATH_ROOT.DS;

if(count($this->row->images)>0)
{	
	?>
	<a class="gb_title_link" title="<?php echo $this->row->title;?>" href="<?php echo $link; ?>">
	<?php
	if(file_exists($basepath.$this->row->images[0]->image.$suffix.".".$this->row->images[0]->extension))
	{
	?>	
	<img src="<?php echo $baseurl.$this->row->images[0]->image.$suffix.".".$this->row->images[0]->extension;?>" width="<?php echo $this->params->get('width_thumbnail_sml',80);?>" height="<?php echo $this->params->get('height_thumbnail_sml',65);?>" alt="<?php echo $this->row->title;?>" />
	<?php 
	}
	else
	{
	?>
	<img src="<?php echo $adminbaseurl."noimage.png"?>" width="<?php echo $this->params->get('width_thumbnail_sml',80);?>" height="<?php echo $this->params->get('height_thumbnail_sml',65);?>"  alt="<?php echo $this->row->title;?>" />
	<?php
	}
	?>
	</a>
	<?php
}
else
{
	?>
	<a class="gb_title_link" title="<?php echo $this->row->title;?>" href="<?php echo $link; ?>">
	<img src="<?php echo $adminbaseurl."noimage.png"?>" width="<?php echo $this->params->get('width_thumbnail_sml',80);?>" height="<?php echo $this->params->get('height_thumbnail_sml',65);?>"  alt="<?php echo $this->row->title;?>" />
	</a>
	<?php 
}
?>
</div>
</div>

<div class="gb_normal_mysection">

<div class="gb_listing_header">
<?php 
echo ListbingoHelper::status($this->row);
?>

<a href="<?php echo $link; ?>"><?php echo $this->row->title;?></a></div>
<div class="gb_listing_body">
<?php echo GHelper::trunchtml($this->row->description,300,"...",false,false);?>
</div>
<div class="gb_listing_normal_attributes"></div>


<div class="gb_myads_listing">
<ul id="gb_myads_controlbtns">
<li>
<a class="gb_viewdetails" href="<?php echo $link;?>"><?php echo JText::_('VIEW_DETAIL');?></a>
</li>

<li>
<a class="gb_edit" href="<?php echo $editlink;?>"><?php echo JText::_('EDIT');?></a>
</li>

<li>

<a  class="gb_gallery" href="<?php echo $managelink; ?>" rel="moodalbox 650 400" title="Manage Images"><?php echo JText::_('MANAGE_IMAGES');?></a>

</li>

<?php 
if($this->row->status==1 || $this->row->status==2)
{
	?>
	<li>
		<a style="cursor:pointer;" class="gb_closetn" id="close-<?php echo $this->row->id; ?>" ><?php echo JText::_('CLOSE');?></a>
	</li>
	<?php
}
?>


<li>
<a style="cursor:pointer;" class="gb_deletebtn" id="a-<?php echo $this->row->id; ?>"><?php echo JText::_('DELETE');?></a>
</li>


</ul>
</div>

</div>


</div> 
<div class="clear"> </div>
</div>
</div>



</div>
</div>