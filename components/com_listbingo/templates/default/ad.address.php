<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * Address subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');


if ($this->params->get ( 'enable_field_address1', 0 ) || $this->params->get ( 'enable_field_address2', 0 ))
{
?>
<li>

	<div class="gb_ad_heading"><strong><?php echo JText::_('LOCATION');?></strong>:</div>	
	
	<div class="gb_ad_heading_details">
	
	<strong><?php echo $this->address; ?></strong><br />
		
	<?php 
	if(isset($this->regions))
	{
		echo $this->regions; ?><br/><?php 
	}

	if(isset($this->country))
	{
		echo $this->row->country;
	}
	?>
	</div>
	
	<div class="clear"></div>
	
</li>

<?php 
}
?>