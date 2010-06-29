<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: userpost.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Alex
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.model");

class ListbingoModelUserpost extends GModel {

	function canPost($user,$params)
	{
		if($params->get('posting_scheme',0)==1)
		{
			$freepost=$params->get('freepost',0);
			$query="SELECT * from #__gbl_user_posts where post_type='1' and user_id='".$user->get('id')."'";
			$count=$this->_getListCount($query);
			if($count<=$freepost)
			{
				return true;
			}
			else
			{
				return false;
			}
			
		}
		
		return true;
	}
	
	function trackPost($user,$id,$referenceid,$params)
	{
		
		$date = JFactory::getDate();
				
		$table = JTable::getInstance('userpost');
		
		$table->user_id = $user->get('id');
		$table->ad_id = $id;
		$table->post_type = $params->get('posting_scheme');
		$table->postdate = $date->toFormat();
		$table->reference_id=$referenceid;
		$table->store();
		
		
	}
	
	function resetTracker($user)
	{
		
	}
}
?>