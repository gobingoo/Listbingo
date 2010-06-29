<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Region and Location':'Add Region and Location';
JToolBarHelper::title(JText::_($titlestring), 'regions.png');
JToolBarHelper::save("regions.save");
JToolBarHelper::apply("regions.apply");
JToolBarHelper::cancel("regions");

gbimport("css.icons");

$editor=&JFactory::getEditor();

?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="id" id="id" value="<?php echo $this->row->id?>" />
  <fieldset class="adminform">
  <legend>Region/Location Details</legend>
  <table width="100%" cellpadding="5" class="admintable">
    <tr>
      <td width="10%"  valign="top" class="key"><?php echo JText::_('TITLE');?></td>
      <td width="40%" ><input name="title" type="text" class="inputbox" id="title" value="<?php echo $this->row->title?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="key"><?php echo JText::_('ALIAS');?></td>
      <td><input name="alias" type="text" class="inputbox" id="alias" value="<?php echo $this->row->alias?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_('COUNTRY');?></td>
      <td><?php echo $this->lists['countries'];?></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
    <td valign="top" class="key"><?php echo JText::_('PARENT_REGION');?></td>
      <td><?php echo $this->lists['parent'];?></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td valign="top" class="key"><?php echo JText::_('DEFAULT_REGION');?></td>
      <td><?php echo $this->lists['default_region'];?></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_('PUBLISHED');?></td>
      <td><?php echo $this->lists['published'];?></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td colspan="3" align="left" valign="top"><strong><?php echo JText::_('DESCRIPTION');?></strong></td>
    </tr>
    <tr>
      <td colspan="3" valign="top"><?php echo $editor->display('description',$this->row->description,'100%','250','40','5'); ?></td>
    </tr>
  </table>
  </fieldset>
  <input type="hidden" name="option" value="<?php echo $option?>" />
  <input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
  <input type="hidden" name="task" value="regions" />
</form>