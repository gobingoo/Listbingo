<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

/**
 * Renders a category element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class JElementColor extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Color';

	function fetchElement($name, $value, &$node, $control_name)
	{
		ob_start();
		$jspath=JUri::root()."modules/mod_lbtagcloud/js/jscolor.js";		
		?>
		<script src="<?php echo $jspath;?>"></script>
		<label> 
			<input name="<?php echo $control_name;?>[<?php echo $name;?>]" type="text" class="color" id="<?php echo  $control_name.$name ?>" value="<?php echo $value;?>" size="10" /> 
		</label>
		<?php
		$content=ob_get_contents();
		ob_end_clean();
		return $content;

	}
}
