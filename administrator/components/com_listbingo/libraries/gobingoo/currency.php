<?php
/**
 *
 * Currency class for gobingoo projects
 * @author Alex@gobingoo.com
 * @date 12 Jan 2010
 *
 */

defined('_JEXEC') or die('Restricted access');


class GCurrency
{

	var $_symbol=null;
	var $_value=null;

	var $_currency=null;

	var $_decimal_separator=null;

	var $_decimals=null;

	var $_val_separator=null;

	var $_format=null;

	function __construct($val=0,$symbol='$',$currency='USD',$format="%S %V %C",$decimal="2",$dec=".",$v=",")
	{
		$this->_symbol=empty($symbol)?'$':$symbol;
		$this->_currency=empty($currency)?"USD":$currency;
		$this->_value=$val;
		$this->_decimal_separator=empty($dec)?".":$dec;
		$this->_decimals=empty($decimal)?"2":$decimal;
		$this->_val_separator=empty($val)?",":$v;
		$this->_format=empty($format)?"%S %V %C":$format;

	}


	function setCurrencySymbol($symbol='$')
	{
		$this->_symbol=$symbol;

	}
	function setDecimals($dec="2")
	{
		$this->_decimals=$dec;

	}

	function setCurrency($currency="USD")
	{
		$this->_currency=$currency;

	}

	function setValue($val=0,$symbol='$',$currency='USD')
	{
		$this->_symbol=empty($symbol)?'$':$symbol;
		$this->_currency=empty($currency)?"USD":$currency;
		$this->_value=$val;
	}

	function setDecimalSeparator($dec=".")
	{
		$this->_decimal_separator=$dec;

	}

	function setValueSeparator($val=",")
	{
		$this->_val_separator=$val;
	}

	function setFormat($format="%S %V %C")
	{
		$this->_format=$format;
	}

	function set($val=0,$symbol='$',$currency='USD',$format="%S %V %C",$decimal="2",$dec=".",$v=",")
	{
		$this->_symbol=empty($symbol)?'$':$symbol;
		$this->_currency=empty($currency)?"USD":$currency;
		$this->_value=$val;
		$this->_decimal_separator=empty($dec)?".":$dec;
		$this->_decimals=empty($decimal)?"2":$decimal;
		$this->_val_separator=empty($val)?",":$v;
		$this->_format=empty($format)?"%S %V %C":$format;

	}
	
	function setParameters($format="%S %V %C",$decimal="2",$dec=".",$v=",")
	{
		$this->_decimal_separator=empty($dec)?".":$dec;
		$this->_decimals=empty($decimal)?"2":$decimal;
		$this->_val_separator=empty($val)?",":$v;
		$this->_format=empty($format)?"%S %V %C":$format;
	}
	
	

	
	

	function toString()
	{

		$pattern=array();
		$pattern[]='/%S/i';
		$pattern[]='/%V/i';
		$pattern[]='/%C/i';

		$value=array();
		$value[]=$this->_symbol;
		$value[]=number_format($this->_value,$this->_decimals,$this->_decimal_separator,$this->_val_separator);
		$value[]=$this->_currency;		
		return preg_replace($pattern,$value,$this->_format);

	}


}
?>