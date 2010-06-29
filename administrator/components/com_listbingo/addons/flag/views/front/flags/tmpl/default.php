<?php
defined('JPATH_BASE') or die();

if(count($this->flaglist))
{
	$i=0;
	?>
<fieldset class="adminform"><legend><?php echo JText::_('FLAG_LIST');?></legend>
<table width="100%" class="adminlist ">
	<thead>
		<tr>
			<th class="title"><?php echo JText::_('SN'); ?></th>
			<th class="title"><?php echo JText::_('FLAGGED_AS'); ?></th>
			<th class="30%"><?php echo JText::_('FLAGGED_BY'); ?></th>
			<th class="30%"><?php echo JText::_('FLAGGED_DATE'); ?></th>
			<th class="30%"><?php echo JText::_('ACTION'); ?></th>
		</tr>
	</thead>
	<?php
	foreach($this->flaglist as $fl)
	{
		$returnurl = base64_encode(JRoute::_('index.php?option='.$option.'&task=ads.edit&cid[]='.$fl->item_id,false));

		$approvelink = JRoute::_('index.php?option='.$option.'&task=addons.flag.admin.approve&cid='.$fl->item_id.'&fid='.$fl->id.'&returnurl='.$returnurl,false);
		$unapprovelink = JRoute::_('index.php?option='.$option.'&task=addons.flag.admin.unapprove&cid='.$fl->item_id.'&fid='.$fl->id.'&returnurl='.$returnurl,false);

		$i++;
		?>
	<tr>
		<td width="5%"><?php echo $i; ?></td>
		<td width="30%" valign="top" class="key"><?php 
		switch($fl->flag_id)
		{
			case 1:
				echo JText::_('MISCATEGORIZED');
				break;
			case 2:
				echo JText::_('FRAUD');
				break;
			case 3:
				echo JText::_('ILLEGAL');
				break;
			case 4:
				echo JText::_('SPAM');
				break;
			case 5:
				echo JText::_('UNAVAILABLE');
				break;
		}
		?></td>
		<td><?php 
		if($fl->user_id)
		{
			echo $fl->username;
		}
		else
		{
			echo $fl->email." (".JText::_('GUEST').") ";
		}
		?></td>
		<td><?php echo date("d M Y",strtotime($fl->flag_date));?></td>
		<td><a href="<?php echo $approvelink;?>"><?php echo JText::_('APPROVE');?></a>
		&nbsp;|&nbsp; <a href="<?php echo $unapprovelink;?>"><?php echo JText::_('UNAPPROVE');?></a>
		</td>

	</tr>
	<?php
	}
	?>
</table>
</fieldset>
	<?php

}
?>



