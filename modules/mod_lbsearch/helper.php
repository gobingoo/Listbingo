<?php


// no direct access
defined('_JEXEC') or die('Restricted access');

class modLbCategoriesHelper
{
	function getCategories(&$params)
	{
		$db=JFactory::getDBO();

		/*$pubcond = "";
		if ($published) {
			$pubcond = " AND c.published='1'";
		}*/

		$orderby = ' ORDER BY c.parent_id asc,c.ordering';
		$catid = JRequest::getInt('catid',0);
		$db = JFactory::getDBO();
		/*if($catid)
		{
			$query = "SELECT c.*,c.title as name,c.parent_id as parent,
			(SELECT count(*) FROM #__gbl_ads WHERE category_id=$catid) as pcount
			FROM #__gbl_categories as c WHERE id=$catid
			$pubcond $orderby";
		}
		else
		{
			$query = "SELECT c.*,c.title as name,c.parent_id as parent, 0 as pcount FROM #__gbl_categories as c WHERE parent_id=0 $pubcond $orderby";

		}*/

		$query = "SELECT c.*,c.title as name,c.parent_id as parent, 0 as pcount FROM #__gbl_categories as c WHERE parent_id=0 AND c.published='1' $orderby";
		

		$db->setQuery($query);
		$rows= $db->loadObjectList();

		if(count($rows)>0)
		{
			$n=count($rows);
			for($i=0;$i<$n;$i++)
			{
				$r=$rows[$i];
				$query2="SELECT * FROM #__gbl_categories WHERE parent_id='".$r->id."'";
				$db->setQuery($query2);
				$r->child=$db->loadObjectList();

				/*if($filter->catid)
				{
					$r->adcat = self::_getChildrens($filter->catid);
				}
				else
				{

					$r->adcat =  self::_getChildrens($r->id);
				}


				if(count($r->child)>0)
				{
					$m=count($r->child);

					for($j=0;$j<$m;$j++)
					{
						$a=$r->child[$j];
						$a->adcat2 =  self::_getChildrens($a->id);
					}
				}
*/
			}

		}
		return $rows;

	}

	function _getChildrens($cid)
	{
		$childrens=array();
		$childrens[]=$cid;
		if($cid==0)
		{
			return false;
		}
		$db=JFactory::getDBO();
		$query="SELECT id from #__gbl_categories where parent_id=$cid";
		$db->setQuery($query);
		$rows=$db->loadResultArray();
		if(count($rows)>0)
		{
			foreach($rows as &$r)
			{
				$childrens[]=$r;
				$childrens=array_merge($childrens,self::_getChildrens($r));
					
			}
		}

		return $childrens;

	}

	function _countTotalProducts($filter)
	{

		$locationcond = array();

		/*if($filter->country)
		 {
			$locationcond[] = "a.country_id=".$filter->country;
			}

			if($filter->region)
			{
			$locationcond[] = "a.region_id=".$filter->region;
			}*/

		$country = self::getCurrentCountry();
		$region = self::getCurrentRegion();

		if($country)
		{
			$locationcond[] = "a.country_id=".$country;
		}

		if($region)
		{
			$locationcond[] = "a.region_id=".$region;
		}

		$where= " WHERE ".implode(" AND ",$locationcond);

		$db=JFactory::getDBO();
		//$query = "SELECT cats.title AS ctitle, cats.id AS cid, SUM(COALESCE(ads.howmany,0)) AS adCount FROM (SELECT title, id FROM #__gbl_categories) AS cats LEFT JOIN ( SELECT count(a.id) as howmany, a.category_id as category_id FROM jos_gbl_ads as a LEFT JOIN #__gbl_categories as c ON a.category_id = c.id GROUP BY a.category_id) AS ads ON cats.id=ads.category_id";
		$query = "SELECT cats.id AS id, COALESCE(prods.howmany,0) AS adCount
		FROM (SELECT title, id FROM #__gbl_categories) AS cats 
		LEFT JOIN ( SELECT count(a.id) as howmany, a.category_id as category_id FROM #__gbl_ads as a 
		LEFT JOIN #__gbl_categories as c ON a.category_id = c.id $where GROUP BY a.category_id) AS prods ON cats.id=prods.category_id";
		$db->setQuery($query);
		return $db->loadObjectList();

	}

	function getCurrentCountry()
	{
		global $option;

		$mainframe=JFactory::getApplication();
		$params = self::getConfiguration();

		$countrystate=$mainframe->getUserState($option.'country');

		if($params->get('country_selection')==1)
		{
			if($countrystate)
			{
				return $countrystate;
			}
			else
			{
				return false;
			}
		}
		else
		{
			$db=JFactory::getDBO();
			$query="SELECT * from #__gbl_countries where default_country='1'";
			$db->setQuery($query);
			$obj=$db->loadObject();
			if($obj)
			{
				$mainframe->setUserState($option.'countrytitle',$obj->title);

				return $obj->id;
			}
			else
			{
				return false;
			}

		}

	}

	function getCurrentRegion()
	{

		global $option;
		
		$mainframe=&JFactory::getApplication();
		$params = self::getConfiguration();
		$regionstate=$mainframe->getUserState($option.'region');


		if($regionstate)
		{

			return $regionstate;
		}

		if($params->get('region_selection')==1)
		{
			if($regionstate)
			{

				return $regionstate;
			}
			else
			{

				return false;
			}
		}
		else
		{

			$db=JFactory::getDBO();
			$query="SELECT * from #__gbl_regions where default_region='1'";
			$db->setQuery($query);
			$obj=$db->loadObject();

			if($obj)
			{

				$mainframe->setUserState($option.'region',$obj->id);
				return $obj->id;
			}
			else
			{
				return false;
			}

		}

	}

	function getConfiguration()
	{

		jimport( 'joomla.filesystem.file');
		$ini	= JPATH_ROOT . DS . 'administrator' . DS . 'components' . DS . "com_listbingo" . DS . 'default.ini';
		$data	= JFile::read($ini);

		// Load default configuration
		$xparams	= new JParameter( $data );

		$config =& JTable::getInstance('component');
		$config->loadByOption( "com_listbingo" );


		// Bind the user saved configuration.
		$xparams->bind( $config->params );
		return $xparams;
	}


}
