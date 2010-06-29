<?php
/**
 *
 *
 */

defined('JPATH_BASE') or die();
gbimport("gobingoo.addonscontroller");

class GControllerCaptcha_Front extends GAddonsController
{

	function __construct($config = array())
	{
		$this->mySess 	=& JFactory::getSession();
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();

		$this->debugMode = $params->get('captcha_enable_debug',0);
		parent::__construct($config);
	}

	function display()
	{
		$view=$this->getView("captcha","html");
		$view->display();
	}

	function generateCaptcha()
	{
		global $option;
				
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
		
		$font = JPATH_ADMINISTRATOR.DS.'components'.DS.$option . DS .'addons' . DS .'captcha'. DS . 'fonts' . DS . $params->get('captcha_font').'.ttf';
		require_once(JPATH_ADMINISTRATOR.DS.'components'.DS.$option . DS .'addons' . DS .'captcha'. DS . 'libraries' . DS . 'gbengine.php' );
		$captcha = new GBCaptchaEngine();
		$captcha->width=$params->get('captcha_width');
		$captcha->height=$params->get('captcha_height');
		$captcha->bg_color=$params->get('captcha_bg_color');
		$captcha->text_color=$params->get('captcha_text_color');
		$captcha->noise_color=$params->get('captcha_noise_color');
		$captcha->grid_color=$params->get('captcha_grid_color');
		$captcha->angle=$params->get('captcha_angle');
		$captcha->first_range1=$params->get('captcha_first_num_range1');
		$captcha->first_range2=$params->get('captcha_first_num_range2');
		$captcha->second_range1=$params->get('captcha_second_num_range1');
		$captcha->second_range2=$params->get('captcha_second_num_range2');
		$captcha->bg_size=$params->get('captcha_bg_size');
		$captcha->characters=$params->get('captcha_character_number');
		$captcha->captcha_character_set=$params->get('captcha_character_set');
		$captcha->font=$font;
		
		switch($params->get('captcha_type'))
		{
			case "textcaptcha";
				$captcha->generateTextCaptcha();
			break;

			case "mathcaptcha";
				$captcha->generateMathCaptcha();
			break;

			default:
				$captcha->generateTextCaptcha();
				break;
					
		}

	}

}
?>