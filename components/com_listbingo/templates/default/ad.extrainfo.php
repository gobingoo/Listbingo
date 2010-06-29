<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * extrainfo subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

if(count($this->extrainfo)>0)
{

	foreach($this->extrainfo as $f)
	{
		
		if($f->view_in_detail && $f->value!="")
		{
			if($f->value=="")
			{
				return false;
			}
		?>
		<li>
			<?php 
			if(!$f->hidecaption)
			{
			?>
			<div class="gb_ad_heading"><strong><?php echo $f->title;?> :</strong></div>
			<?php 
			}
			?>
			<div class="gb_ad_heading_details">
			
			<?php 
			echo $f->view_prefix." ";
		
				GExtrafieldHelper::renderVal($f->type, $f->value);
			
			
			echo " ".$f->view_suffix;
			?>
			</div>
			
			<div class="clear"></div>
			
		</li>
		<?php
		}

	}


}
?>
