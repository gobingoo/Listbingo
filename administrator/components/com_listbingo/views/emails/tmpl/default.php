<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Email Formats'), 'email.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::addNewX("emails.add","Add");
JToolBarHelper::editList("emails.edit");
JToolBarHelper::publishList("emails.publish");
JToolBarHelper::unpublishList("emails.unpublish");

JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"emails.remove");
gbimport("css.icons");

$eventlists=ListbingoHelper::getEventsList();

?>

<form action="index.php" method="post" name="adminForm">
<table width="100%" class="adminlist ">
	<thead>
		<tr>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?=count($this->rows)?>);" /></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('TITLE'), 'title', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('MAIL_TO'), 'mailto', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('EVENT'), 'event', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('PUBLISHED'), 'published', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th nowrap="nowrap" width="10%"><?php echo JHTML::_('grid.sort',   JText::_('ORDER_BY'), 'ordering', @$this->filter->order_dir, @$this->filter->order ); ?>
			<?php echo JHTML::_('grid.order',  $this->rows,'filesave.png','emails.saveorder' ); ?>
			</th>

		</tr>
	</thead>
	<?php
	if(count($this->rows)>0)
	{
		$k=0;
		
		for($i=0, $n=count($this->rows);$i<$n;$i++)
		{
			$ordering=true;
			$row=&$this->rows[$i];
			$checked=JHTML::_('grid.id',$i,$row->id);
			$published=ListbingoHelper::published($row,$i,"emails");
			$link='index.php?option='.$option.'&task=emails.edit&cid[]='.$row->id;
			?>
	<tr class="<?="row$k"?>">
		<td><?php echo $checked;?></td>
		<td><a href="<?php echo $link;?>"><?php echo $row->subject;?></a></td>
		<td>
		<?php 
		switch($row->mailto)
		{
			case 0:
				echo JText::_('ADMINISTRATOR');
				break;
				
			case 1:
				echo JText::_('RECEIVER');
				break;
				
			case 2:
				echo JText::_('SENDER');
				break;
		}
		?>
		</td>
		<td><?php echo !empty($row->event)?$eventlists[$row->event]:'Not Assigned';;?></td>
		<td align="center"><?php echo $published;?></td>
		<td class="order"><span><?php echo $this->pagination->orderUpIcon( $i,true, 'emails.orderup', 'Move Up', true ); ?></span>
		<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'emails.orderdown', 'Move Down', true); ?></span>
		<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?> <input
			type="text" name="order[]" size="5"
			value="<?php echo $row->ordering;?>" <?php echo $disabled ?>
			class="text_area" style="text-align: center" /></td>

	</tr>
	<?php
	$k=1-$k;
		}
	}
	else
	{
		?>
	<tr>
		<td colspan="11"><?php echo JText::_("NO_EMAIL_FORMATS");?></td>
	</tr>
	<?php
	}
	?>
	<tfoot>
		<tr>
			<td colspan="11"><?php echo $this->pagination->getListFooter();?></td>
		</tr>
	</tfoot>
</table>
<input type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="option" value="<?php echo $option?>" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->filter->order; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->filter->order_dir; ?>" /> <input type="hidden"
	name="task" value="emails" /></form>
