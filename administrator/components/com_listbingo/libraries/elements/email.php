<?php

class GElementEmail extends GElement
{
	
	function fetchElement($id=null,$name='field',$value=null,$required=false,$options=null)
	{
	$reqclass="";
		if($required)
		{
			$reqclass=" required validate-email";
		}
		$value=JFilterOutput::cleanText ( $value);
		ob_start();
		?>
	
	<input name="field[<?php echo $id;?>]" type="text" class="inputtextbox <?php echo $reqclass;?>" id="field<?php echo str_replace(" ","_",$name);?>"
			value="<?php echo $value;?>" size="<?php echo $options->size;?>" />
			
		<?php 
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
function render($value="")
	{
		ob_start();
		?>
	<a href="mailto:<?php echo $value;?>"><?php echo $value;?></a>
				
		<?php 
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>