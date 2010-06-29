<?php
global $option;
if ($this->maxlimit > count ( $this->row->images )) {
	?>
<script type="text/javascript">
//<!--

var imgcount_m = parseInt(<?php
	echo count ( $this->row->images );
	?>)+1;
var maxlimit_m = parseInt(<?php
	echo $this->maxlimit;
	?>);
var alertmsg_m = '<?php
	echo JText::_ ( 'Image upload limit exceed' );
	?>';

var count_alert = '<?php
	echo JText::_ ( 'Please select atleast one image' );
	?>';


var currentcount_m=0;

window.addEvent('domready',function(){
	$('deleteBtn').addEvent('click',function(){
		var boxchecked = document.adminForm.boxchecked.value;

		if(boxchecked>0)
		{
			if(!confirm("<?php echo JText::_("Are you sure you want to continue?");?>"))
			{
				return false;
			}
			else
			{
				document.adminForm.submit();
			}

		}
		else
		{
			alert(count_alert);
		}
	});
	$('addb_m').addEvent('click',function(){
		if(imgcount_m<maxlimit_m)
		{
		
			var x_m=currentcount_m;
			currentcount_m++;
		
		var div_main_container = new Element('li',{'class':'imageholder','id':'img_'+currentcount_m}).injectInside($('manageImageUpload'));
				
		var file_input = new Element('input',{'name':'images[]','type':'file'});
		
		file_input.injectInside(div_main_container);

		var div_remove_holder = new Element('div',{'class':'remove','id':'gb_manage_remove_image'}).injectInside(div_main_container);
		var anchor= new Element('a');
		anchor.setText('Remove');
		anchor.injectInside(div_remove_holder);
		anchor.addEvent('click',function(){
			div_main_container.remove();
			imgcount_m--;
		});
		
		imgcount_m++;
		
				
		}
		else
		{
			alert(alertmsg_m);
		}
			 
	});	


	
});

//-->
</script>
<?php
}
?>

<?php
$smlthumb = $this->params->get ( 'suffix_thumbnail_sml' );
?>
<div class="gb_ad_images">
<form name="adminForm" id="adminForm" action="index.php" method="post">
<div class="gb_checkAllBtn"><span>
<!--<button class="gbButton validate" id="trashBtn"></button>
-->
<input type="button" class="gbButton validate" name="delete" id="deleteBtn" value="<?php echo JText::_('DELETE');?>" /> 

</span> <input type="checkbox" name="toggle" value=""
	onclick="checkAll(<?=count ( $this->row->images )?>);" /><?php
	echo JText::_ ( 'CHECK_ALL' );
	?>
<br class="clear" />
</div>

<?php
if (count ( $this->row->images ) > 0) {
	$i = 0;
	foreach ( $this->row->images as $im ) {
		$checked = JHTML::_ ( 'grid.id', $i, $im->id );
		?>
		<div class="gb_manage_image_wrapper">
		<ul class="gb_ad_images_list">
	<li><?php
		echo $checked;
		?></li>
	<li><img
		src="<?php
		echo JUri::root () . $im->image . $smlthumb . "." . $im->extension;
		?>"
		alt="<?php
		echo $this->row->title;
		?>" /></li>
	
	</ul>
	<br class="clear" />
	</div>
	<?php
		$i ++;
	}
}
?>
	

<input type="hidden" name="boxchecked" id="boxchecked" value="0" /> <input
	type="hidden" name="option" value="<?php
	echo $option?>" /> <input
	type="hidden" name="task" value="ads.deleteImages" /></form>
</div>

<?php
if ($this->maxlimit > count ( $this->row->images )) {
	?>

<div id="manageFormHolder">
<fieldset><legend><strong><?php
	echo JText::_ ( 'UPLOAD_IMAGES' );
	?></strong></legend>
<form action="<?
	echo JRoute::_ ( 'index.php' );
	?>" method="post"
	id="josForm" name="josForm" class="form-validate"
	enctype="multipart/form-data"><input type="hidden" name="id" id="id"
	value="<?php
	echo $this->row->id?>" />

<ul>

	<div id="manageImageUpload">
	<li id="img_0" class="imageholder"><input type="file" name="images[]" />
	<div class="remove" id="gb_manage_remove_image" style="display: none;"><a>Remove</a></div>
	</li>

	</div>

</ul>
<br class="clear" />
<div class="addmoreManageImages"><a id="addb_m"
	href="javascript:void(0);"><?php
	echo JText::_ ( "ADD_MORE_IMAGES" );
	?></a>
&nbsp;</div>


<button class="gbButton validate" type="submit"><?php
	echo JText::_ ( 'Upload' );
	?></button>
<input type="hidden" name="option" value="<?php
	echo $option?>" /> <input
	type="hidden" name="task" value="ads.uploadImages" /> <?php
	echo JHTML::_ ( 'form.token' );
	?>
</form>
</fieldset>
</div>
<?php
} else {
	echo JText::_ ( 'Image upload limit exceed' );
}

?>