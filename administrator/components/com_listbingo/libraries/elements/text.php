<?php
gbimport("gobingoo.element");

class GElementText extends GElement
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
	
	<input name="field[<?php echo $id;?>]" type="text" class="inputtextbox <?php echo $reqclass;?>" id="field<?php echo $name;?>"
			value="<?php echo $value;?>" size="<?php echo $options->size;?>" />
			
		<?php 
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>