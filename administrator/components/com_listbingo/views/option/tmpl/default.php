<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Option':'Add Option';
JToolBarHelper::title(JText::_($titlestring), 'options.png');
JToolBarHelper::save("options.save");
JToolBarHelper::apply("options.apply");
JToolBarHelper::cancel("options");

gbimport("css.icons");


?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="id" id="id" value="<?php echo $this->row->id?>" />

  <fieldset class="adminform">
  <legend>Option Details</legend>
  <table width="100%" cellpadding="5" class="admintable">
      <tr>
      <td valign="top" class="key"><?php echo JText::_('FIELD');?></td>
      <td><?php echo $this->lists['fields'];?></td>
      <td>&nbsp;</td>
    </tr>
     
    <tr>
      <td width="10%"  valign="top" class="key"><?php echo JText::_('TITLE');?></td>
      <td width="40%" ><input name="title" type="text" class="inputbox" id="title" value="<?php echo $this->row->title?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="10%"  valign="top" class="key"><?php echo JText::_('OPTION_VALUE');?></td>
      <td width="40%" ><input name="option_value" type="text" class="inputbox" id="option_value" value="<?php echo $this->row->option_value?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>

    <tr>
    <td valign="top" class="key"><?php echo JText::_('PUBLISHED');?></td>
      <td><?php echo $this->lists['published'];?></td>
      <td>&nbsp;</td>
    </tr>
    
   
  </table>
  </fieldset>
  <input type="hidden" name="option" value="<?php echo $option?>" />
  <input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
  <input type="hidden" name="task" value="options" />
</form>