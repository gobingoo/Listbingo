<?php // no direct access
defined('_JEXEC') or die('Restricted access');
$basepathmodule=JUri::root()."modules/mod_lbsearch/";
$document = JFactory::getDocument();
$document->addStyleSheet($basepathmodule."css/default.css");

$searchtxt = JRequest::getVar('q');
global $option, $listitemid;

if($searchtxt=="")
{
	$searchtxt = JText::_('SEARCH_EXAMPLE');
}
?>
<script language="javascript" type="text/javascript">
<!--

var searchexampletxt = '<?php echo $searchtxt; ?>';

Window.onDomReady(function(){
	$('q').addEvent('focus',function(){
		if(this.value=='<?php echo JText::_('SEARCH_EXAMPLE');?>')
		{
this.value="";
			}
		});
	
	$('q').addEvent('blur',function(){
		if(this.value=='')
		{
this.value="<?php echo JText::_('SEARCH_EXAMPLE');?>";
			}
		});
       
    $('btnSubmit').addEvent('click', function(){
    	var searchtxt = document.frmGBSearch.q.value;
    	if(searchtxt == searchexampletxt)
    	{
    		document.frmGBSearch.q.value = "";
    	}
    	frm=document.frmGBSearch;
		frm.submit();
    });
});



-->
</script>

<div id="gb_search_wrapper">	
	<h3><?php echo JText::_('SEARCH_SLOGAN');?></h3>
	<!-- <div id="gb_search_title"><?php echo JText::_('WHERE');?></div> -->
	<div class="gb_search_round_corner">		
		<div class="pngFix clear-block" id="gb-search-form">		
			<form name="frmGBSearch" id="frmGBSearch" method="get" action="<?php echo JRoute::_("index.php?option=com_listbingo&task=ads.search&Itemid=$listitemid");?>">
			<input type="hidden" name="option" value="com_listbingo">
			<input type="hidden" name="task" value="ads.search" />
			<input type="hidden" name="Itemid" value="<?php echo $listitemid;?>" />
		
			
			<div id="gb_search_keyword">
				<input type="text" value="<?php echo $searchtxt; ?>" name="q" id="q" />
			</div>
				
			<div id="gb_search_submit">
				<div class="gb_submit_round_corner">
				<input type="button" name="search" id="btnSubmit" value="Search"/>
				</div>
			</div>
        <br />
			</form>
		</div>
		
		
		<div id="gb_example"><?php echo JText::_('LOCATION_EXAMPLE');?></div>		
	</div>
</div>
<br class="clear" />