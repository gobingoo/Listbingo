<?php
/**
 * Search layout for default template
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
	<!-- <div id="gb_search_title"><?php echo JText::_('WHERE');?></div> -->
	<div class="gb_search_round_corner">		
		<div class="pngFix clear-block" id="gb-search-form">		
			<form onSubmit="checkForm()" name="frmGBSearch" id="frmGBSearch" method="get" action="<?php echo JRoute::_("index.php?option=$option&task=ads.search&Itemid=$listitemid");?>">
			
			<input type="hidden" name="Itemid" value="<?php echo $listitemid;?>" />
			
			<div id="gb_search_keyword">
				<input type="text" value="<?php echo $searchtxt; ?>" name="q" id="q" />
			</div>
			
			<input type="hidden" id="search_from_price" name="search_from_price" value="<?php echo $min;?>" /> 
			<input type="hidden" id="search_to_price" name="search_to_price" value="<?php echo $max;?>" />
			<input type="hidden" id="catid" name="catid" value="" />
				
			<div id="gb_search_submit">
				<div class="gb_submit_round_corner">
				<input type="submit" name="search" id="btnSubmit" value="Search" />
				<input type="hidden" name="task" value="ads.search" />
				<input type="hidden" name="option" value="<?php echo $option;?>" />
				<input type="hidden" name="Itemid" value="<?php echo $listitemid;?>" />
				</div>
			</div>
        <br />
			</form>
		</div>
		
		
		<div id="gb_example"><?php echo JText::_('LOCATION_EXAMPLE');?></div>		
	</div>
</div>