<?php
/**
 * Joomla! 1.5 component estatebingo
 *
 * @version $Id: view.html.php 2009-10-13 00:39:06 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage feedbingo
 * @license GNU/GPL
 *
 * Estatebingo from gobingoo.com
 *
 * Code Alex
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// Import Joomla! libraries
gbimport ( "gobingoo.addonsview" );
class PmsViewPms extends GAddonsView {
	function display($tpl = null) {
		global $mainframe, $option;
		$filter = new stdClass ();
		
		$filter->limit = JRequest::getVar ( 'limit', $mainframe->getCfg ( 'list_limit' ) );
		$filter->limitstart = JRequest::getVar ( 'limitstart', 0 );
		
		$filter->order = $mainframe->getUserStateFromRequest ( $option . 'pmsfilter_order', 'filter_order', 'm.id', 'cmd' );
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'pmsfilter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$model = gbaddons ( "pms.model.pm" );
		$rows = $model->getLists ( $filter );
		//var_dump($rows);exit;
		

		$total = $model->getListsCount ();
		jimport ( 'joomla.html.pagination' );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		JFilterOutput::objectHTMLSafe ( $rows );
		JFilterOutput::objectHTMLSafe ( $filter );
		JFilterOutput::objectHTMLSafe ( $pagenav );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagenav );
		$this->assignRef ( 'filter', $filter );
		parent::display ( $tpl );
	
	}
}
?>