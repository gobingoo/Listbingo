<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
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

gbimport("gobingoo.template");

/**
 * HTML View class for the Listbingo component
 */
class ListbingoViewBreadcrumb extends GTemplate {
	function display($tpl = null) {
		global $mainframe,$option;
		//Import required libararies

		$configmodel=gbimport("listbingo.model.configuration");
		$model = gbimport("listbingo.model.ad");
		$catmodel = gbimport("listbingo.model.category");
			
		$id=JRequest::getInt('adid',0);
		if($id)
		{
			$row=$model->loadWithFields($id,true);
			$catid = $row->category_id;
		}
		else
		{
			$catid = JRequest::getInt('catid',0);
		}
		
		
		$params=$configmodel->getParams();

		$nav = array();
		
		$nav['country'] = $mainframe->getUserState('country');
		$nav['region'] = $mainframe->getUserState('region');
		
		$location = array();

		$location[]= $mainframe->getUserState($option.'countrytitle');
		$location[]= $mainframe->getUserState($option.'regiontitle');
		$loc = implode(" >> ",$location);

		$parentcat = array_reverse($catmodel->_getParents($catid));
		$this->assignRef('loc', $loc);
		$this->assignRef('parentcat', $parentcat);
		$this->assignRef('nav', $nav);
		$this->assignRef('params',$params);
		parent::display($tpl);
	}
	
	/*function display($tpl = null) {
		global $mainframe,$option;
		//Import required libararies

		$configmodel=gbimport("listbingo.model.configuration");
		$model = gbimport("listbingo.model.ad");
		$catmodel = gbimport("listbingo.model.category");
			
		$id=JRequest::getInt('adid',0);
		if($id)
		{
			$row=$model->loadWithFields($id,true);
			$catid = $row->category_id;
		}
		else
		{
			$catid = JRequest::getInt('catid',0);
		}


		$params=$configmodel->getParams();

		$nav = array();

		echo "coun=".$nav['country'] = $mainframe->getUserState('country');
		echo "reg=".$nav['region'] = $mainframe->getUserState('region');

		$location = array();

		if($nav['country']>0)
		{
			$location[]= $mainframe->getUserState($option.'countrytitle');
		}

		if($nav['region']>0)
		{
			$location[]= $mainframe->getUserState($option.'regiontitle');
		}

		if(count($location)>0)
		{
			$loc = implode(" >> ",$location);
		}
		else
		{
			$loc = $location[0];
		}

		$parentcat = array_reverse($catmodel->_getParents($catid));
		$this->assignRef('loc', $loc);
		$this->assignRef('parentcat', $parentcat);
		$this->assignRef('nav', $nav);
		$this->assignRef('params',$params);
		parent::display($tpl);
	}*/
}
?>