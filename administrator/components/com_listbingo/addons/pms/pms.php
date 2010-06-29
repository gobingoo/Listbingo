<?php

defined ( 'JPATH_BASE' ) or die ();

gbimport ( 'gobingoo.event' );

class evtPmsPms extends GEvent {
	
	function onSettingsNavigation() {
		?>
<li><a id="pms"><?php
		echo JText::_ ( 'PMS' );
		?></a></li>
<?php
	}
	
	function onSettingsPageDisplay(&$params = null) {
		$controller = gbaddons ( "pms.controller.admin" );
		$controller->pmsSettingsPage ( $params );
	
	}
	
	function onAdminCpanelDisplay(&$icon = true) {
		global $option;
		$link = "index.php?option=$option&task=addons.pms.admin";
		GHelper::quickiconButton ( $link, 'message.png', JText::_ ( 'PMS' ), 'pms' );
	
	}
	
	function onBeforeDisplayTitle(&$row = null, &$params = null) {
		
		if (is_null ( $row )) {
			return;
		}
		
		$user = JFactory::getUser ();
		if ($user->get ( 'id' ) == $row->user_id) {
			return;
		}
		
		$controller = gbaddons ( "pms.controller.front" );
		$controller->showReply ( $row );
	}
	
	function onAfterDisplayContent(&$row = null, &$params = null) {
	
	}
	
	function onEmailVariablesLoad(&$pane) {
		echo $pane->startPanel ( JText::_ ( 'MESSAGE_VARIABLES' ), 'message-pane' );
		?>
<ul class="variablelist">
	<li class="variables">{messagedate}</li>
	<li class="variables">{messagesubject}</li>
	<li class="variables">{message}</li>
	<li class="variables">{messagelink}</li>
	<li class="variables">{contactname}</li>
	<li class="variables">{contactemail}</li>
	<li class="variables">{contactphone}</li>

</ul>
<?php
		echo $pane->endPanel ();
	}
	
	function onEmailLoad(&$row = null, &$params = null, &$scope = null, &$post = null) {
		
		global $option;
		
		if (strtolower ( $scope ) != 'pms') {
			return;
		}
		
		//var_dump($row->pms);exit;
		if (is_null ( $row )) {
			return;
		}
		
		$pm = $row->pms;
				
		$model = gbaddons ( "pms.model.pm" );
		$pmdata = $model->load ( $pm->id );
		
		
		$mailvars = array ();
		gbimport ( "gobingoo.currency" );
		$currency = new GCurrency ();
		$currency->setParameters ( $params->get ( 'currency_format' ), $params->get ( 'decimals' ), $params->get ( 'decimal_separator' ), $params->get ( 'value_separator' ) );
		$currency->setValue ( $row->price, $row->currencycode, $row->currency );
		$mailvars ['adlink'] = GHelper::route ( "index.php?option=$option&task=ads.view&adid=$row->id", false );
		$mailvars ['adtitle'] = $row->title;
		$mailvars ['amount'] = $currency->toString ();
		$mailvars ['postdate'] = date ( $params->get ( 'date_format' ), strtotime ( $row->created_date ) );
		$mailvars ['adid'] = $row->globalad_id;
		$mailvars ['fulldescription'] = $row->description;
		$address = array ();
		$regions = array ();
		if (! empty ( $row->address->address )) {
			$address [] = $row->address->address;
		}
		
		if ($pmdata) {
			$baseurl = JUri::root ();
			$mailvars ['messagedate'] = $pmdata->message_date;
			$mailvars ['messagesubject'] = sprintf ( JText::_ ( "INQUIRY_FOR_AD" ), $row->title );
			$mailvars ['message'] = $pmdata->message;
		
			$mailvars ['messagelink'] = GHelper::route ( "index.php?option=$option&task=addons.pms.my.view&mid=$pmdata->id" );
			$mailvars ['contactname'] = $pmdata->contact_name;
			$mailvars ['contactemail'] = $pmdata->contact_email;
			$mailvars ['contactphone'] = $pmdata->contact_phone;
		
		}
		
		$aduser = JFactory::getUser ( $row->user_id );
		
		$mailvars ['receivername'] = $aduser->get ( 'name' );
		$mailvars ['receiveremail'] = $aduser->get ( 'email' );
		$currentuser = JFactory::getUser ();
		if ($currentuser->guest) {
			$mailvars ['sendername'] = $pmdata->contact_name;
			$mailvars ['senderemail'] = $pmdata->contact_email;
		}
		
	
		
		return $mailvars;
	}

}
?>