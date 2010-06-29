<?php
/**
 * Advance Search layout for default template
 *
 * @package Gobingoo
 * @subpackage listbingo
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');
global $option, $listitemid;

?>
<script language="javascript" type="text/javascript">
//<!--
var searchexampletxt = "<?php echo JText::_('SEARCH_EXAMPLE');?>";
//-->
</script>

<?php
$this->addJSI('search');

$searchtxt = JRequest::getVar('q');

if($searchtxt=="")
{
	$searchtxt = JText::_('SEARCH_EXAMPLE');
}

$min = JRequest::getVar('search_from_price');
if($min=="")
{
	$min = "min";
}

$max = JRequest::getVar('search_to_price');
if($max=="")
{
	$max = "max";
}
?>


<div id="gb_search_wrapper">
<h3><?php echo JText::_('SEARCH_SLOGAN');?></h3>

<div class="gb_search_round_corner">
<form onSubmit="checkForm()" name="frmGBSearch" id="frmGBSearch" method="get" action="<?php echo JRoute::_("index.php?option=$option&task=ads.search&Itemid=$listitemid");?>">

<div class="mainSearch"><strong><?php echo JText::_("Find");?></strong><br />
<input type="text" name="q" id="q" value="<?php echo $searchtxt;?>"/>
<br />
<?php echo JText::_('LOCATION_EXAMPLE');?>

</div>



<div class="prop_stage"><strong><?php echo JText::_("Categories");?></strong><br />
<?php echo $this->lists['categories'];?>


</div>

<div class="clear"></div>

<div class="price_stage"><strong><?php echo JText::_("Price Range");?></strong><br />

<input type="text" id="search_from_price" name="search_from_price" size="10" value="<?php echo $min;?>" /> 

<input type="text" id="search_to_price" name="search_to_price" size="10" value="<?php echo $max;?>" />
</div>

<div class="searchBtnHolder">
<div class="gb_submit_round_corner">
<input type="submit" name="search" id="btnSubmit" value="Search" />
<input type="hidden" name="task" value="ads.search" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
<input type="hidden" name="Itemid" value="<?php echo $listitemid;?>" />
</div>
</div>
<div class="clear"></div>
                      
</form>
</div>
</div>