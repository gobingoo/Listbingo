<?php
/**
 * @package Gobingoo
 * @subpackage captcha
 * @author bruce@gobingoo.com
 * @copyright www.gobingoo.com
 *
 *
 * Admin captcha settings form
 *
 */

defined('_JEXEC') or die('Restricted access');
gbaddons("captcha.js.jscolor");
$type=array();

$type[]=JHTML::_('select.option', 'textcaptcha', JText::_('Text Captcha'), 'id', 'title');
$type[]=JHTML::_('select.option', 'mathcaptcha', JText::_('Math Captcha'), 'id', 'title');
?>

<div id="page-captcha">
<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'CAPTCHA_GENERAL_SETTINGS' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CAPTCHA_DEMO' ); ?>::<?php echo JText::_('CAPTCHA_DEMO'); ?>">
				<?php echo JText::_( 'CAPTCHA_DEMO' ); ?> </span></td>
			<td valign="top"><?php 
			$val = time();
			$img = JURI::root()."index.php?option=$option&task=addons.captcha.front.generateCaptcha&value=".$val ;
			$image = '<img src="'.$img.'" />';
			echo $image;
			?></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'ENABLE_CAPTCHA_FOR_FRONTEND' ); ?>::<?php echo JText::_('ENABLE_CAPTCHA_FOR_FRONTEND'); ?>">
				<?php echo JText::_( 'ENABLE_CAPTCHA_FOR_FRONTEND' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_frontend_captcha]' , null ,  $this->config->get('enable_frontend_captcha') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CHOOSE_CAPTCHA' ); ?>::<?php echo JText::_('CHOOSE_CAPTCHA'); ?>">
				<?php echo JText::_( 'CHOOSE_CAPTCHA' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.genericlist',  $type, 'config[captcha_type]', 'class="inputbox"', 'id', 'title',  $this->config->get('captcha_type') );;?>
			</td>
		</tr>


		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CAPTCHA_WIDTH_IN_PIXEL' ); ?>::<?php echo JText::_('CAPTCHA_WIDTH_IN_PIXEL'); ?>">
				<?php echo JText::_( 'CAPTCHA_WIDTH_IN_PIXEL' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[captcha_width]"
				value="<?php echo $this->config->get('captcha_width' );?>" size="45" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CAPTCHA_HEIGHT_IN_PIXEL' ); ?>::<?php echo JText::_('CAPTCHA_HEIGHT_IN_PIXEL'); ?>">
				<?php echo JText::_( 'CAPTCHA_HEIGHT_IN_PIXEL' ); ?> </span></td>
			<td valign="top"><input type="text" name="config[captcha_height]"
				value="<?php echo $this->config->get('captcha_height' );?>"
				size="45" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CAPTCHA_BG_COLOR' ); ?>::<?php echo JText::_('CAPTCHA_BG_COLOR'); ?>">
				<?php echo JText::_( 'CAPTCHA_BG_COLOR' ); ?> </span></td>
			<td valign="top"><input class="color" type="text"
				name="config[captcha_bg_color]"
				value="<?php echo $this->config->get('captcha_bg_color' );?>"
				size="45" /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'CAPTCHA_TEXT_COLOR' ); ?>::<?php echo JText::_('CAPTCHA_TEXT_COLOR'); ?>">
				<?php echo JText::_( 'CAPTCHA_TEXT_COLOR' ); ?> </span></td>
			<td valign="top"><input class="color" type="text"
				name="config[captcha_text_color]"
				value="<?php echo $this->config->get('captcha_text_color' );?>"
				size="45" /></td>
		</tr>


		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'FONT_FOR_CAPTCHA' ); ?>::<?php echo JText::_('FONT_FOR_CAPTCHA'); ?>">
				<?php echo JText::_( 'FONT_FOR_CAPTCHA' ); ?> </span></td>
			<td valign="top"><select id="captcha_font" name=config[captcha_font]>
			<?php

			if(!empty($this->fonts))
			foreach($this->fonts as $key => $value) {
				$selected	= ( JString::trim($key) == $this->config->get('captcha_font' ) ) ? ' selected="true"' : '';
				?>
				<option value="<?php echo $key;?>" <?php echo $selected;?>><?php echo $value;?></option>
				<?php
			}
			?>
			</select></td>
		</tr>


	</tbody>
</table>
</fieldset>
</div>

<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'TEXTCAPTCHA_SETTINGS' ); ?></legend>
<table class="admintable" cellspacing="1">

	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'NUMBER_OF_CHARACTER' ); ?>::<?php echo JText::_('NUMBER_OF_CHARACTER'); ?>">
			<?php echo JText::_( 'NUMBER_OF_CHARACTER' ); ?> </span></td>
		<td valign="top"><input type="text"
			name="config[captcha_character_number]"
			value="<?php echo $this->config->get('captcha_character_number' );?>"
			size="45" /></td>
	</tr>

	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'POSSIBLE_CHARACTERS_SET' ); ?>::<?php echo JText::_('POSSIBLE_CHARACTERS_SET'); ?>">
			<?php echo JText::_( 'POSSIBLE_CHARACTERS_SET' ); ?> </span></td>
		<td valign="top"><input type="text"
			name="config[captcha_character_set]"
			value="<?php echo $this->config->get('captcha_character_set' );?>"
			size="45" /></td>
	</tr>

	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'CAPTCHA_NOISE_COLOR' ); ?>::<?php echo JText::_('CAPTCHA_NOISE_COLOR'); ?>">
			<?php echo JText::_( 'CAPTCHA_NOISE_COLOR' ); ?> </span></td>
		<td valign="top"><input class="color" type="text"
			name="config[captcha_noise_color]"
			value="<?php echo $this->config->get('captcha_noise_color' );?>"
			size="45" /></td>
	</tr>


</table>
</fieldset>


<fieldset class="adminform"><legend><?php echo JText::_( 'MATHCAPTCHA_SETTINGS' ); ?></legend>
<table class="admintable" cellspacing="1">


	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'CAPTCHA_GRID_COLOR' ); ?>::<?php echo JText::_('CAPTCHA_GRID_COLOR'); ?>">
			<?php echo JText::_( 'CAPTCHA_GRID_COLOR' ); ?> </span></td>
		<td valign="top"><input class="color" type="text"
			name="config[captcha_grid_color]"
			value="<?php echo $this->config->get('captcha_grid_color' );?>"
			size="45" /></td>
	</tr>

	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'ANGLE' ); ?>::<?php echo JText::_('ANGLE'); ?>">
			<?php echo JText::_( 'ANGLE' ); ?> </span></td>
		<td valign="top"><input type="text" name="config[captcha_angle]"
			value="<?php echo $this->config->get('captcha_angle' );?>" size="45" /></td>
	</tr>

	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'BACKGRUOND_SIZE' ); ?>::<?php echo JText::_('BACKGRUOND_SIZE'); ?>">
			<?php echo JText::_( 'BACKGRUOND_SIZE' ); ?> </span></td>
		<td valign="top"><input type="text" name="config[captcha_bg_size]"
			value="<?php echo $this->config->get('captcha_bg_size' );?>"
			size="45" /></td>
	</tr>


	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'RANGE_FOR_FIRST_NUM' ); ?>::<?php echo JText::_('RANGE_FOR_FIRST_NUM'); ?>">
			<?php echo JText::_( 'RANGE_FOR_FIRST_NUM' ); ?> </span></td>
		<td valign="top"><input type="text"
			name="config[captcha_first_num_range1]"
			value="<?php echo $this->config->get('captcha_first_num_range1' );?>"
			size="20" />&nbsp;to&nbsp; <input type="text"
			name="config[captcha_first_num_range2]"
			value="<?php echo $this->config->get('captcha_first_num_range2' );?>"
			size="20" /></td>
	</tr>


	<tr>
		<td class="key"><span class="hasTip"
			title="<?php echo JText::_( 'RANGE_FOR_SECOND_NUM' ); ?>::<?php echo JText::_('RANGE_FOR_SECOND_NUM'); ?>">
			<?php echo JText::_( 'RANGE_FOR_SECOND_NUM' ); ?> </span></td>
		<td valign="top"><input type="text"
			name="config[captcha_second_num_range1]"
			value="<?php echo $this->config->get('captcha_second_num_range1' );?>"
			size="20" />&nbsp;to&nbsp; <input type="text"
			name="config[captcha_second_num_range2]"
			value="<?php echo $this->config->get('captcha_second_num_range2' );?>"
			size="20" /></td>
	</tr>

</table>
</fieldset>

</div>



<div class="clr"></div>



</div>
