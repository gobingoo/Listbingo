<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Addons'), 'plugin.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();

JToolbarHelper::customX("plugins.rebuild","rebuild",'','Rebuild Menus',false);
JToolBarHelper::editList("plugins.edit");
JToolBarHelper::publishList("plugins.publish");
JToolBarHelper::unpublishList("plugins.unpublish");
JToolBarHelper::divider();
JToolBarHelper::addNewX("plugins.add","Install");
JToolBarHelper::deleteList(JText::_('ASK_DELETE_ADDON'),"plugins.remove","Uninstall");
gbimport("css.icons");

?>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" class="adminlist ">
    <thead>
      <tr>
        <th width="20"> <input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($this->rows)?>);" />        </th>
        <th class="title"><?php echo JHTML::_('grid.sort',   'title', 'name', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th width="20%" ><?php echo JHTML::_('grid.sort',   'element', 'element', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th width="20%" ><?php echo JHTML::_('grid.sort',   'group', 'folder', @$this->filter->order_dir, @$this->filter->order ); ?></th>
        
       <th width="10%" ><?php echo JHTML::_('grid.sort',   'Published', 'published', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th nowrap="nowrap" width="10%">
						<?php echo JHTML::_('grid.sort',   'Order by', 'ordering', @$this->filter->order_dir, @$this->filter->order ); ?>
						<?php echo JHTML::_('grid.order',  $this->rows,'filesave.png','plugins.saveorder' ); ?>
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
				$published=ListbingoHelper::published($row,$i,"plugins");
				$link='index.php?option='.$option.'&task=plugins.edit&cid[]='.$row->id;
				?>
    <tr class="<?="row$k"?>">
      <td><?php echo $checked;?></td>
      <td><a href="<?php echo $link;?>"><?php echo $row->name;?></a></td>
        <td><?php echo $row->element; ?></td>
		      
     <td><?php echo $row->folder; ?></td>
      <td><?php echo $published;?></td>
         <td class="order">
						<span><?php echo $this->pagination->orderUpIcon( $i,true, 'plugins.orderup', 'Move Up', true ); ?></span>
						<span><?php echo $this->pagination->orderDownIcon( $i, $n, true, 'plugins.orderdown', 'Move Down', true); ?></span>
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
              <td colspan="11"><?php echo JText::_("NO_ADDONS");?></td>
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
  <input type="hidden" name="task" value="plugins" />
</form>
