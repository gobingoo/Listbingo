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

class ListbingoViewRegion extends GView {
	function display($tpl = null) {
		
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$model = gbimport ( "listbingo.model.region" );
		$cmodel = gbimport ( "listbingo.model.country" );
		
		$row = $model->load ( $id );
		$edit = false;
		if ($id) {
			$edit = true;
		}
		
		$lists = array ();
		$parent1 = array ();
		$parent1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Root' ), 'value', 'text' );
		$parent2 = $model->getListForSelect ( true, $id );
		$parents = array_merge ( $parent1, $parent2 );
		
		$lists ['parent'] = JHTML::_ ( 'select.genericlist', $parents, 'parent_id', 'class="inputbox" size="1"', 'value', 'text', $row->parent_id );
		
		$countries1 = array ();
		$countries1 [] = JHTML::_ ( 'select.option', '0', JText::_ ( 'Select Country' ), 'value', 'text' );
		
		$countries2 = $cmodel->getListForSelect ( true );
		$countries = array_merge ( $countries1, $countries2 );
		$lists ['countries'] = JHTML::_ ( 'select.genericlist', $countries, 'country_id', 'class="inputbox" size="1"', 'value', 'text', $row->country_id );
		
		$lists ['published'] = JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published );
		$lists ['default_region'] = JHTML::_ ( 'select.booleanlist', 'default_region', 'class="inputbox"', $row->default_region );
		
		JFilterOutput::objectHTMLSafe ( $row );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( "row", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( "lists", $lists );
		
		parent::display ( $tpl );
	}
	
	function customDisplay($tpl = null) {
		parent::display ( $tpl );
	
	}
}
?>