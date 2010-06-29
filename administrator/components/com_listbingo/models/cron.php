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

// Import Joomla! libraries
gbimport ( "gobingoo.model" );

class ListbingoModelCron extends GModel {
	
	function getCronTracker($scope = "ad", $subscope = 'expired') {
		$table = JTable::getInstance ( 'crontracker' );
		$table->loadToday ( $scope, $subscope );
		return $table;
	
	}
	
	function core($params = null) {
		global $mainframe;
		$todaytracker = self::getCronTracker ();
		$todaytracker->lastrunid;
		
		self::expire ( $params );
		self::alertExpire ( $params );
		self::archive ( $params );
		self::addons ( $params );
	
	}
	
	function addons($params = null) {
		
		GApplication::triggerEvent ( 'onCron', array (&$params ) );
	}
	
	function expire($params = null) {
		
		$tracker = self::getCronTracker ( 'ad', 'expired' );
		
		if (is_null ( $tracker )) {
			return;
		}
		
		$admodel = gbimport ( "listbingo.model.ad" );
		
		$db = JFactory::getDBO ();
		$nulldate = $db->getNullDate ();
		$count = $params->get ( 'cron_core_items', 100 );
		$query = "SELECT  * from #__gbl_ads where expiry_date< now()  and expiry_date!='$nulldate' and id>" . ( int ) $tracker->lastrunid . " limit $count";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		$lastrun = 0;
		
		if (count ( $rows ) > 0) {
			foreach ( $rows as $r ) {
				$ad = $admodel->load ( $r->id );
				
				$ad->status = 3;
				$ad->store ();
				
				GApplication::triggerEvent ( 'onAdExpiry', array (&$ad, &$params ) );
				$lastrun = $r->id;
			}
		}
		
		self::updateTracker ( $lastrun, 'ad', 'expired', $params );
	
	}
	
	function alertExpire($params = null) {
		
		$tracker = self::getCronTracker ( 'ad', 'before_expiry' );
		
		if (is_null ( $tracker )) {
			return;
		}
		$alertbefore = $params->get ( 'days_before_expiry', 7 );
		$count = $params->get ( 'cron_core_items', 100 );
		
		$admodel = gbimport ( "listbingo.model.ad" );
		$db = JFactory::getDBO ();
		$nulldate = $db->getNullDate ();
		 $query = "SELECT  * from #__gbl_ads where DATE_ADD(expiry_date, INTERVAL -$alertbefore DAY)< now()  and expiry_date!='$nulldate' and status=1 and id>" . ( int ) $tracker->lastrunid . " limit $count";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		$lastrun = 0;
		
		if (count ( $rows ) > 0) {
			foreach ( $rows as $r ) {
				$ad = $admodel->load ( $r->id );
				
				GApplication::triggerEvent ( 'onAdExpiryAlert', array (&$ad, &$params ) );
				$lastrun = $r->id;
			}
		}
		self::updateTracker ( $lastrun, 'ad', 'before_expiry', $params );
	
	}
	
	function archive($params = null) {
		
		$autoarchive = $params->get ( 'auto_archive', 0 );
		$archivedays = $params->get ( 'archive_days', 30 );
		if ($autoarchive) {
			$tracker = self::getCronTracker ( 'ad', 'archive' );
			
			if (is_null ( $tracker )) {
				return;
			}
			
			$admodel = gbimport ( "listbingo.model.ad" );
			
			$db = JFactory::getDBO ();
			$nulldate = $db->getNullDate ();
			
			$count = $params->get ( 'cron_core_items', 100 );
			
			$query = "SELECT  * from #__gbl_ads where DATE_ADD(expiry_date, INTERVAL $archivedays DAY)< now()  and expiry_date!='$nulldate' and id>" . ( int ) $tracker->lastrunid . " limit $count";
			$db->setQuery ( $query );
			$rows = $db->loadObjectList ();
			
			$lastrun = 0;
			
			if (count ( $rows ) > 0) {
				foreach ( $rows as $r ) {
					$ad = $admodel->load ( $r->id );
					
					$ad->status = 4;
					$ad->store ();
					
					GApplication::triggerEvent ( 'onAdExpiry', array (&$ad,& $params ) );
					$lastrun = $r->id;
				}
			}
			
			self::updateTracker ( $lastrun, 'ad', 'archive', $params );
		}
	
	}
	
	function updateTracker($lastrunid, $scope = 'ad', $subscope = 'expired', $params = null) {
		$table = JTable::getInstance ( 'crontracker' );
		$table->loadToday ( $scope, $subscope );
		$table->lastrun = date ( "Y-m-d H:i:s" );
		if ($lastrunid) {
			$table->lastrunid = $lastrunid;
		}
		$table->scope = $scope;
		$table->subscope = $subscope;
		$table->store ();
	
	}

}
?>
