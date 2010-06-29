<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
?>
	<?php 
	echo $this->pane->startPanel( 'Configuration', 'setupmean' );
	?>
	<ol>
		  <li>Captcha Demo show the demo according to values filled in associated field.<br/></li>
		  <li>Enter the width of the Captcha to be shown in pixel.<br/></li>
		  <li>Enter the height of the Captcha to be shown in pixel.<br/></li>
		  <li>Number of characters to shown be in the Captcha<br/></li>
		  <li>Hash value of background color will be shown here as you select the color.<br/></li>
		  <li>Select the text color of Captcha.<br/></li>
		  <li>Noise color is the color of noise in Captcha<br/></li>
		  <li>Select the font to show the characters in Captcha as you want.<br/></li>
		  <li>Select the font size of the Captcha character.<br/></li>
		  <li>Captcha lifetime defines the life of the Captcha.<br/></li>
		  <li>It shows the depth of the noise in Captcha image.<br/></li>
		  <li>This is used to enable or disable  the debug messages.</li> 
	</ol>
	<?php
		echo $this->pane->endPanel();
		
	