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
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.view");
class ListbingoViewAddons extends GView {
	function display($tpl = null) {
		global $mainframe,$option;
		$filter = new stdClass ();

		$filter->limit = $mainframe->getUserStateFromRequest($option.'addonslimit', 'limit', $mainframe->getCfg('list_limit'), 'cmd');
		$filter->limitstart =  $mainframe->getUserStateFromRequest($option.'addonslimitstart', 'limitstart', JRequest::getVar('limitstart', 0), 'cmd');


		$filter->order = $mainframe->getUserStateFromRequest($option.'addonsfilter_order', 'filter_order', 'ordering', 'cmd');
		$filter->order_dir = $mainframe->getUserStateFromRequest($option.'addonsfilter_order_Dir', 'filter_order_Dir', '', 'word');

		$model = gbimport("listbingo.model.addon");
		$rows = $model->getList(false, $filter);
		$total = $model->getListCount(false);
		jimport('joomla.html.pagination');

		$pagenav = new JPagination($total, $filter->limitstart, $filter->limit);
		$this->assignRef('rows', $rows);
		$this->assignRef('pagination', $pagenav);
		$this->assignRef('filter', $filter);
		parent::display($tpl);
			
	}
}
?>