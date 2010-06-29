<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring='Edit Addon';
;
JToolBarHelper::title(JText::_($titlestring), 'plugin.png');
JToolBarHelper::save("plugins.save");
JToolBarHelper::apply("plugins.apply");
JToolBarHelper::cancel("plugins");

gbimport("css.icons");

$editor=&JFactory::getEditor();

?>

<form name="adminForm" id="adminForm" action="index.php" method="post">
  <input type="hidden" name="id" id="id" value="<?php echo $this->row->id?>" />
  <div class="col width-60">
  <fieldset class="adminform">
  <legend><?php echo JText::_('ADDON_DETAILS');?></legend>
  <table width="100%" cellpadding="5" class="admintable">
    <tr>
      <td width="10%"  valign="top" class="key"><?php echo JText::_('NAME');?></td>
      <td width="40%" ><input name="name" type="text" class="inputbox" id="title" value="<?php echo $this->row->name?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td valign="top" class="key"><?php echo JText::_('ELEMENT');?></td>
      <td><input name="element" type="text" class="inputbox" id="element" value="<?php echo $this->row->element?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
        <tr>
      <td valign="top" class="key"><?php echo JText::_('FOLDER');?></td>
      <td><input name="folder" type="text" class="inputbox" id="folder" value="<?php echo $this->row->folder?>" size="45"/></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
    <td valign="top" class="key"><?php echo JText::_('PUBLISHED');?></td>
      <td><?php echo $this->lists['published'];?></td>
      <td>&nbsp;</td>
    </tr>
    
    
  </table>
  </fieldset>
  </div>
  <div class="col width-40">
	<fieldset class="adminform">
	<legend><?php echo JText::_( 'Parameters' ); ?></legend>
	<?php
		jimport('joomla.html.pane');
        // TODO: allowAllClose should default true in J!1.6, so remove the array when it does.
		$pane = &JPane::getInstance('sliders', array('allowAllClose' => true));
		echo $pane->startPane('plugin-pane');
		echo $pane->startPanel(JText :: _('Addon Parameters'), 'param-page');
		if($output = $this->params->render('params')) :
			echo $output;
		else :
			echo "<div style=\"text-align: center; padding: 5px; \">".JText::_('There are no parameters for this item')."</div>";
		endif;
		echo $pane->endPanel();

		if ($this->params->getNumParams('advanced')) {
			echo $pane->startPanel(JText :: _('Advanced Parameters'), "advanced-page");
			if($output = $this->params->render('params', 'advanced')) :
				echo $output;
			else :
				echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('There are no advanced parameters for this item')."</div>";
			endif;
			echo $pane->endPanel();
		}

		if ($this->params->getNumParams('legacy')) {
			echo $pane->startPanel(JText :: _('Legacy Parameters'), "legacy-page");
			if($output = $this->params->render('params', 'legacy')) :
				echo $output;
			else :
				echo "<div  style=\"text-align: center; padding: 5px; \">".JText::_('There are no legacy parameters for this item')."</div>";
			endif;
			echo $pane->endPanel();
		}
		echo $pane->endPane();
	?>
	</fieldset>
</div>
<div class="clr"></div>
  <input type="hidden" name="option" value="<?php echo $option?>" />
  <input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
  
  <input type="hidden" name="task" value="plugins" />
</form>