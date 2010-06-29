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
class ListbingoViewCountries extends GView {
	function display($tpl = null) {
		global $mainframe, $option;
		$filter = new stdClass ();
		
		$search = $mainframe->getUserStateFromRequest ( $option . '.filterkeyword', 'keyword', '', 'string' );
		$search = JString::strtolower ( $search );
		$filter->keyword = $search;
		$filter->published = JRequest::getVar ( 'published', '' );
		$filter->limit = $mainframe->getUserStateFromRequest ( $option . 'countrieslimit', 'limit', $mainframe->getCfg ( 'list_limit' ), 'cmd' );
		$filter->limitstart = $mainframe->getUserStateFromRequest ( $option . 'countrieslimitstart', 'limitstart', JRequest::getVar ( 'limitstart', 0 ), 'cmd' );
		
		$filter->order = $mainframe->getUserStateFromRequest ( $option . 'countriesfilter_order', 'filter_order', 'ordering', 'cmd' );
		$filter->order_dir = $mainframe->getUserStateFromRequest ( $option . 'countriesfilter_order_Dir', 'filter_order_Dir', '', 'word' );
		
		$model = gbimport ( "listbingo.model.country" );
		$rows = $model->getList ( false, $filter );
		$total = $model->getListCount ( false );
		jimport ( 'joomla.html.pagination' );
		
		$pagenav = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		$lists = array ();
		$status = array ();
		$status [] = JHTML::_ ( 'select.option', '', JText::_ ( 'ALL' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '1', JText::_ ( 'PUBLISHED' ), 'id', 'title' );
		$status [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'UNPUBLISHED' ), 'id', 'title' );
		$lists ['published'] = JHTML::_ ( 'select.genericlist', $status, 'published', 'class="inputbox"', 'id', 'title', JRequest::getVar ( 'published', '' ) );
		
		JFilterOutput::objectHTMLSafe ( $rows );
		JFilterOutput::objectHTMLSafe ( $filter );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( 'rows', $rows );
		$this->assignRef ( 'pagination', $pagenav );
		$this->assignRef ( 'filter', $filter );
		$this->assignRef ( 'lists', $lists );
		parent::display ( $tpl );
	
	}
}
?>