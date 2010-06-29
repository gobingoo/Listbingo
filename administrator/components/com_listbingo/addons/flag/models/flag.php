<?php
/**
 * @package Gobingoo
 * @subpackage flag
 *
 * Flag Addon Model
 */
defined ( 'JPATH_BASE' ) or die ();
gbimport ( "gobingoo.addonsmodel" );

class GModelFlagFlag extends GAddonsModel {

	function save($data) {

		if (! is_array ( $data )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}

		$table = JTable::getInstance ( "flag" );

		if (! $table->bind ( $data )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $table->getError (), 401 );
		}

		if (! $table->id) {
			$table->ordering = $table->getNextOrder ();
		}

		if (! $table->check ()) {
			throw new DataException ( $table->getError (), 402 );
		}

		if (! $table->store ()) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $table->getError (), 402 );
		}

		return $table->id;

	}

	function getFlagStat() {
		$db = JFactory::getDBO ();
		$query = "SELECT count(distinct(f.id)) as flagcount from #__gbl_flag as f INNER JOIN #__gbl_ads a ON (f.item_id=a.id)";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}

	function doSuspension($params = null) {
		$db = JFactory::getDBO ();
		$dosuspension = $params->get ( 'enable_suspesion_after_flag_limit', 0 );
		if ($dosuspension) {
			$flaglimit=$params->get('flag_limit',5);
			$query = "SELECT a.id FROM #__gbl_ads as a
		WHERE (SELECT count(*) FROM #__gbl_flag as f WHERE f.item_id=a.id)>=$flaglimit";
				
			$db->setQuery ( $query );
			$result = $db->loadObjectList ();
				
			if (count ( $result ) > 0) {
				$id = array ();
				foreach ( $result as $r ) {
					$id [] = $r->id;
						
					$table = JTable::getInstance ( 'ad' );
					$table->load($r->id);
					$table->status = 2;
					$table->store ();
					GApplication::triggerEvent ( "onAdSuspended", array ($table, $params ) );

				}

				if (count ( $id ) > 0) {
					$ids = implode ( ",", $id );
					$query = "DELETE FROM #__gbl_flag WHERE item_id IN ($ids)";
					$db->setQuery ( $query );
					$db->query ();
				}
			}
		}

	}

	function checkFlaggedItem($filter) {
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) FROM #__gbl_flag WHERE email='" . $filter->email . "' AND item_id='" . $filter->item_id . "'";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}

	function isFromThisIP($id, $ip) {
		$db = JFactory::getDBO ();
		$query = "SELECT * FROM #__gbl_flag WHERE item_id=$id AND ipaddress='$ip'";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}

	function load($id) {
		$db = JFactory::getDBO ();
		$query = "SELECT * FROM #__gbl_flag WHERE id=$id";
		$db->setQuery ( $query );
		$rows = $db->loadObject ();

		/*$table = JTable::getInstance('flag');
		 $rows = $table->load($id);*/

		$admodel = gbimport ( "listbingo.model.ad" );
		$rows->ad = $admodel->loadWithFields ( $rows->item_id, false );
	

		return $rows;
	}

	function remove($cid) {
		$db = JFactory::getDBO ();
		$query = "DELETE FROM #__gbl_flag WHERE item_id IN ($cid)";
		$db->setQuery ( $query );
		$db->query ();
	}

	function getFlagLists($row = null)
	{

		$db = JFactory::getDBO ();

		if (count ( $row ) > 0)
		{
				
			$query = "SELECT f.*,u.username FROM #__gbl_flag as f
			LEFT JOIN #__users as u ON (u.id=f.user_id)
			WHERE item_id=$row->id";
		}
		else
		{
			$query = ' SELECT f.*,u.username, a.title as atitle'
			.' FROM #__gbl_flag as f'
			.' LEFT JOIN #__gbl_ads as a ON (f.item_id=a.id)'
			.' LEFT JOIN #__users as u ON (u.id=f.user_id)'
			;
		}
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}

	function getBasicVariables($row = null, $params = null) {

		$mainframe = JFactory::getApplication ();

		$mailvars = array ();

		$db = JFactory::getDBO ();
		$query = "SELECT id from #__users where usertype='Super Administrator' and block=0 limit 1";
		$db->setQuery ( $query );

		$uid = $db->loadResult ();

		$admin = JFactory::getUser ( $uid );
		$mailvars ['adminemail'] = $admin->get ( 'email' );

		if (! is_null ( $row )) {
				
			$receiver = JFactory::getUser ( $row->user_id );
			$mailvars ['receivername'] = $receiver->get ( 'name' );
			$mailvars ['receiveremail'] = $receiver->get ( 'email' );
			$currentuser = JFactory::getUser ();
			if (! $currentuser->guest) {
				$mailvars ['sendername'] = $currentuser->get ( 'name' );
				$mailvars ['senderemail'] = $currentuser->get ( 'email' );
					
			} else {
				$mailvars ['sendername'] = JText::_ ( "Guest" );
				$mailvars ['senderemail'] = $mainframe->getCfg ( 'mailfrom' );
					
			}
		} else {
				
			$mailvars ['receivername'] = $admin->get ( 'name' );
			$mailvars ['receiveremail'] = $admin->get ( 'email' );
			$currentuser = JFactory::getUser ();
			if ($currentuser) {
				$mailvars ['sendername'] = $currentuser->get ( 'name' );
				$mailvars ['senderemail'] = $currentuser->get ( 'email' );
					
			} else {
				$mailvars ['sendername'] = JText::_ ( "Guest" );
				$mailvars ['senderemail'] = $mainframe->getCfg ( 'mailfrom' );
					
			}
		}

		$mailvars ['sitename'] = $mainframe->getCfg ( 'sitename' );
		$mailvars ['sitelink'] = JUri::root ();

		return $mailvars;
	}

	function getAdVariables($row = null, $params = null) {
		global $option;
		if (is_null ( $row )) {
			return;
		}

		$model = gbimport ( "listbingo.model.ad" );
		gbimport ( "gobingoo.currency" );
		$ad = $model->loadWithFields ( $row->id );
		$mailvariables = array ();
		if ($ad) {
				
			$currency = new GCurrency ();
			$currency->setParameters ( $params->get ( 'currency_format' ), $params->get ( 'decimals' ), $params->get ( 'decimal_separator' ), $params->get ( 'value_separator' ) );
			$currency->setValue ( $ad->price, $ad->currencycode, $ad->currency );
			$mailvariables ['adlink'] = GHelper::route ( "index.php?option=$option&task=ads.view&id=$ad->id", false );
			$mailvariables ['adtitle'] = $ad->title;
			$mailvariables ['amount'] = $currency->toString ();
			$mailvariables ['postdate'] = date ( $params->get ( 'date_format' ), strtotime ( $ad->created_date ) );
			$mailvariables ['adid'] = $ad->globalad_id;
			$mailvariables ['fulldescription'] = $ad->description;
			$address = array ();
			$regions = array ();
			if (! empty ( $ad->address->address )) {
				$address [] = $ad->address->address;
			}
				
			if (! empty ( $ad->address->street )) {
				$address [] = $ad->address->street;
			}
				
			if (! empty ( $ad->address->region )) {
				$regions [] = $ad->address->region;
			}
				
			if (! empty ( $ad->address->state )) {
				$regions [] = $ad->address->state;
			}
				
			if (! empty ( $ad->address->zipcode )) {
				$regions [] = $ad->address->zipcode;
			}
			$baseurl = JUri::root ();
				
			$mailvariables ['address'] = implode ( ", ", $address );
			$mailvariables ['fulladdress'] = implode ( ", ", $address ) . "<br/>" . implode ( ", ", $regions );
			$midthumbnail = $params->get ( 'suffix_thumbnail_mid' );
			if (count ( $ad->images ) > 0) {
				$mailvariables ['adimage'] = $baseurl . $ad->images [0]->image . $midthumbnail . "." . $ad->images [0]->extension;
			} else {
				$mailvariables ['adimage'] = "";
			}
		}

		return $mailvariables;
	}

}
?>