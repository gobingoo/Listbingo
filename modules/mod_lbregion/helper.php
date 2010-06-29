<?php
/**
 * @version		$Id: helper.php
 */

// no direct access
defined('_JEXEC') or die('Restricted access');


jimport('joomla.base.tree');

jimport('joomla.utilities.simplexml');

/**
 * mod_lbregion Helper class
 *
 * @static
 * @package		Joomla
 * @since		1.5
 */
class modLbRegionHelper
{

	function getCountryRegion($params)
	{
		$mainframe=JFactory::getApplication();
		$option="com_listbingo";

		$db=JFactory::getDBO();

		$country_id = $mainframe->getUserState($option.'country',0);
		$region_id = $mainframe->getUserState($option.'region',0);
		$region = array();

		$query="SELECT id,title from #__gbl_countries where id=$country_id";
		$db->setQuery($query);

		$result = $db->loadObject();

		if(count($result)>0)
		{
			$region[0] = $result;
		}
		else
		{
			$region[0] = NULL;
		}


		$query="SELECT id,title from #__gbl_regions where id=$region_id AND country_id=$country_id";

		$db->setQuery($query);

		$result1 = $db->loadObject();
		if(count($result1)>0)
		{
			$region[1] = $result1;
		}
		else
		{
			$region[1] = NULL;
		}

		return $region;
	}

}
