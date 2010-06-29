<?php
/**
 *
 * Category Ajax Input for Admin
 */

defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.extrafieldhelper");

if(count($this->extrafields)>0)
{
	$class="class=\"gb_label_container\"";
	$divclass="";
	foreach($this->extrafields as $f)
	{
		if($f->type=="radio")
		{
			
			$divclass="class=\"gb_label_holder\"";
		}
		else
		{
			$divclass="";
		}
	?>
	<div <?php echo $class; ?>>
	
	<label for="field<?php echo $f->title;?>" class="key" title="<?php echo $f->description;?>"> 
	<?php 
	if(!$f->hidecaption)
	{
		echo JText::_($f->title);
	}
	else
	{
		echo "&nbsp;";
	}
	?>
	
	</label>
	<div <?php echo $divclass;?>>
	<?php 
	echo $f->edit_prefix." ";
	
	GExtrafieldHelper::render($f);
	echo " ".$f->edit_suffix;
	
	if($f->required && $f->type!="radio" && $f->type!="checkbox")
	{
		?>
		<span class="gb_required_field">&nbsp;*&nbsp;</span>
		<?php
	}
	?>
	
	</div>
	<div class="clear"></div>
	</div>
	<?php
	}

}
?>
