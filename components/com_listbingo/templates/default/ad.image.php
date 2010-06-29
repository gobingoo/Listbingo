<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * ad-image subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
$gallery=new stdClass();
$gallery->shown=false;
$gallery->images=$this->images;
$gallery->params=$this->params;
GApplication::triggerEvent('onLoadSlider',array(& $gallery));

if(!$gallery->shown)
{


$this->addCSS('smoothgallery');
$this->addJSI('smoothgallery.gallery');
$count=count($this->images);
$baseurl=JUri::root();
$basepath=JPATH_ROOT;
$midthumb=$this->params->get('suffix_thumbnail_mid');
$smlthumb=$this->params->get('suffix_thumbnail_sml');
$lrgthumb=$this->params->get('suffix_thumbnail_lrg');
$slidewidth=$this->params->get('width_thumbnail_mid');
$slideheight=$this->params->get('height_thumbnail_mid');

?>
<style>
#myGallery
{
width: <?php echo $slidewidth;?>px !important;
height: <?php echo $slideheight;?>px !important;
} 
</style>

<?php echo $this->addJSI('smooth');?>
		
<div id="myGallery">
<?php 
if($count>0)
{
	foreach($this->images as $img)
	{
		if(file_exists($basepath.$img->image.$midthumb.".".$img->extension))
		{
		?>
		
		<div class="imageElement">
			<h3><?php echo $this->title;?></h3>
			<p><?php echo $this->title;?></p>
			
			<img src="<?php echo $baseurl.$img->image.$midthumb.".".$img->extension;?>" class="full" width="" height="" />
			<img src="<?php echo $baseurl.$img->image.$smlthumb.".".$img->extension;?>" class="thumbnail" />
		</div>
		<?php 
		}
	}
}
?>	
</div>
<?php 
}