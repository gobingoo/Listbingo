<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Extrafields'), 'fields.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::addNewX("fields.add","Add");
JToolBarHelper::editList("fields.edit");
JToolBarHelper::publishList("fields.publish");
JToolBarHelper::unpublishList("fields.unpublish");

JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"fields.remove");
gbimport("css.icons");

?>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" class="adminlist ">
    <thead>
      <tr>
        <th width="20"> <input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($this->rows)?>);" />        </th>
        <th class="title"><?php echo JHTML::_('grid.sort',   JText::_('TITLE'), 'title', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th  width="5%"><?php echo JHTML::_('grid.sort',  JText::_('TYPE'), 'type', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th  ><?php echo JHTML::_('grid.sort',   JText::_('DEFAULT_VALUE'), 'default_value', @$this->filter->order_dir, @$this->filter->order ); ?></th>
          <th width="5%" ><?php echo JHTML::_('grid.sort',   JText::_('REQUIRED'), 'required', @$this->filter->order_dir, @$this->filter->order ); ?></th>
            <th width="10%"><?php echo JHTML::_('grid.sort',   JText::_('SHOW_IN_SUMMARY'), 'view_in_summary', @$this->filter->order_dir, @$this->filter->order ); ?></th>
            <th  width="10%" ><?php echo JHTML::_('grid.sort',   JText::_('SHOW_IN_DETAIL'), 'view_in_detail', @$this->filter->order_dir, @$this->filter->order ); ?></th>
            <th  width="10%" ><?php echo JHTML::_('grid.sort',   JText::_('ACCESS'), 'access', @$this->filter->order_dir, @$this->filter->order ); ?></th>
       <th width="10%" ><?php echo JHTML::_('grid.sort',  JText::_('PUBLISHED'), 'published', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th nowrap="nowrap" width="10%">
						<?php echo JHTML::_('grid.sort',   JText::_('ORDER_BY'), 'ordering', @$this->filter->order_dir, @$this->filter->order ); ?>
						<?php echo JHTML::_('grid.order',  $this->rows,'filesave.png','fields.saveorder' ); ?>
		</th>
      
      </tr>
    </thead>
    <?php
		if(count($this->rows)>0)
		{
			$k=0;
			$reqField=new stdClass();
			$reqField->field="required";
			$reqField->taskprefix="fields";
			$reqField->task1="unrequire";
			$reqField->alt1="Rrequired";
			$reqField->task2="require";
			$reqField->alt2="unrequire";
			
			$reqField->action1="Required";
			$reqField->action2="Not Required";
			
			$showinsummary=new stdClass();
			$showinsummary->field="view_in_summary";
			$showinsummary->taskprefix="fields";
			$showinsummary->task1="";
			$showinsummary->alt1="View in Summary";
			$showinsummary->task2="";
			$showinsummary->alt2="Hidden in Summary";			
			$showinsummary->action1="";
			$showinsummary->action2="";
			
			$showindetail=new stdClass();
			$showindetail->field="view_in_detail";
			$showindetail->taskprefix="fields";
			$showindetail->task1="";
			$showindetail->alt1="Show in Detil";
			$showindetail->task2="";
			$showindetail->alt2="Hidden in Detail";			
			$showindetail->action1="";
			$showindetail->action2="";
			
			for($i=0, $n=count($this->rows);$i<$n;$i++)
			{
				$ordering=true;
				$row=&$this->rows[$i];
				$checked=JHTML::_('grid.id',$i,$row->id);
				$published=ListbingoHelper::published($row,$i,"fields");
				$required=ListbingoHelper::tick($row,$i,$reqField,false);
				$summary=ListbingoHelper::tick($row,$i,$showinsummary,false);
				$detail=ListbingoHelper::tick($row,$i,$showindetail,false);
				$link='index.php?option='.$option.'&task=fields.edit&cid[]='.$row->id;
			//	$access 	= JHTML::_('grid.access',   $row, $i );
				
				?>
    <tr class="<?="row$k"?>">
      <td><?php echo $checked;?></td>
      <td><a href="<?php echo $link;?>"><?php echo $row->title;?></a></td>
      <td><?php echo $row->type; ?></td>
      <td><?php echo $row->default_value; ?></td>
      <td><?php echo $required; ?></td>
      <td><?php echo $summary; ?></td>
      <td><?php echo $detail; ?></td>
       <td><?php echo $row->groupname; ?></td>
      <td><?php echo $published;?></td>
      <td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i,true, 'fields.orderup', 'Move Up', true ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'fields.orderdown', 'Move Down', true); ?></span>
						<?php $disabled = $ordering ?  '' : 'disabled="disabled"'; ?>
						<input type="text" name="order[]" size="5" value="<?php echo $row->ordering;?>" <?php echo $disabled ?> class="text_area" style="text-align: center" />
    </td>
   
    </tr>
    <?php
				$k=1-$k;
			}
		}
		else
		{
			?>
            <tr>
              <td colspan="11"><?php echo JText::_("NO_FIELDS");?></td>
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
  <input type="hidden" name="boxchecked" value="0" />
  <input type="hidden" name="option" value="<?php echo $option?>" />

   <input type="hidden" name="filter_order" value="<?php echo $this->filter->order; ?>" />
  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->filter->order_dir; ?>" />
  <input type="hidden" name="task" value="fields" />
</form>
