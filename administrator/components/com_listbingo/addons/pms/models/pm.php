<?php
/**
 * @package Gobingoo
 * @subpackage pm
 *
 * PM Addon Model
 */
defined ( 'JPATH_BASE' ) or die ();
gbimport ( "gobingoo.addonsmodel" );

class GModelPmsPm extends GAddonsModel {
	
	var $_count = 0;
	
	function load($id) {
		$table = JTable::getInstance ( "pm" );
		$table->load ( $id );
		return $table;
	
	}
	
	function save($post = null, $params = null) {
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "pm" );
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ()) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		$admodel = gbimport ( "listbingo.model.ad" );
		
		$xrow = $admodel->load ( $post ['ad_id'] );
		
		$xrow->pms = $row;
		
		return $xrow;
	}
	
	function dispatch(&$row = null, &$params = null) {
		
		$mainframe = JFactory::getApplication ();
		
		try {
			$emailvariables = self::getBasicVariables ( $row, $params );
			
			$advariables = self::getAdVariables ( $row, $params );
			
			$emailvariables = array_merge ( $emailvariables, $advariables );
			
			$results = GApplication::triggerEvent ( 'onEmailLoad', array ($row, $params, 'pms', $row ) );
			
			if (count ( $results ) > 0) {
				foreach ( $results as $r ) {
					if (! is_null ( $r )) {
						$emailvariables = array_merge ( $emailvariables, $r );
					}
				}
			}

			
			$usermails = self::_getMailFormatForReceiver ( 'onReplySave' );
			
			gbimport ( "gobingoo.mail" );
			$mail = new GMail ();
			
			$mail->setTransform ( $emailvariables );
			$mail->addRecipient ( $emailvariables ['receiveremail'] );
						
			if (count ( $usermails ) > 0) {
				foreach ( $usermails as $umail ) {
					
					$mail->setSender ( array ($mainframe->getCfg ( 'mailfrom' ), $mainframe->getCfg ( 'fromname' ) ) );
					$mail->setSubject ( $umail->subject );
					$mail->setBody ( $umail->body );
					$mail->init ();
					
					$mail->ClearReplyTos ();
					$mail->addReplyTo ( array ($umail->reply_to_email, $umail->reply_to ) );
					if (! empty ( $umail->from_email )) {
						$mail->setSender ( array ($umail->from_email, $umail->from_name ) );
					}
					
					$mail->send ();
				
				}
			}
			
		/*	echo "<pre>";
			print_r ( $mail );
			exit ();*/
			
			$sendermails = self::_getMailFormatForSender ( 'onReplySave' );
			gbimport ( "gobingoo.mail" );
			$mail = new GMail ();
			
			$mail->setTransform ( $emailvariables );
			$mail->addRecipient ( $row->pms->contact_email );
			
			if (count ( $sendermails ) > 0) {
				foreach ( $sendermails as $umail ) {
					
					$mail->setSender ( array ($mainframe->getCfg ( 'mailfrom' ), $mainframe->getCfg ( 'fromname' ) ) );
					$mail->setSubject ( $umail->subject );
					$mail->setBody ( $umail->body );
					$mail->init ();
					
					$mail->ClearReplyTos ();
					$mail->addReplyTo ( array ($umail->reply_to_email, $umail->reply_to ) );
					if (! empty ( $umail->from_email )) {
						$mail->setSender ( array ($umail->from_email, $umail->from_name ) );
					}
					
					$mail->send ();
				
				}
			}
			
			$mail->ClearAddresses ();
			$mail->addRecipient ( ! empty ( $emailvariables ['adminemail'] ) ? $emailvariables ['adminemail'] : $mainframe->getCfg ( 'mailfrom' ) );
			
			$adminemails = self::_getMailFormatForAdmin ( 'onReplySave' );
			if (count ( $adminemails ) > 0) {
				foreach ( $adminemails as $umail ) {
					
					$mail->setSender ( array ($mainframe->getCfg ( 'mailfrom' ), $mainframe->getCfg ( 'fromname' ) ) );
					$mail->setSubject ( $umail->subject );
					$mail->setBody ( $umail->body );
					$mail->init ();
					
					$mail->ClearReplyTos ();
					$mail->addReplyTo ( array ($umail->reply_to_email, $umail->reply_to ) );
					if (! empty ( $umail->from_email )) {
						$mail->setSender ( array ($umail->from_email, $umail->from_name ) );
					}
					$mail->send ();
				
				}
			}
		
		} catch ( MailException $e ) {
			echo $e->getMessage ();
		}
		
		return true;
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
	
	function _getMailFormatForSender($event) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_mailformats where published='1' and mailto=2 and event like '$event:%'";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _getMailFormatForReceiver($event) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_mailformats where published='1' and mailto=1 and event like '$event:%'";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _getMailFormatForAdmin($event) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_mailformats where published='1' and mailto=0 and event like '$event:%'";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function getUsedEvents() {
		$db = JFactory::getDBO ();
		$query = "SELECT distinct(event) from #__gbl_mailformats where published='1'";
		$db->setQuery ( $query );
		return $db->loadResultArray ();
	}
	
	function getLists($filter) {
		$db = JFactory::getDBO ();
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', m.message_date DESC';
		
		$query = "SELECT m.*, a.title as ad, s.username as susername, r.username  as rusername
		FROM #__gbl_messages as m
		LEFT JOIN #__gbl_ads as a ON (a.id = m.ad_id)
		LEFT JOIN #__users as s ON (s.id = m.message_from)
		LEFT JOIN #__users as r ON (r.id = m.message_to)
		$orderby
		";
		$db->setQuery ( $query );
		$rows = $this->_getList ( $query, $filter->limitstart, $filter->limit );
		
		$this->_count = $this->_getListCount ( $query );
		return $rows;
	
	}
	
	function getListsCount() {
		return $this->_count;
	}
	
	function remove($cid = array()) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_messages where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function loadMessageDetails($id) {
		$db = JFactory::getDBO ();
		$query = "SELECT m.*, a.title as ad, s.username as susername, r.username  as rusername
		FROM #__gbl_messages as m
		LEFT JOIN #__gbl_ads as a ON (a.id = m.ad_id)
		LEFT JOIN #__users as s ON (s.id = m.message_from)
		LEFT JOIN #__users as r ON (r.id = m.message_to)
		WHERE m.id=$id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getMyPms($userid, $filter) {
		$db = JFactory::getDBO ();
		
		$orderby = ' ORDER BY m.message_date DESC';
		
		$query = "SELECT m.*, a.title as ad, s.username as susername, r.username  as rusername
		FROM #__gbl_messages as m
		LEFT JOIN #__gbl_ads as a ON (a.id = m.ad_id)
		LEFT JOIN #__users as s ON (s.id = m.message_from)
		LEFT JOIN #__users as r ON (r.id = m.message_to)
		WHERE m.message_to=$userid
		$orderby
		";
		$db->setQuery ( $query );
		$rows = $this->_getList ( $query, $filter->limitstart, $filter->limit );
		$this->_count = $this->_getListCount ( $query );
		return $rows;
	}
	
	function viewMyPm($id, $userid) {
		$db = JFactory::getDBO ();
		
		$orderby = ' ORDER BY m.message_date DESC';
		
		$query = "SELECT m.*, a.title as ad, s.username as susername, r.username  as rusername
		FROM #__gbl_messages as m
		LEFT JOIN #__gbl_ads as a ON (a.id = m.ad_id)
		LEFT JOIN #__users as s ON (s.id = m.message_from)
		LEFT JOIN #__users as r ON (r.id = m.message_to)
		WHERE m.id=$id AND m.message_to=$userid
		$orderby
		";
		$db->setQuery ( $query );
		$rows = $db->loadObject ();
		
		if (count ( $rows )) {
			$table = JTable::getInstance ( 'pm' );
			$table->id = $id;
			$table->status = 1;
			$table->store ();
		}
		
		return $rows;
	}
	
	function removeMyPm($cid = array(), $userid) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_messages where id in ($cids) AND message_to=$userid";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}

}
?>