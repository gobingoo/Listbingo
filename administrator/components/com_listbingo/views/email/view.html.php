<?php
/**
 * Joomla! 1.5 component Listbingo
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

// Import Joomla! libraries
gbimport ( "gobingoo.view" );

class ListbingoViewEmail extends GView {
	function display($tpl = null) {
		$cid = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		JArrayHelper::toInteger ( $cid, array (0 ) );
		$id = JRequest::getVar ( 'id', $cid [0], '', 'int' );
		
		$events = ListbingoHelper::getEventsList ();
		
		$model = gbimport ( "listbingo.model.email" );
		
		$row = $model->load ( $id );
		$edit = false;
		if ($id) {
			$edit = true;
		}
		
		$lists = array ();
		
		$events = ListbingoHelper::getEventsList ();
		
		$eventsarray = array ();
		$mailto = array ();
		if (count ( $events ) > 0) {
			foreach ( $events as $key => $evt ) {
				$eventsarray [] = JHTML::_ ( 'select.option', $key, JText::_ ( $evt ), 'id', 'title' );
			}
		}
		
		$mailto [] = JHTML::_ ( 'select.option', 0, JText::_ ( 'ADMINISTRATOR' ), 'id', 'title' );
		$mailto [] = JHTML::_ ( 'select.option', 1, JText::_ ( 'RECEIVER' ), 'id', 'title' );
		$mailto [] = JHTML::_ ( 'select.option', 2, JText::_ ( 'MAIL_SENDER' ), 'id', 'title' );
		
		$lists ['events'] = JHTML::_ ( 'select.genericlist', $eventsarray, 'event', 'class="inputbox"', 'id', 'title', $row->event );
		$lists ['published'] = JHTML::_ ( 'select.booleanlist', 'published', 'class="inputbox"', $row->published );
		$lists ['mailto'] = JHTML::_ ( 'select.radiolist', $mailto, 'mailto', 'class="inputbox"', 'id', 'title', $row->mailto );
		
		JFilterOutput::objectHTMLSafe ( $row );
		JFilterOutput::objectHTMLSafe ( $lists );
		
		$this->assignRef ( "row", $row );
		$this->assignRef ( "edit", $edit );
		$this->assignRef ( "lists", $lists );
		parent::display ( $tpl );
	}
}
?>