<?php

gbimport("gobingoo.currency");

?>

<div id="roundme" class="gb_round_corner">

<div class="gb_form_heading">
<h3><?php echo JText::_('USER_PROFILE');?></h3>
</div>

<div class="gb_userprofile_details"> 

<div class="gb_profile_details">
<div class="gb_profile_details_heading"><?php echo JText::_('NAME');?>:</div> <div class="gb_profile_details_ans"><?php echo $this->profile->name;?></div><br class="clear" />
<?php 
if((int)$this->params->get('show_profile_contact_information',0))
{
	?>
	<div class="gb_profile_details_heading"><?php echo JText::_('EMAIL');?>:</div> <div class="gb_profile_details_ans"><?php echo $this->profile->email;?></div><br class="clear" />
	<div class="gb_profile_details_heading"><?php echo JText::_('LOCATION');?>:</div> <div class="gb_profile_details_ans"><?php echo $this->useraddress;?></div><br class="clear" />
	<?php
}
?>
<div class="gb_profile_details_heading"><?php echo JText::_('MEMBER_SINCE');?>:</div> <div class="gb_profile_details_ans"><?php echo date("M d, Y",strtotime($this->profile->registerDate));?></div><br class="clear" />
<div class="gb_profile_details_heading"><?php echo JText::_('TOTAL_POST');?>:</div> <div class="gb_profile_details_ans"><?php echo (int)$this->profile->totalpost;?></div><br class="clear" />
</div>

<div id="roundme" class="gb_profileimg_round_corner" style="float:right;">
<div class="gb_listing_userimg">
	<img src="<?php echo $this->imgurl;?>" alt="<?php echo $this->profile->name; ?>"/>
</div>
</div>
<br class="clear" />
</div>

</div>

<br class="clear" />

<div id="roundme" class="gb_round_corner">
<div class="gb_form_heading">
<h3><?php echo JText::_('LISTINGS');?></h3>
</div>
<?php
if(count($this->rows)>0)
{

	?>

<table class="gb_simple_list"  cellpadding="0" cellspacing="1" border="0"s>
	<tr>
		<th><?php echo JText::_('SN');?></th>
		<th><?php echo JText::_('TITLE');?></th>
		<th><?php echo JText::_('PRICE');?></th>
		<th><?php echo JText::_('POSTED_ON');?></th>
		<th><?php echo JText::_('EXPIRES_ON');?></th>
	</tr>
	<?php
	if(count($this->rows)>0)
	{
		$k=0;
		$j=0;
		for($i=0, $n=count($this->rows);$i<$n;$i++)
		{
			$ordering=true;
			$row=&$this->rows[$i];
			$checked=JHTML::_('grid.id',$i,$row->id);

			$link='index.php?option='.$option.'&task=categories.edit&cid[]='.$row->id;

			if($row->hasprice==1)
			{
				$currency=new GCurrency($row->price,$row->currencycode,$row->currency,$this->params->get('currency_format'),
				$this->params->get('decimals'),$this->params->get('decimal_separator'),$this->params->get('value_separator'));

			}
			$link = JRoute::_("index.php?option=$option&view=ad&adid=".$row->id);
			?>
	<tr class="row<?php echo $j;?>">
		<td width="5%"><?php echo $i+$this->pagination->limitstart+1;?></td>
		<td width="30%"><a href="<?php echo $link;?>"><?php echo $row->title; ?></a></td>
		<td width="20%"><?php 

		if($row->hasprice==1)
		{

			switch($row->pricetype)
			{
				case 1:
					echo $currency->toString();
					break;

				case 2:
					echo JText::_('FREE');
					break;
				case 3:
					echo JText::_('PRICE_NEGOTIABLE');
					break;

				default:
					echo $currency->toString();
					break;
			}

		}
		else
		{
			echo JText::_('NOT_APPLICABLE');
		}
		?></td>
		<td width="15%"><?php echo ListbingoHelper::getDate($row->created_date,$this->params->get('dateonlyformat'));?></td>
		<td width="15%">
		<?php  

		if(!GHelper::isValidDateTime($row->expiring_date))
		{
			echo JText::_('NEVER_EXPIRE');
		}	
		else
		{
			//echo date("M d, Y",strtotime($row->expiring_date));
			echo ListbingoHelper::getDate($row->expiry_date,$this->params->get('dateonlyformat'),false);
		}
		?>
		</td>
	</tr>

	<?php

	$j=1-$j;

		}
	}

}
else
{
	echo "<td>";
	echo JText::_('NO_CLASSFIEDS');
	echo "</td>";
}
?>
</table>
<div class="gbNextButton">
<?php echo $this->pagination->getPagesLinks();?>

</div>
<br class="clear" />
</div>
