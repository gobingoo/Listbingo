<?php

jimport("joomla.mail.mail");


class GMail extends JMail
{

	/*function setPatternAndValues($patternvalues=null)
	 {

	 }*/

	var $transform=array();

	var $recepients=array();

	var $body=null;

	var $subject=null;

	var $cooked_body=null;

	var $cooked_subject=null;

	var $sender=null;


	function __construct()
	{

	}

	function setTransform($arr=array())
	{
		$this->transform=$arr;
	}



	function init()
	{
		$pattern=array();

		$values=array();

		if(count($this->transform)>0)
		{
			foreach($this->transform as $t=>$v)
			{
				$pattern[]='/{'.$t.'}/i';

				$values[]=$v;
			}
			ksort($pattern);
			ksort($values);
				
			$this->cooked_body = preg_replace( $pattern, $values, $this->Body);
			$this->cooked_subject = preg_replace( $pattern, $values, $this->Subject);
				
		}
			
	}


	function send()
	{
		$this->setSubject($this->cooked_subject);
		$this->setBody($this->cooked_body);

		// Are we sending the email as HTML?
		$this->IsHTML(true);
			
		if(parent::Send())
		{
			return true;
		}
		else
		{
			throw new MailException("Mail Could not be sent",404);
		}


	}
}
?>