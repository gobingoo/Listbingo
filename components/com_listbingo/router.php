<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: router.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from GOBINGOO.
 *
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

//Function to convert a system URL to a SEF URL


function ListbingoBuildRoute(&$query) {
	$segments = array ();
	
	if (isset ( $query ['catid'] )) {
		$segments [] = JText::_ ( 'categories' );
		$segments [] = $query ['catid'];
		unset ( $query ['catid'] );
	}
	
	if (isset ( $query ['task'] )) {
		$task = $query ['task'];
		$taskpieces = explode ( ".", $task );
		foreach ( $taskpieces as $t ) {
			array_push ( $segments, array_shift ( $taskpieces ) );
		}
		
		switch ($task) {
			
			case 'ads.view' :
				$adid=$query['adid'];
				$segments[]=$adid;
				unset($query['adid']);
				break;
				
				case 'ads.edit' :
				$adid=$query['adid'];
				$segments[]=$adid;
				unset($query['adid']);
				break;
		
		}
		
		unset ( $query ['task'] );
	}
	return $segments;

}

//Function to convert a SEF URL back to a system URL


function ListbingoParseRoute($segments) {
	
	$vars = array ();

	
	if (count ( $segments ) > 0) {
		if ($segments [0] == 'categories'&&(isset($segments[1])&&$segments[1]!='loadef')) {
			if (isset ( $segments [1] )) {
				$vars ['catid'] = ( int ) $segments [1];
				array_shift ( $segments );
				array_shift ( $segments );
			}
		
		}
		
		if(isset($segments[0])&&isset($segments[1])&&isset($segments[1])&&$segments[0]=='ads'&&($segments[1]=='view'||$segments[1]=='edit'))
		{
			$vars['adid']=(int)$segments[2];
		}
		
		$vars ['task'] = implode ( ".", $segments );
	
	}
	
	return $vars;

}

?>
