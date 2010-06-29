<?php
defined('JPATH_BASE') or die();
$this->user->linkfrom = 1;
gbaddons("pms.css.layout");
global $option, $listitemid;
?>

<script type="text/javascript">
//<!--

window.addEvent('domready',function(){
	
	$('delBtn').addEvent('click',function(){	
			
		var checkedCounter = document.getElementById('boxchecked').value;
		
		if(checkedCounter==0)
		{
			alert('<?php echo JText::_("SELECT_ATLEAST_ONE_MESSAGE");?>');
		}
		else
		{
			if(confirm("<?php echo JText::_('Are you sure you want to continue?');?>"))
			{
			frm=document.adminForm;
			frm.task.value='addons.pms.my.remove';
			frm.submit();
			}
		}
		 
	
	});
	
});

//-->
</script>

<div id="roundme" class="gb_pms_round_corner">
<div class="gb_pms_detail_wrapper">
<span><input type="button" name="delBtn" id="delBtn" value="Delete" /></span>
<h2><?php echo JText::_("MY_MESSAGES")?></h2>
</div>
<form action="index.php" method="post" name="adminForm">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="gb_pms_listing">

	<tr>
		<th width="5%"><input type="checkbox" name="toggle" value=""
			onclick="checkAll(<?=count($this->rows)?>);" /></th>
		<th><?php echo JText::_('SUBJECT'); ?></th>
		<th width="20%"><?php echo JText::_('SENDER'); ?></th>
		
		
		<th width="20%"><?php echo JText::_('MESSAGE_DATE'); ?></th>
	</tr>
	<?php
	if(count($this->rows))
	{
		$i=0;
		$k=0;
		foreach($this->rows as $m)
		{
			$class="";
			$checked=JHTML::_('grid.id',$i,$m->id);
			if($m->status)
			{
				$class = "";	
			}
			else
			{
				$class = "unread";
			}
			
			$link = JRoute::_("index.php?option=$option&task=addons.pms.my.view&mid=$m->id&time=".time(),false);
			?>
	<tr class="<?php echo "row$k";?> <?php echo $class;?>">
		<td><?php echo $checked;?></td>
		<td><a href="<?php echo $link; ?>"><?php echo JText::_('INQUIRY_FOR')." ".$m->ad;?></a></td>
		<td><a href="<?php echo $link; ?>"><?php echo $m->contact_name;?></a></td>


		<td><a href="<?php echo $link; ?>"><?php  echo ListbingoHelper::getDate($m->message_date,$this->params);?></a></td>
	</tr>
	<?php
		$i++;
		$k=1-$k;		
		}
		echo $this->pagination->getPagesLinks();
	}
	else
	{
		?>


	<tr>
		<td colspan="4"><strong><?php echo JText::_('NO_MESSAGES'); ?></strong></td>
	
	</tr>
	<?php

	}
	?>
</table>
<input type="hidden" name="boxchecked" value="0" id="boxchecked" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="Itemid" value="<?php echo $listitemid;?>" />
<input type="hidden"name="task" value="" /></form>


</div>

