<?php
/**
 * Persistent Search Queue
 * @author sanjeev
 *
 */

class SearchQueue
{

	var $_searchqueue=array();

	var $_current=null;



	function addToQueue($item=0)
	{
		$this->_searchqueue[]=$item;

	}

	function addMultiple($array=array())
	{
		$this->_searchqueue=$array;
	}

	function loadFromObjects($array=array())
	{
		if(count($array)>0)
		{
			foreach($array as $a)
			{
				self::addToQueue($a->id);
			}
		}
	}
	function getNext()
	{
		if(count($this->_searchqueue)>0)
		{
			if($this->_current<(count($this->_searchqueue)-1))
			{
				return $this->_searchqueue[$this->_current+1];
			}
		}
		return false;
	}

	function getPrevious()
	{
		if(count($this->_searchqueue)>0)
		{

			if($this->_current>0)
			{
				return $this->_searchqueue[$this->_current-1];
			}
		}
		return false;

	}

	function reset()
	{
		$this->_searchqueue=array();

	}

	function load()
	{
		$session=JFactory::getSession();
		if($session->has('searchqueue'))
		{
			$this->_searchqueue=$session->get('searchqueue');
		}
		else
		{
			$this->_searchqueue=array();
		}

	}

	function save()
	{
		$session=JFactory::getSession();

		$session->set('searchqueue',$this->_searchqueue);

	}

	function setCurrent($id=0)
	{
		if(count($this->_searchqueue)>0)
		{
			foreach($this->_searchqueue as $key=>$s)
			{
				if($s==$id)
				{
					$this->_current=$key;
					break;
				}
			}
		}
	}

}
?>