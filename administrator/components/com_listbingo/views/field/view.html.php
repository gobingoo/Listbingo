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
class ListbingoViewField extends GView {
	function display($tpl = null) {
		
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$model = gbimport ( "listbingo.model.field" );
		$cmodel = gbimport ( "listbingo.model.category" );
		$row = $model->load ( $id );
		
		$filter = new stdClass ();
		$filter->id = 0;
		$filter->parent_id = 0;
		$categories = $cmodel->getTreeForSelect ( true, $filter );
		
		$catforselect = array ();
		
		if (count ( $categories ) > 0) {
			foreach ( $categories as $xc ) {
				
				$catforselect [] = JHTML::_ ( 'select.option', $xc->value, JText::_ ( $xc->treename ), 'value', 'text' );
			}
		
		}
		
		$edit = false;
		if ($id) {
			$edit = true;
		}
		
		$lists = array ();
		$ftype [] = JHTML::_ ( 'select.option', 'text', JText::_ ( 'Text' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'textarea', JText::_ ( 'TextArea' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'select', JText::_ ( 'Select' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'radio', JText::_ ( 'Radio' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'checkbox', JText::_ ( 'Checkbox' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'date', JText::_ ( 'Date' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'country', JText::_ ( 'Country' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'email', JText::_ ( 'Email' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'url', JText::_ ( 'Url' ), 'value', 'text' );
		$ftype [] = JHTML::_ ( 'select.option', 'attachment', JText::_ ( 'Attachment' ), 'value', 'text' );
		
		$lists ['types'] = JHTML::_ ( 'select.genericlist', $ftype, 'type', 'class="inputbox" size="1"', 'value', 'text', $row->type );
		
		$lists ['categories'] = JHTML::_ ( 'select.genericlist', $catforselect, 'categories[]', 'class="inputbox" style="width:200px;" size="20" multiple="multiple"', 'value', 'text', $row->categories );
		$lists ['published'] = JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published );
		
		$lists ['required'] = JHTML::_ ( 'select.booleanlist', 'required', 'class="inputbox"', $row->required );
		$lists ['infobar'] = JHTML::_ ( 'select.booleanlist', 'infobar', 'class="inputbox"', $row->infobar );
		$lists ['image_list'] = JHTML::_ ( 'list.images', 'icon', 'class="inputbox"', $row->icon );
		$lists ['access'] = JHTML::_ ( 'list.accesslevel', $row );
		
		$lists ['hidecaption'] = JHTML::_ ( 'select.booleanlist', 'hidecaption', 'class="inputbox"', $row->hidecaption );
		
		$lists ['view_in_summary'] = JHTML::_ ( 'select.booleanlist', 'view_in_summary', 'class="inputbox"', $row->view_in_summary );
		
		$lists ['view_in_detail'] = JHTML::_ ( 'select.booleanlist', 'view_in_detail', 'class="inputbox"', $row->view_in_detail );
		
		JFilterOutput::objectHTMLSafe ( $row );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( "row", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( "lists", $lists );
		
		parent::display ( $tpl );
	}
}
?>