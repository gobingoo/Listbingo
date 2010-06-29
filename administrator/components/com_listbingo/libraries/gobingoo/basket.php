<?php
/**
 * Basket Class for Listbingo
 *
 * @author Alex
 *
 * @package Listbingo
 * @subpackage basket
 * @code Alex
 *

 */


class GBasket
{

	var $_iterator=null;

	//Array to hold Instant Payment Notifications Receivers
	var $IPRs=array();

	var $currency=null;

	var $currencysymbol=null;
	
	var $refid=null;


	function __construct()
	{
		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('basket',$option))
		{
			$session->set('basket',array(),$option);
		}

	}


	function reset()
	{
		global $option;
		$session=&JFactory::getSession();
		if($session->has('basket',$option))
		{
			$session->set('basket',array(),$option);
		}


	}
	function &getInstance($namespace='default')
	{
		static $instances;

		if (!isset ($instances)) {
			$instances = array ();
		}

		if (empty($instances[$namespace])) {
			$basket = new GBasket();
			$instances[$namespace] = $basket;
		}

		return $instances[$namespace];
	}

	function &getBasket()
	{

		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('basket',$option))
		{
			$session->set('basket',array(),$option);
		}
		return $session->get('basket',array(),$option);
	}
	
	function &getIPRs()
	{

		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('IPRs',$option))
		{
			$session->set('IPRs',array(),$option);
		}
		return $session->get('IPRs',array(),$option);
	}
	

	function getItems()
	{
		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('basket',$option))
		{
			$session->set('basket',array(),$option);
		}
		return $session->get('basket',array(),$option);
	}

	function addToBasket($item=null)
	{

		global $option;
		$basket=self::getBasket();
		$basket[]=$item;

		$session=&JFactory::getSession();
		$session->set('basket',$basket,$option);
		$session->set('currency',$item->currency,$option);
		$session->set('currencysymbol',$item->currencysymbol,$option);

	}

	function getNextItem()
	{
		$items=self::getBasket();
		$total=count($items);

		if($this->_iterator<$total)
		{

			return $items[$this->_iterator++];
		}
		else
		{
			return false;
		}



	}

	function getPreviousItem()
	{
		$items=self::getBasket();
		$total=count($items);



		if($this->_iterator>0)
		{

			return $items[--$this->_iterator];
		}
		else
		{
			return false;
		}
	}

	function rewind()
	{
		$this->_iterator=0;
	}

	function calculateTotal()
	{
		$total=0;
		self::rewind();
		while($item=self::getNextItem())
		{
			$total+=$item->price;
		}
		return $total;
	}

	function registerIPR($url="")
	{
		if(!empty($url))
		{
			global $option;
			$IPRs=self::getIPRs();
			$IPRs[]=$url;

			$session=&JFactory::getSession();
			$session->set('IPRs',$IPRs,$option);
			
		}
	}

	

	function setCurrency($currency,$currencysymbol)
	{
		$this->currency=$currency;
		$this->currencysymbol=$currencysymbol;

	}

	function getCurrency()
	{

		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('currency',$option))
		{
			$session->set('currency','USD',$option);
		}
		return $session->get('currency','USD',$option);
	}

	function getCurrencySymbol()
	{

		global $option;
		$session=&JFactory::getSession();
		if(!$session->has('currencysymbol',$option))
		{
			$session->set('currencysymbol','$',$option);
		}
		return $session->get('currencysymbol','$',$option);
	}




}


?>