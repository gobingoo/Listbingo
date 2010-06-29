<?php

defined('JPATH_BASE') or die();

gbimport( 'gobingoo.event' );

class evtCaptchaCaptcha extends GEvent
{
	function onSettingsNavigation()
	{
		?>
<li><a id="captcha"><?php echo JText::_( 'Captcha' ); ?></a></li>
		<?php
	}

	function onSettingsPageDisplay(&$params=null)
	{
		$controller=gbaddons("captcha.controller.admin");
		$controller->captchaSettingsPage($params);

	}

	function onAfterFormDisplay(&$rows=null,&$params=null)
	{
		global $option;
		if($params->get('enable_frontend_captcha'))
		{
			$controller=gbaddons("captcha.controller.front");
			$controller->display($params);
		}
		else
		{
			return false;
		}
	}

	/*
	 * to check the user inputted value and session value
	 */
	function onBeforFormProcess(&$rows,&$params=null)
	{
		global $mainframe, $option;

		if(is_null($params))
		{
			return true;
		}
		if($params->get('enable_frontend_captcha',0)==1)
		{
			$previouslink= $_SERVER['HTTP_REFERER'];

			$uri=new JUri($previouslink);

			// get user session value
			$user_sess_value = $rows['security_number'];

			// instantiate session
			$session=JFactory::getSession();
			//get actual session value
			$sessvar=$session->get('security_number');
			//compare user session value and actual session value
			if($user_sess_value==$sessvar)
			{
				return true;
			}
			else
			{
				$msg = JText::_('CAPTCHA_CODE_INVALID');
				$link = JRoute::_("index.php?".$uri->getQuery(),false);
				
				//$this->setRedirect('index.php', $message);
				//$mainframe->redirect($link,$msg,'error');
				GApplication::redirect($link,$msg,'error');
			}
		}
		else
		{
			return true;
		}


	}

}
?>