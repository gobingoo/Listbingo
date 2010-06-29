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

class ListbingoViewCategory extends GView 
{
	function display($tpl = null) 
	{
		
		global $option;

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id				= JRequest::getVar( 'id', $cid[0], '', 'int' );

		$model=gbimport("listbingo.model.category");
		$configmodel=gbimport("listbingo.model.configuration");
		$params=$configmodel->getParams();
			
		$row=$model->load($id);
		
		
		$edit=false;
		if($id)
		{
			$edit=true;
		}

		$lists=array();
		
		$filter = new stdClass();
		$filter->id = $id;
		$filter->parent_id=$row->parent_id;
		
		$parent1 = array();
		$parent1[] = JHTML::_('select.option', '0', JText::_('Root'), 'value', 'text');
				
		$categories=$model->getTreeForSelect(true,$filter);

		$parent2=array();

		if(count($categories)>0)
		{
			foreach($categories as $xc)
			{
				$parent2[]=JHTML::_('select.option', $xc->value, JText::_(".  ".$xc->treename), 'value', 'text');
			}
				
		}
		
		$parent=array_merge($parent1,$parent2);
		
		if($id)
		{
			$selected = $row->parent_id;
			$published = $row->published;
			$hasprice = $row->hasprice;
		}
		else
		{
			$selected = 0;
			$published = 1;
			$hasprice = 1;
		}
		
		//$lists['categories'] = JHTML::_('select.genericlist',   $parent, 'categories[]', 'class="inputbox" style="width:200px;" size="20" multiple="multiple"', 'value', 'text', $selected );
		
		$lists['parent'] = JHTML::_('select.genericlist',   $parent, 'parent_id', 'class="inputbox" style="width:200px;" size="20"', 'value', 'text', $selected );
		
		$lists['related'] = JHTML::_('select.genericlist',   $parent, 'related[]', 'class="inputbox" style="width:200px;" size="20" multiple="multiple"', 'value', 'text', $row->related );

		$lists['published']=JHTML::_('select.booleanlist','published','class="inputbox"',$published);
		$lists['hasprice']=JHTML::_('select.booleanlist','hasprice','class="inputbox"',$hasprice);
		$lists['access']=JHTML::_('list.accesslevel',  $row );
		
		JFilterOutput::objectHTMLSafe( $row );
		JFilterOutput::objectHTMLSafe( $edit );
		JFilterOutput::objectHTMLSafe( $lists );
		JFilterOutput::objectHTMLSafe( $params );
		
		$this->assignRef("row",$row);
		$this->assignRef("edit",$edit);
		$this->assignRef("lists",$lists);
		$this->assignRef('params',$params);

		parent::display($tpl);
	}
}
?>