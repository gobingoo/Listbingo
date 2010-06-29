<?php
defined('JPATH_BASE') or die();
$adid = JRequest::getInt('adid',0);
$baseurl=JUri::root()."administrator/components/$option/";

$pmswidth = $this->params->get('pms_popup_width',500);
$pmsheight = $this->params->get('pms_popup_height',350);

$pmsrel="";
if($this->params->get('enable_pms_moodalbox'))
{
	$link = JRoute::_("index.php?option=$option&task=addons.pms.front.displayComposeBox&adid=".$adid."&format=raw");	
	
	$pmsrel = "rel = \"moodalbox $pmswidth $pmsheight\"";
}
else
{
	$link = JRoute::_("index.php?option=$option&task=addons.pms.front.displayComposeBox&adid=".$adid);
	$pmsrel = "";
}

?>


<script src="<?php echo $baseurl."js/moodalbox.js"?>"></script>
<script type="text/javascript">
//<!--
_EVAL_SCRIPTS=true;

//-->
</script>
<link href="<?php echo $baseurl."css/moodalbox.css"?>" type="text/css" rel="stylesheet"/>
<li>
<img src="<?php echo $baseurl."addons/pms/images/replyemail.png"?>" />
<a href="<?php echo $link; ?>" <?php echo $pmsrel; ?> title="Reply"><?php echo JText::_('REPLY_EMAIL');?></a>
</li>