<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: default.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Ads'), 'ad.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::addNewX("ads.add","Add");
JToolBarHelper::editList("ads.edit");
JToolBarHelper::publishList("ads.publish");
JToolBarHelper::unpublishList("ads.unpublish");

JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"ads.remove");
gbimport("css.icons");

global $option;

?>

<form action="index.php" method="post" name="adminForm">

<table>
<tbody><tr>
	<td width="100%">
		<?php echo JText::_('FILTER');?>:
		<input type="text" title="Filter by keyword" onchange="document.adminForm.submit();" class="text_area" value="" id="q" name="q"/>
		<?php echo $this->lists['status'];?>
		<?php echo $this->lists['categories'];?>
		<?php echo $this->lists['countries'];?>
		<button onclick="this.form.submit();"><?php echo JText::_('GO');?></button>
	</td>
	
	<td nowrap="nowrap">
	<?php echo JText::_('NEWLY_ADDED').": ".$this->lists['new'];?>
	</td>

	</tr>
</tbody>
</table>


<table width="100%" class="adminlist ">
	<thead>
		<tr>
			<th width="20"><input type="checkbox" name="toggle" value=""
				onclick="checkAll(<?=count($this->rows)?>);" /></th>
				<th width="5%"><?php echo JHTML::_('grid.sort',   JText::_('ID'), 'a.id', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('TITLE'), 'a.title', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th class="title"><?php echo JHTML::_('grid.sort',   JText::_('ALIAS'), 'a.alias', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('REPLY_TO'), 'a.email', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('CATEGORY'), 'cat.title', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('STATUS'), 'a.status', @$this->filter->order_dir, @$this->filter->order ); ?></th>
			<th nowrap="nowrap" width="10%"><?php echo JHTML::_('grid.sort',   JText::_('ORDER_BY'), 'a.ordering', @$this->filter->order_dir, @$this->filter->order ); ?>
			<?php echo JHTML::_('grid.order',  $this->rows,'filesave.png','ads.saveorder' ); ?>
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
			$status=ListbingoHelper::status($row,$i);
			$link='index.php?option='.$option.'&task=ads.edit&cid[]='.$row->id;
			?>
	<tr class="<?="row$k"?>">
		<td><?php echo $checked;?></td>
		<td><?php echo $row->id; ?></td>
		<td><a href="<?php echo $link;?>"><?php echo $row->title;?></a></td>
		<td><?php echo $row->alias; ?></td>
		<td><?php echo $row->uemail; ?></td>
		<td><?php echo $row->category; ?></td>
		<td align="center"><?php echo $status;?></td>
		<td class="order"><span><?php echo $this->pagination->orderUpIcon( $i,true, 'ads.orderup', 'Move Up', true ); ?></span>
		<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'ads.orderdown', 'Move Down', true); ?></span>
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
		<td colspan="8"><?php echo JText::_("NO_ADS");?></td>
	</tr>
	<?php
	}
	?>
	<tfoot>
		<tr>
			<td colspan="8"><?php echo $this->pagination->getListFooter();?></td>
		</tr>
	</tfoot>
</table>
<input type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="option" value="<?php echo $option?>" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->filter->order; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->filter->order_dir; ?>" /> <input type="hidden"
	name="task" value="ads" /></form>
