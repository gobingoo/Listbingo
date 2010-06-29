<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Templates'), 'template.png');

JToolBarHelper::save("templates.saveCSS");
JToolBarHelper::apply("templates.applyCSS");
JToolBarHelper::cancel("templates.cancelCSS");

gbimport("css.icons");


$css_path = $this->templatepath.DS.$this->template.DS.'css'.DS.$this->filename;

?>
<form action="index.php" method="post" name="adminForm">

<table class="adminform">
<tr>
	<th>
		<?php echo $css_path; ?>
	</th>
</tr>

<tr>
	<td>
		<label><?php echo JText::_('Filename');?></label>
		<input type="text" name="filename" value="<?php echo $this->filename; ?>" <?php if($this->edit){ ?>READONLY="READONLY"<?php }?> />
		<?php echo JText::_('Filename with extension ending with .css');?>
	</td>
</tr>

<tr>
	<td>
		<textarea style="width:100%;height:500px" cols="110" rows="25" name="filecontent" class="inputbox"><?php echo $this->content; ?></textarea>
	</td>
</tr>
</table>

<input type="hidden" name="template" value="<?php echo $this->template; ?>" />
<input type="hidden" name="edit" value="<?php echo $this->edit; ?>" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="task" value="" />
<?php echo JHTML::_( 'form.token' ); ?>
</form>