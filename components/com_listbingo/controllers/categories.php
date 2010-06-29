<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: categories.php 2010-01-10 00:57:37 svn $
 * @author gobingoo.com
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * @code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.controller");

class ListbingoControllerCategories extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);


	}

	function display()
	{

		JRequest::setVar('view', 'categories');
		$this->item_type = 'Default';

		parent::display();
	}



	function select()
	{

		global $mainframe,$option,$listitemid;

		$catid=JRequest::getInt('catid',0);


		$categorymodel=gbimport("listbingo.model.category");
		$category=$categorymodel->getSlug($catid);

		$mainframe=&JFactory::getApplication();
		$wherewasi=$mainframe->getUserState("hereiam");
			

		if(empty($wherewasi))
		{			
			$wherewasi=base64_encode("index.php?option=$option&task=ads&catid=$category&Itemid=$listitemid");
		}

		$newurl=base64_decode($wherewasi);
	


		
		$uri=JFactory::getURI($newurl);
		$xuri=clone($uri);
		$xuri->parse($newurl);
		
		$xuri->setVar('catid',$category);
		$xuri->setVar('Itemid',$listitemid);
		$xuri->setVar('time',time());

		$query=urldecode($xuri->getQuery());

		$redirurl= JRoute::_("index.php?".$query,false);


	GApplication::redirect($redirurl);

	}

	function loadef()
	{	
		$cid=(int)JRequest::getVar('cid',0);
		$ad_id=(int)JRequest::getVar('adid',0);
		$catmodel=gbimport("listbingo.model.category");
		$fields=$catmodel->getExtrafields($cid,$ad_id);
		$view=$this->getView('ajaxinput');
		$view->assignRef('extrafields',$fields);
		$view->display();
	}


}
?>