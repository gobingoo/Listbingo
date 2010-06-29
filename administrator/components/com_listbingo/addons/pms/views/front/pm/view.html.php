<?php
/**
 * Joomla! 1.5 component listbingo
 *
 * @version $Id: view.html.php 2009-10-13 00:39:06 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage package
 * @license GNU/GPL
 *
 * Listbingo from gobingoo.com
 *
 * Code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class PmsViewPm extends GAddonsView
{
	function display($tpl = null)
	{
		global $mainframe,$option;

		$user = JFactory::getUser();
		$messageid = JRequest::getInt('mid',0);
		$configmodel = gbimport("listbingo.model.configuration");
		$params = $configmodel->getParams();
		if($user->guest)
		{
			$returnurl = base64_encode(JRoute::_("index.php?option=$option&task=addons.pms.my.view&mid=$messageid&time=".time(),false));

			$link = JRoute::_("index.php?option=com_user&view=login&return=$returnurl&time=".time(),false);
			$msg = JText::_("LOGIN_TO_VIEW_YOUR_PMS");
			GApplication::redirect($link,$msg,"error");
		}		
		
		$model = gbaddons("pms.model.pm");
		
		$row = $model->viewMyPm($messageid,$user->get('id'));		
		$this->assignRef('row',$row);			
		$this->assignRef('params', $params);	
		parent::display($tpl);
			
	}
}
?>