<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: regions.php 2010-01-10 00:57:37 svn $
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

class ListbingoControllerRegions extends GController
{

	function __construct($config = array())
	{
		parent::__construct($config);
	}

	function display()
	{

		
			JRequest::setVar('view', 'regions');
		
		$this->item_type = 'Default';
		parent::display();

	}



	function expand()
	{

		$rid=JRequest::getInt('rid',0);
		
		

		global $option;
		$mainframe=JFactory::getApplication();
		
		$mainframe->setUserState($option.'region',$rid);
		$filter = new stdClass ();

		$configmodel=gbimport("listbingo.model.configuration");
		$countrymodel=gbimport("listbingo.model.country");

		$params=$configmodel->getParams();
		$country=$countrymodel->getCurrentCountry($params);
		$view=$this->getView('regions','html');


		if(!$country)
		{
			$view->setLayout("countries");
			$filter->order="title";
			$filter->order_dir="asc";
			$filter->limitstart=0;
			$filter->limit=0;

			$countries=$countrymodel->getList(true,$filter);
			$view->assignRef('countries',$countries);


		}
		else
		{
			$regionsmodel=gbimport("listbingo.model.region");
			$view->setLayout("expanded");

			$regions=$regionsmodel->_getChildRegions($rid);

			$view->assignRef('regions',$regions);


		}

		$user = JFactory::getUser();
		$userid = $user->get('id');
		if($userid)
		{
			$preferences = array();

			$preferences['country']=$mainframe->getUserState($option.'country');
			$preferences['region']=$rid;

			$registry	=& JRegistry::getInstance( $option.'profile' );

			foreach( $preferences as $key => $value )
			{
				$registry->setValue( $option.'profile.' . $key , $value );
			}

			// Get the complete INI string
			$userpreferences = $registry->toString( 'INI' , $option.'profile' );

			$pmodel = gbimport('listbingo.model.profile');
			$pmodel->setUserLocation($userpreferences, $userid);
		}

		$view->assignRef('params',$params);
		$view->customDisplay();
		

	}

	function region()
	{
		global $option,$listitemid;
		$mainframe=JFactory::getApplication();
		$rid=JRequest::getInt('rid',0);
		$mainframe->setUserState($option.'region',$rid);
		
		$wherewasi=$mainframe->getUserState("hereiam");
		
		$user = JFactory::getUser();
		$userid = $user->get('id');
		
		if($userid)
		{
			$preferences = array();

			$preferences['country']=$mainframe->getUserState($option.'country');
			$preferences['region']=$rid;

			$registry	=& JRegistry::getInstance( $option.'profile' );

			foreach( $preferences as $key => $value )
			{
				$registry->setValue( $option.'profile.' . $key , $value );
			}

			// Get the complete INI string
			$userpreferences = $registry->toString( 'INI' , $option.'profile' );

			$pmodel = gbimport('listbingo.model.profile');
			$pmodel->setUserLocation($userpreferences, $userid);
		}

		if(empty($wherewasi))
		{
			$wherewasi=base64_encode(JRoute::_("index.php?option=$option&task=categories&time=".time()."&Itemid=$listitemid",false));
		}
		
		$regionmodel = gbimport('listbingo.model.region');
		$region = $regionmodel->load($rid);
		$redirlink=JRoute::_(base64_decode($wherewasi),false);
		GApplication::redirect($redirlink);

	}

	function load()
	{

		$cid=JRequest::getInt('cid',0);
		$selected=JRequest::getInt('selected',0);
		$cid=(int)$cid;

		$cmodel=gbimport("listbingo.model.region");
			
		$regions=$cmodel->getTreeForSelect(true,$cid);

		if(count($regions))
		{

			$regforselect=array();

			if(count($regions)>0)
			{
				foreach($regions as $xc)
				{

					$regforselect[]=JHTML::_('select.option', $xc->value, JText::_($xc->treename), 'value', 'text');
				}

			}

			$lists=array();
			$lists['regions'] = JHTML::_('select.genericlist',   $regforselect, 'region_id', 'class="selectinputbox required" size="1" ', 'value', 'text', $selected );
			$view=$this->getView('regions','html');
			$view->setLayout('ajaxinput');
			$view->assignRef('lists',$lists);
			$view->customDisplay();
		}
		else
		{
			//do nothing
		}

	}

	function selectRegionCountry()
	{

		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();

		$regionsmodel=gbimport("listbingo.model.region");
		$countrymodel=gbimport("listbingo.model.country");

		$countrytitle = $countrymodel->getCountryTitle($params);
		$regiontitle = $regionsmodel->getRegionTitle($params);

		$country=$countrymodel->getCurrentCountry($params);
		$region=$regionsmodel->getCurrentRegion($params);

		if($params->get('expand_directory'))
		{
			$regions=$regionsmodel->getRegionsWithChild($country);
		}
		else
		{
			$regions=$regionsmodel->getParentRegions($country);
		}

		$filter = new stdClass();

		$filter->order="title";
		$filter->order_dir="asc";
		$filter->limitstart=0;
		$filter->limit=0;

		$countries=$countrymodel->getCountryLists(true,$filter);


		$view=$this->getView('regions','html');
		$view->assignRef('countries',$countries);
		$view->assignRef('countrytitle',$countrytitle);
		$view->assignRef('regiontitle',$regiontitle);
		$view->assignRef('regions',$regions);
		$view->assignRef('params',$params);
		$view->setLayout('regioncountry');

		$view->customDisplay();
	}
}
?>