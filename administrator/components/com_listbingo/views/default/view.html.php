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
jimport( 'joomla.application.component.view');
class ListbingoViewDefault extends JView 
{
	function display($tpl = null) 
	{
		global $option;
		
		
		$params = &JComponentHelper::getParams($option);
		$this->assignRef('params',$params);
		
		$filter = new stdClass();
		$filter->params = $params;
		
		$admodel = gbimport('listbingo.model.ad');
		$adstats = $admodel->getAdStats($filter);
		
		if(!is_object($adstats))
		{
			$adstats=new stdClass();
			$adstats->newpostcount=0;
			$adstats->totalcount=0;
			$adstats->featuredcount=0;
			$adstats->publishedcount=0;
			$adstats->unpublishedcount=0;
			
		}
		$this->assignRef('adstats',$adstats);
		$this->assignRef('params',$params);
		parent::display($tpl);
	}
}
?>