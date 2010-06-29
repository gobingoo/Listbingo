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


class ListbingoViewTemplates extends GView {
	function display($tpl = null) {

		global $mainframe,$option;

		$client	=& JApplicationHelper::getClientInfo(JRequest::getVar('client', '0', '', 'int'));

		$model = gbimport("listbingo.model.ad");
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
			
		$filter = new stdClass ();

		$filter->limit = $mainframe->getUserStateFromRequest($option.'templateslimit', 'limit', $mainframe->getCfg('list_limit'), 'cmd');
		$filter->limitstart =  $mainframe->getUserStateFromRequest($option.'templateslimitstart', 'limitstart', JRequest::getVar('limitstart', 0), 'cmd');
		

		$filter->order = $mainframe->getUserStateFromRequest($option.'templatefilter_order', 'filter_order', 'ordering', 'cmd');
		$filter->order_dir = $mainframe->getUserStateFromRequest($option.'templatefilter_order_Dir', 'filter_order_Dir', '', 'word');

		$model = gbimport("listbingo.model.template");
		$rows = $model->getList(false, $filter);
		$total = $model->getListCount(false);
		jimport('joomla.html.pagination');

		$pagenav = new JPagination($total, $filter->limitstart, $filter->limit);


		/*$assigned = TemplatesHelper::isTemplateAssigned($row->directory);
		$default = TemplatesHelper::isTemplateDefault($row->directory, $client->id);

		if($client->id == '1')  
		{
			$lists['selections'] =  JText::_('Cannot assign an administrator template');
		} else {
			$lists['selections'] = TemplatesHelper::createMenuList($template);
		}

		if ($default) 
		{
			$row->pages = 'all';
		} 
		elseif (!$assigned) 
		{
			$row->pages = 'none';
		} 
		else 
		{
			$row->pages = null;
		}*/

		// Set FTP credentials, if given
		jimport('joomla.client.helper');
		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');


		$this->assignRef('rows', $rows);
		$this->assignRef('default',$params->get('template'));
		$this->assignRef('pagination', $pagenav);
		$this->assignRef('filter', $filter);
		$this->assignRef('client', $client);
		$this->assignRef('ftp', $ftp);
		parent::display($tpl);
			
	}

	function customDisplay()
	{
		parent::display();
	}
}
?>