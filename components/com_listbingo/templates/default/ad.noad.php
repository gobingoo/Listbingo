<?php
/**
 * noad layout for default template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
global $option;
$link=JRoute::_("index.php?option=$option&task=frontpage");
$img=JUri::root()."administrator/components/$option/images/no_ad.png";

?>
<div id="roundme" class="gb_round_corner">
<div class="noadimg">
<img src="<?php echo $img;?>"></img>

</div>
<div class="noadinfo">
<?php 
echo JText::_("AD_DOES_NOT_EXIST");
?>
</div>
<div class="noadbrowse">
<?php echo JText::sprintf("BROWSE_HERE",$link);?>
</div>
</div>