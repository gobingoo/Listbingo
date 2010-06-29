<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Countries'), 'country.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::addNewX("countries.add","Add");
JToolBarHelper::editList("countries.edit");
JToolBarHelper::publishList("countries.publish");
JToolBarHelper::unpublishList("countries.unpublish");
JToolBarHelper::custom( 'countries.makeDefault', 'default.png', 'default_f2.png', 'Default', false, false );

JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"countries.remove");
gbimport("css.icons");

?>

<form action="index.php" method="post" name="adminForm">

<table>
	<tbody>
		<tr>
			<td width="100%"><?php echo JText::_('FILTER');?>: <input type="text"
				title="Filter by Title " onchange="document.adminForm.submit();"
				class="text_area" value="<?php echo JRequest::getVar('keyword','');?>" id="keyword" name="keyword" />
				<?php echo $this->lists['published'];?>
			<button onclick="this.form.submit();"><?php echo JText::_('GO');?></button>
			</td>
		</tr>
	</tbody>
</table>


<table width="100%" class="adminlist ">
	<thead>
		<tr>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?=count($this->rows)?>);" /></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('TITLE'), 'title', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('CODE'), 'code', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('ZIP_CODE'), 'zipcode', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('DEFAULT_COUNTRY'), 'default_country', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('PUBLISHED'), 'published', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th nowrap="nowrap" width="10%"><?php echo JHTML::_('grid.sort',   JText::_('ORDER_BY'), 'ordering', @$this->filter->order_dir, @$this->filter->order ); ?>
			<?php echo JHTML::_('grid.order',  $this->rows,'filesave.png','countries.saveorder' ); ?>
			</th>

		</tr>
	</thead>
	<?php
	if(count($this->rows)>0)
	{
		$k=0;
		$reqField=new stdClass();
		$reqField->field="default_country";
		$reqField->taskprefix="countries";
		$reqField->task1="";
		$reqField->alt1="Default country";
		$reqField->task2="";
		$reqField->alt2="Not Default country";
			
		$reqField->action1="Default Country";
		$reqField->action2="Not Default country";
		for($i=0, $n=count($this->rows);$i<$n;$i++)
		{
			$ordering=true;
			$row=&$this->rows[$i];
			$checked=JHTML::_('grid.id',$i,$row->id);
			$published=ListbingoHelper::published($row,$i,"countries");
			$default_country=ListbingoHelper::tick($row,$i,$reqField,false);
			$link='index.php?option='.$option.'&task=countries.edit&cid[]='.$row->id;
			?>
	<tr class="<?="row$k"?>">
		<td><?php echo $checked;?></td>
		<td><a href="<?php echo $link;?>"><?php echo $row->title;?></a></td>
		<td><?php echo $row->code; ?></td>
		<td><?php echo $row->zipcode; ?></td>
		<td align="center"><?php echo $default_country;?></td>

		<td align="center"><?php echo $published;?></td>
		<td class="order"><span><?php echo $this->pagination->orderUpIcon( $i,true, 'countries.orderup', 'Move Up', true ); ?></span>
		<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'countries.orderdown', 'Move Down', true); ?></span>
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
		<td colspan="11"><?php echo JText::_("NO_COUNTRIES");?></td>
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
	name="task" value="countries" /></form>
