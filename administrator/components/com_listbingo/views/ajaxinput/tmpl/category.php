<?php 
/**
 * 
 * Category Ajax Input for Admin 
 */

defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.extrafieldhelper");
?>
<?php if(count($this->fields)>0)
	{
		?>
 <fieldset class="adminform">
  
  <legend><?php echo JText::_('More information on Ad');?></legend>
 
  <table width="100%" cellpadding="5" class="admintable">
<?php 
		foreach($this->fields as $f)
		{
			?>
			 <tr>
      <td width="30%"  valign="top" class="key"><label for="field<?php echo $f->title;?>" class="key" title="<?php echo $f->description;?>">
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
	
	
	</label></td>
      <td>
      <?php 
      echo $f->edit_prefix." ";
      GExtrafieldHelper::render($f);
      echo $f->edit_suffix." ";
      ?></td>
      
    </tr>
			
			<?php 
			
		}?>
		</table>
	</fieldset>
		<?php 
		
	}?>
	