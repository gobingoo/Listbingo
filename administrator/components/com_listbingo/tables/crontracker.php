<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ad.php 2010-01-10 00:57:37 svn $
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
gbimport ( "gobingoo.table" );
// Include library dependencies
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableCrontracker extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $lastrun = null;
	
	var $scope = null;
	
	var $subscope=null;
	
	var $lastrunid = null;
	
	var $trackerinfo = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_crontracker', 'id', $db );
	}
	
	function loadToday($scope,$subscope='') {
		$today = date ( "Y-m-d" );
		 $query = "SELECT * from #__gbl_crontracker where date_format(lastrun,'%Y-%m-%d')='$today' and scope='$scope' and subscope='$subscope'";
		$db = JFactory::getDBO ();
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		
		$id = 0;
		if ($obj) {
			$id = $obj->id;
		}
		parent::load ( $id );
	}

}
?>