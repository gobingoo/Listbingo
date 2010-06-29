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

class ListbingoViewRegions extends GView {
	function display($tpl = null) {
		global $mainframe, $option;
		$filter = new stdClass ();
		
		$search = $mainframe->getUserStateFromRequest ( $option . '.filterkeyword', 'keyword', '', 'string' );
		$search = JString::strtolower ( $search );
		$filter->keyword = $search;
		$filter->published = JRequest::getVar ( 'published', '' );
		$filter->limit = $mainframe->getUserStateFromRequest ( $option . 'regionslimit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'cmd' );
		$filter->limitstart = $mainframe->getUserStateFromRequest ( $option . 'regionslimitstart', 'limitstart', JRequest::getVar ( 'limitstart', 0 ), 'cmd' );
		;
		
		$filter->order = $mainframe->getUserStateFromRequest ( $option . 'region_filter_order', 'filter_order', 'c.ordering', 'cmd' );
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'region_filter_order_Dir', 'filter_order_Dir', '', 'word' );
		$filter->levellimit = $mainframe->getUserStateFromRequest ( $option . 'region_levellimit', 'levellimit', 10, 'int' );
		$model = gbimport ( "listbingo.model.region" );
		
		$rows = $model->getList ( false, $filter );
		$total = $model->getListCount ( false );
		jimport ( 'joomla.html.pagination' );
		
		$lists = array ();
		$status = array ();
		$status [] = JHTML::_ ( 'select.option', '', JText::_ ( 'ALL' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
		$lists ['published'] = JHTML::_ ( 'select.genericlist', $status, 'published', 'class="inputbox"', 'id', 'title', JRequest::getVar ( 'published', '' ) );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		JFilterOutput::objectHTMLSafe ( $rows );
		JFilterOutput::objectHTMLSafe ( $lists );
		JFilterOutput::objectHTMLSafe ( $pagenav );
		JFilterOutput::objectHTMLSafe ( $filter );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagenav );
		$this->assignRef ( 'filter', $filter );
		$this->assignRef ( 'lists', $lists );
		parent::display ( $tpl );
	
	}
}
?>