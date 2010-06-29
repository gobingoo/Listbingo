<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Country':'Add Country';
JToolBarHelper::title(JText::_($titlestring), 'country.png');
JToolBarHelper::save("countries.save");
JToolBarHelper::apply("countries.apply");
JToolBarHelper::cancel("countries");

gbimport("css.icons");

$editor=&JFactory::getEditor();

?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="id" id="id" value="<?php echo $this->row->id?>" />
  <fieldset class="adminform">
  <legend>Country Details</legend>
  <table width="100%" cellpadding="5" class="admintable">
    <tr>
      <td width="10%"  valign="top" class="key"><?php echo JText::_('TITLE');?></td>
      <td width="40%" ><input name="title" type="text" class="inputbox" id="title" value="<?php echo $this->row->title?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="key"><?php echo JText::_('SHORT_CODE');?></td>
      <td><input name="code" type="text" class="inputbox" id="code" value="<?php echo $this->row->code?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
      <td valign="top" class="key"><?php echo JText::_('ZIP_CODE');?></td>
      <td><input name="zipcode" type="text" class="inputbox" id="zipcode" value="<?php echo $this->row->zipcode?>" size="10" maxlength="5"/></td>
      <td>&nbsp;</td>
    </tr>
    
    <tr>
    <td valign="top" class="key"><?php echo JText::_('DEFAULT_COUNTRY');?></td>
      <td><?php echo $this->lists['default'];?></td>
      <td>&nbsp;</td>
    </tr>
     <tr>
      <td valign="top" class="key"><?php echo JText::_('CURRENCY');?></td>
      <td><input name="currency" type="text" class="inputbox" id="currency" value="<?php echo $this->row->currency;?>" size="10"/></td>
      <td>&nbsp;</td>
    </tr>
     <tr>
      <td valign="top" class="key"><?php echo JText::_('CURRENCY_SYMBOL');?></td>
      <td><input name="currency_symbol" type="text" class="inputbox" id="currency_symbol" value="<?php echo $this->row->currency_symbol?>" size="10"/></td>
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
  <input type="hidden" name="task" value="countries" />
</form>