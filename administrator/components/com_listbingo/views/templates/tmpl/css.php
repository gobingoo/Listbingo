<?php
defined('_JEXEC') or die('Restricted access');
JToolBarHelper::title(JText::_('Listbingo - Templates'), 'template.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
JToolBarHelper::addNewX("templates.addCSS","Add");
JToolBarHelper::editList("templates.editCSS");
JToolBarHelper::cancel("templates.cancelTemplate");
JToolBarHelper::deleteList(JText::_('ASK_DELETE'),"templates.removeCSS");
gbimport("css.icons");

?>

<form action="index.php?option=<?php echo $option; ?>" method="post" name="adminForm">

		<table cellpadding="1" cellspacing="1" border="0" width="100%">
		<tr>
			<td width="220">
				<span class="componentheading">&nbsp;</span>
			</td>
		</tr>
		</table>
		<table class="adminlist">
		<tr>
			<th width="5%" align="left">
				<?php echo JText::_( 'Num' ); ?>
			</th>
			<th width="85%" align="left">
				<?php echo $this->dir; ?>
			</th>
			<th width="10%">
				<?php echo JText::_( 'Writable' ); ?>/<?php echo JText::_( 'Unwritable' ); ?>
			</th>
		</tr>
		<?php

		$k = 0;
		for ($i = 0, $n = count($this->files); $i < $n; $i++) {
			$file = & $this->files[$i];
?>
			<tr class="<?php echo 'row'. $k; ?>">
				<td width="5%">
					<input type="radio" id="cb<?php echo $i;?>" name="filename" value="<?php echo htmlspecialchars( $file, ENT_COMPAT, 'UTF-8' ); ?>" onClick="isChecked(this.checked);" />
				</td>
				<td width="85%">
					<?php echo $file; ?>
				</td>
				<td width="10%">
					<?php echo is_writable($this->dir.DS.$file) ? '<font color="green"> '. JText::_( 'Writable' ) .'</font>' : '<font color="red"> '. JText::_( 'Unwritable' ) .'</font>' ?>
				</td>
			</tr>
		<?php

			$k = 1 - $k;
		}
?>
		</table>
		<input type="hidden" name="template" value="<?php echo $this->template; ?>" />
		<input type="hidden" name="option" value="<?php echo $option;?>" />
		<input type="hidden" name="task" value="" />
		<input type="hidden" name="boxchecked" value="0" />
		</form>
