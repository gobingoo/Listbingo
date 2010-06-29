<?php

class GElementUrl extends GElement
{
	
	function fetchElement($id=null,$name='field',$value=null,$required=false,$options=null)
	{
	$reqclass="";
		if($required)
		{
			$reqclass=" required";
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
		
		$check = explode("://", $value);
		//var_dump($check);
		$new_url = "";
		
		if(count($check)>1)
		{
			$new_url = $value; 
		}
		else
		{
			$new_url = "http://".$value;
		}
		
		?>
	<a href="<?php echo $new_url;?>" target="_blank"><?php echo $value;?></a>
				
		<?php 
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>