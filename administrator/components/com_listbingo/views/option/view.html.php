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
class ListbingoViewOption extends GView {
	function display($tpl = null) {
		
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$model = gbimport ( "listbingo.model.option" );
		$cmodel = gbimport ( "listbingo.model.field" );
		
		$row = $model->load ( $id );
		
		$edit = false;
		if ($id) {
			$edit = true;
		}

		
		$lists = array ();
		$fields = $cmodel->getListForSelect2 ( true );
		
		$lists ['fields'] = JHTML::_ ( 'select.genericlist', $fields, 'field_id', 'class="inputbox"', 'value', 'text', $row->field_id );
		$lists ['published'] = JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published );
		
		JFilterOutput::objectHTMLSafe ( $row );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( "row", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( "lists", $lists );
		
		parent::display ( $tpl );
	}
}
?>