<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Templates'), 'template.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::custom( 'templates.makeDefault', 'default.png', 'default_f2.png', 'Default', false, false );
JToolBarHelper::addNewX("templates.install","Install");
JToolBarHelper::deleteList(JText::_('ASK_DELETE_TEMPLATE'),"templates.remove","Uninstall");
gbimport("css.icons");

?>

<form action="index.php" method="post" name="adminForm">
  <table width="100%" class="adminlist ">
    <thead>
      <tr>
        <th width="20"> #     </th>
        <th class="title"><?php echo JHTML::_('grid.sort',   'name', 'name', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th><?php echo JHTML::_('grid.sort',   'default', 'default', @$this->filter->order_dir, @$this->filter->order ); ?></th>
         <th width="10%" ><?php echo JHTML::_('grid.sort',   'Version', 'version', @$this->filter->order_dir, @$this->filter->order ); ?></th>
           <th width="10%" ><?php echo JHTML::_('grid.sort',   'Date', 'date', @$this->filter->order_dir, @$this->filter->order ); ?></th>      
         <th width="10%" ><?php echo JHTML::_('grid.sort',   'Author', 'author', @$this->filter->order_dir, @$this->filter->order ); ?></th>
      
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
				
				$link='index.php?option='.$option.'&task=templates.edit&cid[]='.$row->directory;
				?>
    <tr class="<?="row$k"?>">
      <td><input type="radio" name="default_template" value="<?php echo $row->directory?>" onclick="isChecked(this.checked);"/></td>
      <td><a href="<?php echo $link;?>"><?php echo $row->name;?></a></td>
        <td>        
	        <?php
	
			if ($row->directory == $this->default) 
			{
			?>
			<img src="templates/khepri/images/menu/icon-16-default.png" alt="<?php echo JText::_( 'Default' ); ?>" />
			<?php
			
			} else {
			?>
			&nbsp;
			<?php
			
			}
			?>
        </td>
       <td><?php echo $row->version; ?></td>
         <td><?php echo $row->creationdate; ?></td>
           <td><?php echo $row->author; ?></td>
   
    </tr>
    <?php
				$k=1-$k;
			}
		}
		else
		{
			?>
            <tr>
              <td colspan="11"><?php echo JText::_("NO_TEMPLATES");?></td>
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
	<input type="hidden" name="option" value="<?php echo $option;?>" />
	<input type="hidden" name="client" value="<?php echo $this->client->id;?>" />
	<input type="hidden" name="task" value="" />
	<input type="hidden" name="boxchecked" value="0" />
</form>
