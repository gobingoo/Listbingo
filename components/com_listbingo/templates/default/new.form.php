<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * post new ad subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */

defined ( '_JEXEC' ) or die ( 'Restricted access' );

//$mainframe =& JFactory::getApplication();
global $mainframe, $option, $listitemid;

$editor = &JFactory::getEditor ();
$this->addCSS ( 'moodalbox' );

$this->addCSS ( 'mootabs' );
$this->addJSI ( 'mootabs' );

$adminbaseurl = JUri::root () . "administrator/components/$option/";
$document = JFactory::getDocument ();
if ($this->row->id) {
	$document->addStyleSheet ( $adminbaseurl . "css/moodalbox.css" );
}

$managelink = JRoute::_ ( 'index.php?option=' . $option . '&task=ads.images&adid=' . $this->row->id . '&format=raw' );

?>
<script src="<?php
echo $adminbaseurl . "js/moodalbox.js"?>"
	type="text/javascript"></script>


<script language="javascript" type="text/javascript">
//<!--
_EVAL_SCRIPTS=true;
var pricetypecat = new Array;

<?
if($this->params->get('enable_field_price',0))
{
	if (count ( $this->pricetypecategories ) > 0) {
		
		foreach ( $this->pricetypecategories as $pt ) {
			echo "pricetypecat[" . $pt->id . "] = $pt->hasprice;\n\t\t";
		}
	}
}
?>

var catid = <?php
echo JRequest::getInt ( 'catid', 0 );
?>;
var pricetype = <?php
echo isset ( $this->row->pricetype ) ? $this->row->pricetype : 0;
?>;

//-->
</script>

<?php
$this->addJSI ( "adpricetype" );
?>



<div id="gbjosFormHolder">
<form
	action="<?php
	echo JRoute::_ ( 'index.php?option=' . $option . '&task=ads.save&Itemid=' . $listitemid );
	?>"
	method="post" id="josForm" name="josForm" class="form-validate"
	enctype="multipart/form-data"><input type="hidden" name="id" id="id"
	value="<?php
	echo $this->row->id?>" /> <input type="hidden"
	name="catid" id="catid" value="<?php
	echo JRequest::getInt ( 'catid' );
	?>" />
<input type="hidden" name="country_id" id="country_id"
	value="<?php
	echo $this->country;
	?>" /> <input type="hidden"
	name="region_id" id="region_id" value="<?php
	echo $this->region;
	?>" />
<input type="hidden" name="hasprice" id="hasprice"
	value="<?php
	echo $this->catinfo->hasprice;
	?>" />
<?php
echo $this->locationtext;
?>	
	
<div><label id="titlemsg" for="title"><?php
echo JText::_ ( 'TITLE' );
?></label>
<input name="title" type="text" class="inputtextbox required" id="title"
	value="<?php
	echo $this->row->title;
	?>" /> <span
	class="gb_required_field">&nbsp;*&nbsp;</span></div>
<?php
if ($this->params->get ( 'enable_field_price', 0 )) {
	?>

<div id="pricetype-container"><label id="pricetypemsg" for="pricetype"><?php
	echo JText::_ ( 'PRICE_TYPE' );
	?></label>
<div class="gb_pricetype_holder"><?php
	echo $this->lists ['pricetype'];
	?>

<span class="gb_required_field">&nbsp;*&nbsp;</span></div>
<div class="clear"></div>
</div>

<?php
	if ($this->row->pricetype > 1) {
		$priceclass = "style=\"display:none;\"";
	} else {
		$priceclass = "";
	}
	?>

<div id="price-container" <?php
	echo $priceclass;
	?>><label id="pricemsg"
	for="price"><?php
	echo JText::_ ( 'PRICE' );
	?></label>
<?php
	echo $this->lists ['price'];
	?>

<span class="gb_required_field">&nbsp;*&nbsp;</span> <br />
<small>(<?php
	echo JText::_ ( 'PRICE_INFO' );
	?>)</small></div>
<?php
}
?>
<div><?php

if (($this->params->get ( 'enableimages' ))) {
	if ($this->max_image_upload_limit > count ( $this->row->images )) {
		?> <label id="imagemsg" for="image"><?php
		echo JText::_ ( 'IMAGE' );
		?>
	<br />
<span id="image_infobar"><?php
		echo '<span id="imgcounter">' . (count ( $this->row->images ) + 1) . "</span>/" . $this->max_image_upload_limit . " " . JText::_ ( 'IMAGES' );
		?></span> </label>
<div class="uploadWrapper">
<div id="imageUploader">

<div id="img_0" class="imageholder">
<div class="image_upload_input"><input type="file" name="images[]"
	class="inputtextbox" /></div>
<br class="clear" />
</div>


</div>

<div class="addmoreImages"><a id="addb" href="javascript:void(0);"><?php
		echo JText::_ ( "ADD_MORE_IMAGES" );
		?></a>
</div>

<?php
		if ($this->row->id) {
			?>
<a class="gb_gallery" href="<?php
			echo $managelink;
			?>"
	rel="moodalbox 650 400" title="Manage Images"><?php
			echo JText::_ ( 'MANAGE_IMAGES' );
			?></a>
	<?php
		}
		?>

</div>



<?php
	} else {
		echo JText::_ ( 'Image upload limit exceed' );
	}
}
?>
</div>

<?php
if ($this->params->get ( 'enable_field_address1', 0 )) {
	$adrequired = "";
	if ($this->params->get ( 'required_field_address1', 0 )) {
		$adrequired = "required";
	}
	?>
<div><label id="address1msg" for="address1"><?php
	echo JText::_ ( 'ADDRESS1' );
	?></label>
<input type="text" name="address1"
	class="inputtextbox <?php
	echo $adrequired;
	?>" id="address1"
	value="<?php
	echo $this->row->address1;
	?>" />
<?php
	if ($this->params->get ( 'required_field_address1', 0 )) {
		?>
<span class="gb_required_field">&nbsp;*&nbsp;</span>
<?php
	}
	?>
<br />
<label>&nbsp;</label><small>(<?php
	echo JText::_ ( 'Example: 72 Spring Street, 11th Floor' );
	?>)</small>
</div>
<br class="clear" />
<?php
}
?>


<?php
if ($this->params->get ( 'enable_field_address2', 0 )) {
	$ad2required = "";
	if ($this->params->get ( 'required_field_address2', 0 )) {
		$ad2required = "required";
	}
	?>

<div><label id="address2msg" for="address2"><?php
	echo JText::_ ( 'ADDRESS2' );
	?></label>
<input type="text" name="address2"
	class="inputtextbox <?php
	echo $$ad2required;
	?>" id="address2"
	value="<?php
	echo $this->row->address2;
	?>" />
	<?php
	if ($this->params->get ( 'required_field_address2', 0 )) {
		?>
<span class="gb_required_field">&nbsp;*&nbsp;</span>
<?php
	}
	?>
</div>
<br class="clear" />
<?php
}
?>

<?php
if ($this->params->get ( 'enable_field_zipcode', 0 )) {
	$ziprequired = "";
	if ($this->params->get ( 'required_field_zipcode', 0 )) {
		$ziprequired = "required";
	}
	?>


<div><label id="zipcodemsg" for="zipcode"><?php
	echo JText::_ ( 'ZIP_POSTAL' );
	?></label>
<input name="zipcode" type="text"
	class="inputtextbox <?php
	echo $ziprequired;
	?>" id="zipcode"
	value="<?php
	echo $this->row->zipcode;
	?>" />
	<?php
	if ($this->params->get ( 'required_field_zipcode', 0 )) {
		?>
<span class="gb_required_field">&nbsp;*&nbsp;</span>
<?php
	}
	?>
</div>
<br class="clear" />
<?php
}
?>
<?php

GApplication::triggerEvent ( "onAdInput", array (&$this->row, &$this->params, &$this->user ) );
?>


<div><label id="descriptionmsg" for="description"><?php
echo JText::_ ( 'DESCRIPTION' );
?></label>
<span class="gb_required_field"
	style="float: right; padding-right: 150px;">&nbsp;*&nbsp;</span>
<?php
echo $editor->display ( 'description', $this->row->description, '51%', '50', '30', '5', false, array ("mode" => "simple" ) );
?>

</div>
<br class="clear" />

<?php
$this->render ( 'ajaxinput.default', array ('extrafields' => $this->extrafields ) );
?>

<?php
if (isset ( $this->lists ['showcontact'] )) {
	?>
	<div class="radiobox"><label id="lblShowcontact" for="showcontact"><?php
	echo JText::_ ( 'Show Contact' );
	?></label>
<div class="holder">
<?php
	echo $this->lists ['showcontact'];
	?></div>
</div>
	<?php
}
?>

<?php
if ($this->params->get ( 'enable_field_tags' )) {
	$tagrequired = "";
	if ($this->params->get ( 'required_field_tags', 0 )) {
		$tagrequired = "required";
	}
	?>
<div><label id="tagsmsg" for="tags"><?php
	echo JText::_ ( 'TAGS' );
	?></label>
<textarea name="tags" id="tags"
	class="inputtextarea <?php
	echo $tagrequired;
	?>"><?php
	echo $this->row->tags;
	?></textarea>
<?php
	if ($this->params->get ( 'required_field_tags', 0 )) {
		?>
<span class="gb_required_field">&nbsp;*&nbsp;</span>
<?php
	}
	?>
</div>
	<?php
}
if ($this->params->get ( 'enable_field_metadesc' )) {
	$descrequired = "";
	if ($this->params->get ( 'required_field_metadesc', 0 )) {
		$descrequired = "required";
	}
	?>

<div><label id="metadescmsg" for="metadesc"> <?php
	echo JText::_ ( 'EXCERPTS' );
	?><br />
<small><?php
	echo JText::_ ( 'EXCERPT_INFO' );
	?></small> </label> <textarea
	name="metadesc" id="metadesc"
	class="inputtextarea <?php
	echo $descrequired;
	?>"><?php
	echo $this->row->metadesc;
	?></textarea>
	<?php
	if ($this->params->get ( 'required_field_metadesc', 0 )) {
		?>
<span class="gb_required_field">&nbsp;*&nbsp;</span>
<?php
	}
	?>
</div>
	<?php
}

if ($this->params->get ( 'show_expiry_date' )) {
	?>
	<div><label id="tagsmsg" for="tags"><?php
	echo JText::_ ( 'EXPIRY_DATE' );
	?></label>
	<?php
	echo JHTML::_ ( 'calendar', $this->row->expiry_date, "expiry_date", 'expiry_date', '%Y-%m-%d', array ('class' => 'inputtextbox ', 'maxlength' => '19' ) );
	?>
	</div>
	<?php
}

GApplication::triggerEvent ( "onAfterFormDisplay", array (&$this->row, &$this->params ) );
?>
<br />
<div><?php
echo JText::sprintf ( 'REQUIRED_INFO', "<span  class=\"gb_required_field\">&nbsp;*&nbsp;</span>" );
?></div>
<br />
<div class="gb_button_wrapper">


<button class="gbButton validate" type="submit"><?php
echo JText::_ ( 'SAVE' );
?></button>
<?php
$cancellink = JRoute::_ ( "index.php?option=$option&task=categories&Itemid=$listitemid&cancel=1&time=" . rand ( 100000, 999999 ) );
?>
<button type="button"
	onclick="location.href='<?php
	echo $cancellink;
	?>';" class="gbButton"><?php
	echo JText::_ ( 'CANCEL' );
	?></button>
</div>
<input type="hidden" name="edit" value="<?php
echo $this->edit;
?>" /> <input
	type="hidden" name="option" value="<?php
	echo $option?>" /> <input
	type="hidden" name="task" value="ads.save" /> <?php
	echo JHTML::_ ( 'form.token' );
	?>

</form>
</div>
