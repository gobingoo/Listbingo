<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: default.php 2010-01-10 00:57:37 svn $
 * @author gobingoo.com
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
$titlestring=($this->edit)?'Edit Template':'Add Template';
JToolBarHelper::title(JText::_($titlestring), 'template.png');
ListbingoHelper::cpanel('default','home');

JToolBarHelper::divider();
//JToolBarHelper::custom('templates.preview', 'preview.png', 'preview_f2.png', 'Preview', false, false);
JToolBarHelper::custom( 'templates.chooseHTML', 'html.png', 'html_f2.png', 'Edit HTML', false, false );
JToolBarHelper::custom( 'templates.chooseCSS', 'css.png', 'css_f2.png', 'Edit CSS', false, false );



JToolBarHelper::save("templates.save");
JToolBarHelper::apply("templates.apply");
JToolBarHelper::cancel("templates");

gbimport("css.icons");

?>

<form action="index.php" method="post" name="adminForm">

		<?php if($this->ftp): ?>
		<fieldset title="<?php echo JText::_('DESCFTPTITLE'); ?>" class="adminform">
			<legend><?php echo JText::_('DESCFTPTITLE'); ?></legend>

			<?php echo JText::_('DESCFTP'); ?>

			<?php if(JError::isError($this->ftp)): ?>
				<p><?php echo JText::_($this->ftp->message); ?></p>
			<?php endif; ?>

			<table class="adminform nospace">
			<tbody>
			<tr>
				<td width="120">
					<label for="username"><?php echo JText::_('Username'); ?>:</label>
				</td>
				<td>
					<input type="text" id="username" name="username" class="input_box" size="70" value="" />
				</td>
			</tr>
			<tr>
				<td width="120">
					<label for="password"><?php echo JText::_('Password'); ?>:</label>
				</td>
				<td>
					<input type="password" id="password" name="password" class="input_box" size="70" value="" />
				</td>
			</tr>
			</tbody>
			</table>
		</fieldset>
		<?php endif; ?>



<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'Details' ); ?></legend>

<table class="admintable">
	<tr>
		<td valign="top" class="key"><?php echo JText::_( 'Name' ); ?>:</td>
		<td><strong> <?php echo JText::_($this->row->name); ?> </strong></td>
	</tr>
	<tr>
		<td valign="top" class="key"><?php echo JText::_( 'Description' ); ?>:
		</td>
		<td><?php echo JText::_($this->row->description); ?></td>
	</tr>
</table>
</fieldset>




			<!-- <fieldset class="adminform">
				<legend><?php echo JText::_( 'Menu Assignment' ); ?></legend>
				<script type="text/javascript">
					function allselections() {
						var e = document.getElementById('selections');
							e.disabled = true;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = true;
							e.options[i].selected = true;
						}
					}
					function disableselections() {
						var e = document.getElementById('selections');
							e.disabled = true;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = true;
							e.options[i].selected = false;
						}
					}
					function enableselections() {
						var e = document.getElementById('selections');
							e.disabled = false;
						var i = 0;
						var n = e.options.length;
						for (i = 0; i < n; i++) {
							e.options[i].disabled = false;
						}
					}
				</script>
				<table class="admintable" cellspacing="1">
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Menus' ); ?>:
						</td>
						<td>
							<?php if ($this->client->id == 1) {
									echo JText::_('Cannot assign administrator template');
								  } elseif ($this->row->pages == 'all') {
									echo JText::_('Cannot assign default template');
									echo '<input type="hidden" name="default" value="1" />';
								  } elseif ($this->row->pages == 'none') { ?>
							<label for="menus-none"><input id="menus-none" type="radio" name="menus" value="none" onclick="disableselections();" checked="checked" /><?php echo JText::_( 'None' ); ?></label>
							<label for="menus-select"><input id="menus-select" type="radio" name="menus" value="select" onclick="enableselections();" /><?php echo JText::_( 'Select From List' ); ?></label>
							<?php } else { ?>
							<label for="menus-none"><input id="menus-none" type="radio" name="menus" value="none" onclick="disableselections();" /><?php echo JText::_( 'None' ); ?></label>
							<label for="menus-select"><input id="menus-select" type="radio" name="menus" value="select" onclick="enableselections();" checked="checked" /><?php echo JText::_( 'Select From List' ); ?></label>
							<?php } ?>
						</td>
					</tr>
					<?php if ($this->row->pages != 'all' && $this->client->id != 1) : ?>
					<tr>
						<td valign="top" class="key">
							<?php echo JText::_( 'Menu Selection' ); ?>:
						</td>
						<td>
							<?php echo $this->lists['selections']; ?>
							<?php if ($this->row->pages == 'none') { ?>
							<script type="text/javascript">disableselections();</script>
							<?php } ?>
						</td>
					</tr>
					<?php endif; ?>
				</table>
			</fieldset>
			 -->

</div>

<div class="col width-50">
<fieldset class="adminform"><legend><?php echo JText::_( 'Parameters' ); ?></legend>
<?php
$templatefile = $this->row->directory.DS.'params.ini';
$templatepath=JPATH_ROOT.DS."components".DS.$option.DS."templates";

echo is_writable($templatepath.DS.$templatefile) ? JText::sprintf('PARAMSWRITABLE', $templatefile):JText::sprintf('PARAMSUNWRITABLE', $templatefile); ?>
<table class="admintable">
	<tr>
		<td><?php

		if (!is_null($this->params)) 
		{
			echo $this->params->render();
		} 
		else 
		{
			echo '<i>' . JText :: _('No Parameters') . '</i>';
		}
		?></td>
	</tr>
</table>
</fieldset>
</div>
<div class="clr"></div>

<input type="hidden" name="template" value="<?php echo $this->row->directory; ?>" /> 
<input type="hidden" name="option" value="<?php echo $option;?>" /> 
<input type="hidden" name="task" value="" /> 
<?php echo JHTML::_( 'form.token' ); ?>
</form>
