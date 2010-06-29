<?php

class GElementTextarea extends GElement
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

<textarea cols="<?php echo $options->size;?>" rows="10" name="field[<?php echo $id;?>]" class="inputtextarea <?php echo $reqclass;?>" id="field<?php echo $name;?>"/><?php echo $value;?></textarea>

		<?php
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}
}
?>