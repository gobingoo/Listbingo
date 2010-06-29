<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: adimage.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.model");

class ListbingoModelAdimage extends GModel {

	function __construct() {
		parent::__construct();
	}


	function remove($cid=array(), $userid)
	{
		$db=JFactory::getDBO();

		if(count($cid))
		{
			$cids=implode(',',$cid);
			$query = "SELECT *,a.id as aid FROM #__gbl_ads_images as i
			INNER JOIN #__gbl_ads as a ON (a.id=i.ad_id AND a.user_id=$userid)
			WHERE i.id IN ($cids)";
			
			$db->setQuery($query);
			$images = &$db->loadObjectList();

			$configmodel = gbimport("listbingo.model.configuration");
			$params = $configmodel->getParams();

			$smallsfx = $params->get('suffix_thumbnail_sml');
			$midsfx = $params->get('suffix_thumbnail_mid');
			$largesfx = $params->get('suffix_thumbnail_lrg');



			$query="DELETE from #__gbl_ads_images where id in ($cids)";
			$db->setQuery($query);
			if(!$db->query())
			{
				throw new DataException(JText::_("NO_DELETE"),400);
			}
			foreach($images as $i)
			{
				unlink(JPATH_ROOT.$i->image.$smallsfx.".".$i->extension);
				unlink(JPATH_ROOT.$i->image.$midsfx.".".$i->extension);
				unlink(JPATH_ROOT.$i->image.$largesfx.".".$i->extension);
			}

			return true;
		}
	}

}
?>