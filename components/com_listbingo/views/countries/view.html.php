<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from GOBINGOO.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

gbimport("gobingoo.template");

/**
 * HTML View class for the listBingo component
 */
class ListbingoViewCountries extends GTemplate
{
	function display($tpl = null)
	{

		global $option, $listitemid;

		$mainframe=JFactory::getApplication();

		$mainframe->setUserState($option.'country',0);
		$mainframe->setUserState($option.'region',0);

		$configmodel=gbimport("listbingo.model.configuration");
		$countrymodel=gbimport("listbingo.model.country");
		$regionsmodel=gbimport("listbingo.model.region");

		$params=$configmodel->getParams();

		$params->set('force_country_selection',1);

		$country=$countrymodel->getCurrentCountry($params);
		$region=$regionsmodel->getCurrentRegion($params);



		$filter = new stdClass ();
		$filter->order="title";
		$filter->order_dir="asc";
		$filter->limitstart=0;
		$filter->limit=0;

		$countries=$countrymodel->getCountryLists(true,$filter);

		if(!count($countries))
		{
			$link=JRoute::_("index.php?option=$option&task=regions&Itemid=$listitemid&time=".time());
			GApplication::redirect($link);
		}

		$this->assignRef('countries',$countries);
		$this->assignRef('params',$params);

		parent::display($tpl);

	}

}
?>