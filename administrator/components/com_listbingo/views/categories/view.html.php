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
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// Import Joomla! libraries
gbimport ( "gobingoo.view" );

class ListbingoViewCategories extends GView {
	function display($tpl = null) {
		
		global $mainframe, $option;
		$filter = new stdClass ();
		
		$filter->limit = $mainframe->getUserStateFromRequest ( $option . 'categorylimit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'cmd' );
		$filter->limitstart = $mainframe->getUserStateFromRequest ( $option . 'categorylimitstart', 'limitstart', JRequest::getVar ( 'limitstart', 0 ), 'cmd' );
		
		$filter->levellimit = $mainframe->getUserStateFromRequest ( $option . 'category' . 'levellimit', 'levellimit', 10, 'int' );
		
		$filter->order = $mainframe->getUserStateFromRequest ( $option . 'categoryfilter_order', 'filter_order', 'ordering', 'cmd' );
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'categoryfilter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$model = gbimport ( "listbingo.model.category" );
		$rows = $model->getList ( false, $filter );
		$total = $model->getListCount ( false );
		jimport ( 'joomla.html.pagination' );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		JFilterOutput::objectHTMLSafe ( $rows );
		JFilterOutput::objectHTMLSafe ( $filter );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagenav );
		$this->assignRef ( 'filter', $filter );
		parent::display ( $tpl );
	
	}
}
?>