<?php
/**
 * Joomla! 1.5 component listbingo
 *
 * @version $Id: view.html.php 2009-10-13 00:39:06 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage package
 * @license GNU/GPL
 *
 * Listbingo from gobingoo.com
 *
 * Code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class PmsViewPms extends GAddonsView
{
	function display($tpl = null)
	{
		global $mainframe,$option, $listitemid;

		$user = JFactory::getUser();
		$configmodel = gbimport("listbingo.model.configuration");
		$params = $configmodel->getParams();

		if($user->guest)
		{
			$returnurl = base64_encode(JRoute::_("index.php?option=$option&task=addons.pms.my&Itemid=$listitemid&time=".time(),false));

			$link = JRoute::_("index.php?option=com_user&view=login&Itemid=$listitemid&return=$returnurl&time=".time(),false);
			$msg = JText::_("LOGIN_TO_VIEW_YOUR_PMS");
			GApplication::redirect($link,$msg,"error");
		}
		$filter = new stdClass ();

		$filter->limit = JRequest::getVar('limit', $mainframe->getCfg('list_limit'));
		$filter->limitstart = JRequest::getVar('limitstart', 0);

		$model = gbaddons("pms.model.pm");
		$rows = $model->getMyPms($user->get('id'),$filter);

		$total = $model->getListsCount();
		jimport('joomla.html.pagination');

		$pagenav = new JPagination($total, $filter->limitstart, $filter->limit);
		
		$this->assignRef('rows',$rows);
		$this->assignRef('pagination', $pagenav);
		$this->assignRef('filter', $filter);
		$this->assignRef('user', $user);
		$this->assignRef('params', $params);
		
		parent::display($tpl);
			
	}
}
?>