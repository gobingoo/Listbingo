<?php
/**
 * 
 * @package Gobingoo
 * @subpackage Listbingo
 * @author bruce@gobingoo.com
 * @copyright www.gobingoo.com
 * 
 * pms default listing view for admin
 * 
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - PMS'), 'message.png');
GHelper::cpanel('default','home');
JToolBarHelper::divider();
JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"addons.pms.admin.remove");

gbaddons("pms.css.icons");

?>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" class="adminlist ">
    <thead>
      <tr>
        <th width="20"> <input type="checkbox" name="toggle" value="" onclick="checkAll(<?=count($this->rows)?>);" /></th>
        <th class="title"><?php echo JHTML::_('grid.sort',   'Ad Title', 'ad', @$this->filter->order_dir, @$this->filter->order ); ?></th>
        <th class="title"><?php echo JHTML::_('grid.sort',   'Sender', 'message_from', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th class="title" ><?php echo JHTML::_('grid.sort',   'Receiver', 'message_to', @$this->filter->order_dir, @$this->filter->order ); ?></th>
          <!--<th class="title" ><?php echo JHTML::_('grid.sort',   'Subject', 'subject', @$this->filter->order_dir, @$this->filter->order ); ?></th>
       --><th class="title" ><?php echo JHTML::_('grid.sort',   'Date', 'message_date', @$this->filter->order_dir, @$this->filter->order ); ?></th>

      
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
				
				$link='index.php?option='.$option.'&task=addons.pms.admin.view&cid[]='.$row->id;
				?>
    <tr class="<?="row$k"?>">
      <td><?php echo $checked;?></td>
      <td><a href="<?php echo $link; ?>"><?php echo $row->ad; ?></a></td>
      <td><?php echo ($row->message_from)?$row->susername:JText::_('GUEST');?></td>
        <td><?php echo $row->rusername; ?></td>
        <!--<td><?php echo $row->subject; ?></td>
		      
     
      --><td><?php echo date("d M, Y", strtotime($row->message_date));?></td>
        
   
    </tr>
    <?php
				$k=1-$k;
			}
		}
		else
		{
			?>
            <tr>
              <td colspan="5"><?php echo JText::_("NO_PMS");?></td>
              </tr>
            <?php
		}
			?>
    <tfoot>
    <tr>
    <td colspan="6"><?php echo $this->pagination->getListFooter();?></td>
    </tr>
    </tfoot>
  </table>
<input type="hidden" name="boxchecked" value="0" /> <input type="hidden"
	name="option" value="<?php echo $option?>" /> <input type="hidden"
	name="filter_order" value="<?php echo $this->filter->order; ?>" /> <input
	type="hidden" name="filter_order_Dir"
	value="<?php echo $this->filter->order_dir; ?>" /> <input type="hidden"
	name="task" value="addons.pms.admin" />
</form>
