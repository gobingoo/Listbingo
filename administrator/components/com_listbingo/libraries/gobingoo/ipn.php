<?php

// Check to ensure this file is within the rest of the framework
defined('JPATH_BASE') or die();

class GIPN {

	private $url=null;

	private $postvars=null;

	function __construct($url='')
	{
		$this->url=$url;
		$this->postvars=array();
	}

	function setURL($url='')
	{
		$this->url=$url;
	}

	function addVar($var='',$value='')
	{
		$this->postvars[$var]=$value;
	}

	function send()
	{
		
		gbimport("gobingoo.snoopy");

		$posturl=JUri::getInstance($this->url);
		$urlvars=$posturl->getQuery(true);
		if(count($urlvars)>0)
		{
			foreach($urlvars as $key=>$uv)
			{
				self::addVar($key,$uv);
			}
		}
		$newurl=$posturl->toString(array('scheme', 'user', 'pass', 'host', 'port', 'path'));
		$snoopy=new GSnoopy();
		
		$ret=$snoopy->submit($newurl,$this->postvars);
		
		var_dump($snoopy->results);
		return $ret;
	}


}
?>