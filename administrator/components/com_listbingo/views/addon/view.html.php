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
class ListbingoViewAddon extends GView {
	function display($tpl = null) {
		
	global $option;

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );
	
		$model=gbimport("listbingo.model.addon");
			
		$row=$model->load($id);
		$edit=false;
		if($id)
		{
			$edit=true;
		}
		
		$lists=array();
		
		$lists['published']=JHTML::_('select.booleanlist','published','class="inputbox"',$row->published);
		
		$pluginpath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS.$row->folder.DS.$row->element.".xml";
		$params = new JParameter( $row->params, $pluginpath );
			
		
		$this->assignRef("row",$row);
		$this->assignRef("edit",$edit);
		$this->assignRef("lists",$lists);
		
		$this->assignRef('params',		$params);
		
		parent::display($tpl);
	}
}
?>