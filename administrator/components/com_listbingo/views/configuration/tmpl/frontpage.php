<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
$layouts=array();

$layouts[]=JHTML::_('select.option', 'search', JText::_('Search Layout'), 'id', 'title');
$layouts[]=JHTML::_('select.option', 'advsearch', JText::_('Advance Search Layout'), 'id', 'title');

$layouts[]=JHTML::_('select.option', 'category', JText::_('Category  Layout'), 'id', 'title');
$layouts[]=JHTML::_('select.option', 'listing', JText::_('Listing Layout'), 'id', 'title');

$layoutordering=array();

$layoutordering[]=JHTML::_('select.option', 'featured', JText::_('Featured'), 'id', 'title');
$layoutordering[]=JHTML::_('select.option', 'latest', JText::_('Latest'), 'id', 'title');
$layoutordering[]=JHTML::_('select.option', 'price', JText::_('Price'), 'id', 'title');
$layoutordering[]=JHTML::_('select.option', 'ordering', JText::_('Ordering'), 'id', 'title');


?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Frontpage' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			
			<tr>
			<td  class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Frontpage Layout' ); ?>::<?php echo JText::_('Select frontpage layout'); ?>">
				<?php echo JText::_( 'Frontpage Layout' ); ?> </span></td>
			<td valign="top">
			<?php echo JHTML::_('select.genericlist',  $layouts, 'config[frontpage_layout]', 'class="inputbox"', 'id', 'title',  $this->config->get('frontpage_layout') );;?></td>
		</tr>
	<tr>
			<td  class="key"><span class="hasTip"
				title="<?php echo JText::_( 'List Layout Ordering' ); ?>::<?php echo JText::_('Select list layout ordering'); ?>">
				<?php echo JText::_( 'List Layout ordering' ); ?> </span></td>
			<td valign="top">
			<?php echo JHTML::_('select.genericlist',  $layoutordering, 'config[layout_ordering]', 'class="inputbox"', 'id', 'title',  $this->config->get('layout_ordering') );;?></td>
		</tr>
		</tbody>
	</table>
</fieldset>