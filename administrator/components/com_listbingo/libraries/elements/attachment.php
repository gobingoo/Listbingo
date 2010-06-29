<?php

defined('JPATH_BASE') or die();

/**
 * Renders a checkbox element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class GElementAttachment extends GElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Attachment';

	function fetchElement($id=null,$name='field',$value=null,$required=false,$options=null)
	{
		$reqclass="";
		ob_start();
		if($required)
		{
			$reqclass=" required";
		}

		 $value=JFilterOutput::cleanText ( $value);
	
		
		
		?>

<input
	name="field[<?php echo $id;?>]" type="file"
	class="inputtextbox <?php //Not applicable in this version! echo $reqclass;?>"
	id="field<?php echo $name;?>" value=""
	size="<?php echo $options->size;?>" />
	<?php 

	if(!empty($value))
	{
		jimport('joomla.filesystem.path');
		$value = JPath::clean($value);
		
			 $attachmentlink=JUri::root(true).$value;
		 $valuearray=explode("/",$value);
		 $text=array_pop($valuearray);
		 
	?>
	<br/>
	<div><strong>
	<?php echo JText::_("CURRENT_ATTACHMENT");?>
	</strong>
	<br/>
	<input type="checkbox" name="available_attach[<?php echo $id;?>]" checked="checked" value="<?php echo $value;?>"/><a href="<?php echo $attachmentlink;?>"><?php echo $text;?>
	</a>
	</div>
	<?php 
	}
	?>

		<?php
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}

	function render($value="")
	{
		ob_start();
		jimport('joomla.filesystem.path');
		$value = JPath::clean($value);
		
		 $attachmentlink=JUri::root(true).$value;
		 $valuearray=explode("/",$value);
		 $text=array_pop($valuearray);
		 
		?>
<a href="<?php echo $attachmentlink;?>"><?php echo $text;?></a>

		<?php
		$content=ob_get_contents();
		ob_end_clean();
		return $content;
	}

}
