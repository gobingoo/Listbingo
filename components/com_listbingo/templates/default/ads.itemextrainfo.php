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
	$i=0;
	//var_dump($this->extrainfo);
?>
<div class="gb_item_extrainfo">
<?php 
	foreach($this->extrainfo as $f)
	{
		
		
		
		if($f->view_in_summary && $f->value!="")
		{

			if($i==0)
			{
				$class="class=\"bordernone\"";
			}
			else
			{
				$class="";
			}
		?>
		<span <?php echo $class;?>>
			<?php 
			if(!$f->hidecaption)
			{
			?>
			<strong><?php echo $f->title;?> :</strong>
			<?php 
			}
			?>
			
			
			<?php 
			
			echo $f->view_prefix." ";
			
			/*if($f->type!="country")
			{
				echo $f->value;
			}	
			else
			{
				GExtrafieldHelper::renderVal($f->type, $f->value);
			}*/
			
			GExtrafieldHelper::renderVal($f->type, $f->value);
			
			echo " ".$f->view_suffix;
			?>
			
		</span>
		<?php
		$i++;
		}
		
	}
?>
</div>
<?php 

}
?>
