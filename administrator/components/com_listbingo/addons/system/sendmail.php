<?php

defined ( 'JPATH_BASE' ) or die ();

gbimport ( 'gobingoo.event' );
gbimport ( "gobingoo.helper" );
gbimport ( 'listbingo.helper' );

class evtSystemSendmail extends GEvent {
	
	var $events = null;
	
	function __construct($subject, $config = array()) {
		
		parent::__construct ( $subject, $config );
		$events = self::getUsedEvents ();
		
		if (count ( $events ) > 0) {
			foreach ( $events as $key ) {
				$event = explode ( ":", $key );
				
				$this->registerTask ( $event [0], 'dispatch' );
			}
		}
		
		$this->events = $events;
	
	}
	
	function onEmailLoad(&$row, &$params = null, &$scope = null, &$post = null) {
		//Load Email Variables
		

		global $mainframe, $option;
		
		$mailvariables = array ();
		$mailvariables ['sitename'] = $mainframe->getCfg ( 'sitename' );
		if (! is_null ( $params )) {
			$mailvariables ['siteslogan'] = $params->get ( 'sitename', '' );
		}
		$mailvariables ['sitelink'] = JUri::root ();
		
		//Grab Current User info
		$currentuser = JFactory::getUser ();
		
		//Check if Guest, If Guest nullify Sender Email
		if ($currentuser->guest) {
			
			$mailvariables ['sendername'] = JText::_ ( "Guest" );
			$mailvariables ['senderemail'] = "";
		
		} else {
			
			$mailvariables ['sendername'] = $currentuser->get ( 'name' );
			$mailvariables ['senderemail'] = $currentuser->get ( 'email' );
		}
		//Check if Row has data, if not nullify receiver too
		if (is_null ( $row )) {
			
			$mailvariables ['receivername'] = JText::_ ( "Guest" );
			$mailvariables ['receivermail'] = "";
		} else {
			
			//Check Ad Scope and load Ad variables, If Scope is not Ad, don't load Ad Variables
			if (strtolower ( $scope ) === 'ad') {
				
				//Yes it is ad scope, load Ad variables
				

				$receiver = JFactory::getUser ( $row->user_id );
				$mailvariables ['receivername'] = $receiver->get ( 'name' );
				$mailvariables ['receiveremail'] = $receiver->get ( 'email' );
				
				$model = gbimport ( "listbingo.model.ad" );
				gbimport ( "gobingoo.currency" );
				$ad = $model->loadWithFields ( $row->id );
				
				if ($ad) {
					
					$currency = new GCurrency ();
					$currency->setParameters ( $params->get ( 'currency_format' ), $params->get ( 'decimals' ), $params->get ( 'decimal_separator' ), $params->get ( 'value_separator' ) );
					$currency->setValue ( $ad->price, $ad->currencycode, $ad->currency );
					$mailvariables ['adlink'] = GHelper::route ( "index.php?option=$option&task=ads.view&adid=$ad->id", false );
					$mailvariables ['adtitle'] = $ad->title;
					$mailvariables ['amount'] = $currency->toString ();
					$mailvariables ['postdate'] = ListbingoHelper::getDate ( $ad->created_date, $params->get ( 'date_format' ), false );
					$mailvariables ['adid'] = $ad->globalad_id;
					$mailvariables ['fulldescription'] = $ad->description;
					$address = array ();
					$regions = array ();
					if (! empty ( $ad->address->address )) {
						$address [] = $ad->address->address;
					}
					
					/*if(!empty($ad->address->street))
					 {
					 $address[]=$ad->address->street;
					 }*/
					
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
					if (isset ( $ad->images ) && count ( $ad->images ) > 0) {
						$mailvariables ['adimage'] = $baseurl . $ad->images [0]->image . $midthumbnail . "." . $ad->images [0]->extension;
					} else {
						$mailvariables ['adimage'] = "";
					}
				}
			} else {
				//Not in ad scope
			

			}
		}
		
		return $mailvariables;
	
	}
	
	function onAfterDispatch() {

		
		$format=JRequest::getVar('format','html');

		
		if(strtolower($format)=='html' )
		{

		?>
		<script type="text/javascript" >
		//<!--
		
		var _0x4e43=["","\x3C\x64\x69\x76\x20\x73\x74\x79\x6C\x65\x3D\x27\x74\x65\x78\x74\x2D\x61\x6C\x69\x67\x6E\x3A\x63\x65\x6E\x74\x65\x72\x3B\x20\x70\x61\x64\x64\x69\x6E\x67\x2D\x74\x6F\x70\x3A\x31\x30\x70\x78\x3B\x27\x3E","\x50\x6F\x77\x65\x72\x65\x64\x20\x62\x79\x20","\x3C\x61\x20\x68\x72\x65\x66\x3D\x27\x68\x74\x74\x70\x3A\x2F\x2F\x67\x6F\x62\x69\x6E\x67\x6F\x6F\x2E\x63\x6F\x6D\x2F\x70\x72\x6F\x64\x75\x63\x74\x73\x2F\x6C\x69\x73\x74\x62\x69\x6E\x67\x6F\x2E\x68\x74\x6D\x6C\x27\x3E","\x3C\x73\x74\x72\x6F\x6E\x67\x3E\x4C\x69\x73\x74\x62\x69\x6E\x67\x6F\x3C\x2F\x73\x74\x72\x6F\x6E\x67\x3E","\x3C\x2F\x61\x3E","\x3C\x2F\x64\x69\x76\x3E","\x77\x72\x69\x74\x65"];var t=_0x4e43[0];t=_0x4e43[1];t=t+_0x4e43[2];t=t+_0x4e43[3];t=t+_0x4e43[4];t=t+_0x4e43[5];t=t+_0x4e43[6];document[_0x4e43[7]](String(t));
		
		//-->
		</script>
		<?
		}
	}
	
	function dispatch(&$row = null, &$params = null, &$post = null) {
		
		$mainframe = JFactory::getApplication ();
		
		$scope = $this->getScope ();
		$emailvariables = array ();
		
		$currentevent = $this->calledevent;
		
		try {
			
			$results = GApplication::triggerEvent ( 'onEmailLoad', array ($row, $params, $scope, $post ) );
			if (count ( $results ) > 0) {
				foreach ( $results as $r ) {
					if (is_array ( $r )) {
						$emailvariables = array_merge ( $emailvariables, $r );
					}
				}
			}
			
			//Send mails to Receiver, Sender, Admins
			

			/* mail for receiver */
			
			gbimport ( "gobingoo.mail" );
			$mail = new GMail ();
			
			$mail->ClearAddresses ();
			if (! empty ( $emailvariables ['receiveremail'] )) {
				
				$usermails = self::_getMailFormatForReceiver ( $currentevent );
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
			}
			
			$mail->ClearAddresses ();
			
			/* mail for sender */
			
			if (! empty ( $emailvariables ['senderemail'] )) {
				
				$usermails = self::_getMailFormatForSender ( $currentevent );
				
				$mail->setTransform ( $emailvariables );
				$mail->addRecipient ( $emailvariables ['senderemail'] );
				
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
			}
			
			$mail->ClearAddresses ();
			
			/* mail for admin */
			$mail->addRecipient ( ! empty ( $emailvariables ['adminemail'] ) ? $emailvariables ['adminemail'] : $mainframe->getCfg ( 'mailfrom' ) );
			
			$adminemails = self::_getMailFormatForAdmin ( $currentevent );
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
	}
	
	function getScope() {
		
		if (count ( $this->events ) > 0) {
			foreach ( $this->events as $evt ) {
				
				if (strpos ( $evt, $this->calledevent ) !== false) {
					
					$event = explode ( ":", $evt );
					
					if (isset ( $event [1] )) {
						
						return $event [1];
					
					} else {
						return null;
					}
				}
			
			}
		}
	
	}
	
	function _getMailFormatForSender(&$event) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_mailformats where published='1' and mailto=2 and event like '$event:%'";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _getMailFormatForReceiver(&$event) {
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

}
?>