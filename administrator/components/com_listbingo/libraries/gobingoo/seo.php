<?php
/**
 * 
 * @author alex
 *
 */

class GSeo
{


	function setDescription($description)
	{
		if(!empty($description))
		{
			$document=JFactory::getDocument();
			$document->setMetaData('description',$description);
		}

	}

	function addKeywords($keywords)
	{
		if(!empty($keywords))
		{
			$document=JFactory::getDocument();

			$document->setMetaData('keywords',$keywords);
		}
	}

	function setTitle($title)
	{
		if(!empty($title))
		{
			$document=JFactory::getDocument();
			$document->setTitle($title);
		}
	}


}
?>