<?php

defined('JPATH_BASE') or die();

/**
 * Renders a category element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class GElementDate extends GElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Date';

	function fetchElement($id=null,$name='field',$value=null,$required=false,$options=null)
	{
		$reqclass="";
		if($required)
		{
			$reqclass=" required";
		}
 		
		JHTML::_('behavior.calendar'); 
		?>
		<input type="text" name="field[<?php echo $id;?>]" id="field<?php echo $name;?>" value="<?php echo $value;?>" class="inputtextbox <?php echo $reqclass;?>" maxlength="<?php echo $options->size;?>"/>
		<img class="calendar" src="templates/system/images/calendar.png" alt="calendar" onclick="return showCalendar('field<?php echo $name;?>' , '%Y-%m-%d');" /> 
		<?php
	}
}
