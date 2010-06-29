<?php

class GBCaptchaEngine
{
	var $font;
	var $width=160;
	var $height=40;
	var $text_color;
	var $noise_color;
	var $bg_color;
	var $angle;
	var $bg_size;
	var $grid_color;
	var $first_range1=1;
	var $first_range2=5;
	var $second_range1=6;
	var $second_range2=11;
	var $characters=5;
	var $captcha_character_set ='23456789bcdfghjkmnpqrstvwxyz';

	function hex2rgb($color)
	{
		if ($color[0] == '#')
		$color = substr($color, 1);

		if (strlen($color) == 6)
		list($r, $g, $b) = array($color[0].$color[1],
		$color[2].$color[3],
		$color[4].$color[5]);
		elseif (strlen($color) == 3)
		list($r, $g, $b) = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		else
		return false;

		$r = hexdec($r); $g = hexdec($g); $b = hexdec($b);

		return array($r, $g, $b);
	}

	function generateCode($characters)
	{
		/* list all possible characters, similar looking characters and vowels have been removed */
		$possible = $this->captcha_character_set;
		$code = '';
		$i = 0;
		while ($i < $characters)
		{
			$code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
		}
		return $code;
	}

	function generateTextCaptcha()
	{
		$code = self::generateCode($this->characters);

		/* font size will be 75% of the image height */
		$font_size = $this->height * 0.75;

		$bcolor = self::hex2rgb($this->bg_color);
		$tcolor = self::hex2rgb($this->text_color);
		$ncolor = self::hex2rgb($this->noise_color);

		$image = @imagecreate($this->width, $this->height) or die('Cannot initialize new GD image stream');
		/* set the colours */
		$background_color = imagecolorallocate($image, $bcolor[0],$bcolor[1],$bcolor[2]);
		$this->text_color = imagecolorallocate($image, $tcolor[0],$tcolor[1],$tcolor[2]);
		$this->noise_color = imagecolorallocate($image, $ncolor[0],$ncolor[1],$ncolor[2]);
		imagefill( $image, 0, 0, $background_color );

		/* generate random dots in background */

		for( $i=0; $i<($this->width*$this->height)/3; $i++ )
		{
			imagefilledellipse($image, mt_rand(0,$this->width), mt_rand(0,$this->height), 1, 1, $this->noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($this->width*$this->height)/150; $i++ )
		{
			imageline($image, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $this->noise_color);
		}

		for( $i=0; $i<($this->width*$this->height)/3; $i++ )
		{
			imagefilledellipse($image, mt_rand(0,$this->width), mt_rand(0,$this->height), 1, 1, $this->noise_color);
		}
		/* generate random lines in background */
		for( $i=0; $i<($this->width*$this->height)/150; $i++ )
		{
			imageline($image, mt_rand(0,$this->width), mt_rand(0,$this->height), mt_rand(0,$this->width), mt_rand(0,$this->height), $this->noise_color);
		}
		/* create textbox and add text */
		$textbox = imagettfbbox($font_size, 0, $this->font, $code) or die('Error in imagettfbbox function');
		$x = ($this->width - $textbox[4])/2;
		$y = ($this->height - $textbox[5])/2;
		imagettftext($image, $font_size, 0, $x, $y, $this->text_color,$this->font , $code) or die('Error in imagettftext function');

		imagettftext($image, "10", 0,$this->width-48, $this->height-4, $this->text_color,$this->font , "gobingoo");
		/* output captcha image to browser */
		header('Content-Type: image/jpeg');
		imagejpeg($image);
		imagedestroy($image);

		$session=JFactory::getSession();
		$session->set('security_number',$code);
		exit;
	}

	function generateMathCaptcha()
	{

		$min_font_size = $this->height * 0.45;
		//set maximum font size
		$max_font_size = $this->height * 0.45;

		$operators=array('+','-','*');
		// first number random value; keep it lower than $second_num
		$first_num = rand($this->first_range1,$this->first_range2);
		// second number random value
		$second_num = rand($this->second_range1, $this->second_range2);


		//operation result is stored in $session_var
		eval("\$session_var=".$second_num.$operators[0].$first_num.";");

		// instantiate session
		$session=JFactory::getSession();

		// save the operation result in session to make verifications
		$session->set('security_number',$session_var);

		// start the captcha image
		$img = imagecreate( $this->width, $this->height );

		$bcolor = self::hex2rgb($this->bg_color);
		$tcolor = self::hex2rgb($this->text_color);
		$gcolor = self::hex2rgb($this->grid_color);
		$ncolor = self::hex2rgb($this->noise_color);
		// Some colors. Text is $black, background is $white, grid is $grey
		/*$black = imagecolorallocate($img,$tcolor[0],$tcolor[1],$tcolor[2]);
		$white = imagecolorallocate($img,255,255,255);
		$grey = imagecolorallocate($img,215,215,215);*/

		//set background color
		$background_color = imagecolorallocate($img, $bcolor[0],$bcolor[1],$bcolor[2]);
		//set text color
		$this->text_color = imagecolorallocate($img, $tcolor[0],$tcolor[1],$tcolor[2]);
		//set grid color
		$this->grid_color = imagecolorallocate($img,$gcolor[0],$gcolor[1],$gcolor[2]);
		//set noise color
		$this->noise_color = imagecolorallocate($img, $ncolor[0],$ncolor[1],$ncolor[2]);
		//fill the background color
		imagefill( $img, 0, 0, $background_color );

		// the background grid lines - vertical lines
		for ($t = $this->bg_size; $t<$this->width; $t+=$this->bg_size){
			imageline($img, $t, 0, $t, $this->height, $this->grid_color);
		}

		// background grid - horizontal lines
		for ($t = $this->bg_size; $t<$this->height; $t+=$this->bg_size){
			imageline($img, 0, $t, $this->width, $t, $this->grid_color);
		}

		/*
		 this determinates the available space for each operation element
		 it's used to position each element on the image so that they don't overlap
		 */
		$item_space = $this->width/3;

		// first number
		imagettftext(
		$img,
		rand(
		$min_font_size,
		$max_font_size
		),
		rand( -$this->angle , $this->angle ),
		rand( 10, $item_space-20 ),
		rand( 25, $this->height-25 ),
		$this->text_color,
		$this->font,
		$first_num);

		// operator
		imagettftext(
		$img,
		rand(
		$min_font_size,
		$max_font_size
		),
		rand( -$this->angle, $this->angle ),
		rand( $item_space, 2*$item_space-20 ),
		rand( 25, $this->height-25 ),
		$this->text_color,
		$this->font,
		$operators[0]);

		// second number
		imagettftext(
		$img,
		rand(
		$min_font_size,
		$max_font_size
		),
		rand( -$this->angle, $this->angle ),
		rand( 2*$item_space, 3*$item_space-20),
		rand( 25, $this->height-25 ),
		$this->text_color,
		$this->font,
		$second_num);

		imagettftext($img, "10", 0,$this->width-48, $this->height-4, $this->text_color,$this->font , "gobingoo");

		// image is .jpg
		header("Content-type:image/jpeg");
		// name is secure.jpg
		header("Content-Disposition:inline ; filename=secure.jpg");
		// output image
		imagejpeg($img);;
		exit;
	}
}
?>