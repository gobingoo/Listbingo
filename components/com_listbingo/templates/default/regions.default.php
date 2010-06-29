<?php
/**
 * Search layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
if($this->params->get('show_title'))
{
	?>
<div class="componentheading"><?php echo $this->params->get('sitename');?>
</div>
	<?php
}
?>
