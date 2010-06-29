<?php

defined ( 'JPATH_BASE' ) or die ();

gbimport ( 'gobingoo.event' );

class evtFlagFlag extends GEvent {
	
	function onSettingsNavigation() {
		?>
		<li><a id="flag"><?php
		echo JText::_ ( 'Flag' );
		?></a></li>
<?php
	}
	
	function onSettingsPageDisplay(&$params = null) {
		$controller = gbaddons ( "flag.controller.admin" );
		$controller->flagSettingsPage ( $params );
	
	}
	
	function onBeforeDisplayTitle(&$row = null, &$params = null) {
		if (is_null ( $row )) {
			return;
		}
		
		$user = JFactory::getUser ();
		if ($user->get ( 'id' ) == $row->user_id) {
			return;
		}
		
		$controller = gbaddons ( "flag.controller.front" );
		$controller->displayFlag ( $row );
	}
	
	function onAdminCpanelDisplay(&$icon = true) {
		global $option;
		$link = "index.php?option=$option&task=addons.flag.admin";
		GHelper::quickiconButton ( $link, 'flag.png', JText::_ ( 'Flag' ), 'flag' );
	
	}
	
	/*function onAfterDisplayDetails(&$row=null,&$params=null)
	 {
		if(is_null($row))
		{
		return;
		}
		$controller=gbaddons("flag.controller.admin");
		$controller->displayFlagList($row);
		}*/
	
	function onEmailVariablesLoad(&$pane) {
		echo $pane->startPanel ( JText::_ ( 'FLAG_VARIABLE' ), 'flag-pane' );
		?>
<ul class="variablelist">
	<li class="variables">{flagged-as}</li>
	<li class="variables">{flagcomment}</li>
	<li class="variables">{flagemail}</li>
</ul>
<?php
		echo $pane->endPanel ();
	}
	
	function onEmailLoad(&$row = null, &$params = null, &$scope=null,&$post = null) {
		global $option;
		
		if (strtolower ( $scope ) != 'flag') {
			return;
		}
		
		if (is_null ( $row )) {
			return;
		}
		
		
		$model = gbaddons ( "flag.model.flag" );
		$flagdata = $model->load ( $row->id );
		
		$mailvars = array ();
		
		if ($flagdata) {
			$baseurl = JUri::root ();
			switch ($flagdata->flag_id) {
				case 1 :
					$mailvars ['flagged-as'] = JText::_ ( 'MISCATEGORIZED' );
					break;
				case 2 :
					$mailvars ['flagged-as'] = JText::_ ( 'FRAUD' );
					break;
				case 3 :
					$mailvars ['flagged-as'] = JText::_ ( 'ILLEGAL' );
					break;
				case 4 :
					$mailvars ['flagged-as'] = JText::_ ( 'SPAM' );
					break;
				case 5 :
					$mailvars ['flagged-as'] = JText::_ ( 'UNAVAILABLE' );
					break;
			}
		
		}
		
		
		$mailvars ['flagcomment'] = $flagdata->comment;
		$mailvars ['flagemail'] = $flagdata->email;
		
		//$emailvariables=$model->getBasicVariables($row->ad,$params);		
		//$emailvariables=array_merge($emailvariables,$advariables);
		

		$mailvars ['receivername'] = $flagdata->ad->aduser->name;
		$mailvars ['receiveremail'] = $flagdata->ad->aduser->email;
		
		$mailvars ['senderemail'] = $flagdata->email;
		
		
		$advariables = $model->getAdVariables ( $row->ad, $params );
		$emailvariables = array_merge ( $advariables, $mailvars );
		
		return $emailvariables;
	
	}
	
	function onAdminCpanelStatDisplay(&$adstats = null, &$params = null) {
		global $option;
		$model = gbaddons ( "flag.model.flag" );
		$flag = $model->getFlagStat ();
		?>
<tr>
	<td><a
		href="<?php
		echo JRoute::_ ( 'index.php?option=' . $option . '&task=addons.flag.admin', false );
		?>"><?php
		echo JText::_ ( 'TOTAL_FLAGGED_ADS' );
		?></a></td>
	<td><?php
		echo ( int ) $flag->flagcount;
		?></td>
</tr>
<?php
	}
}
?>