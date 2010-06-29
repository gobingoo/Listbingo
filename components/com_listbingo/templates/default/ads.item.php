<?php
global $option;
$editlink = 'index.php?option=' . $option . '&task=ads.edit&catid=' . $this->row->category_id . '&adid=' . $this->row->id;
$this->params->get ( 'listlayout_thumbnail' );
$suffix = $this->params->get ( $this->params->get ( 'listlayout_thumbnail' ) );
$link = JRoute::_ ( "index.php?option=$option&task=ads.view&adid=" . $this->row->id );
$noimage = JUri::root () . $this->params->get ( 'path_default_profile_noimage' );
$baseurl = JUri::root ();
$adminbaseurl = JUri::root () . "administrator/components/$option/images/";
$basepath = JPATH_ROOT . DS;

$currency = new GCurrency ( $this->row->price, $this->row->currencycode, $this->row->currency, $this->params->get ( 'currency_format' ), $this->params->get ( 'decimals' ), $this->params->get ( 'decimal_separator' ), $this->params->get ( 'value_separator' ) );

switch ($this->row->pricetype) {
	
	case 2 :
		$price = JText::_ ( 'FREE' );
		break;
	case 3 :
		$price = JText::_ ( 'PRICE_NEGOTIABLE' );
		break;
	
	default :
		if ($this->row->price > 0) {
			$price = $currency->toString ();
		} else {
			$price = JText::_ ( 'FREE' );
		}
		break;
}

$address = array ();
$regions = array ();

if (! empty ( $this->row->address->address )) {
	$address [] = $this->row->address->address;
}

if (! empty ( $this->row->address->street )) {
	$address [] = $this->row->address->street;
}

if (! empty ( $this->row->address->region )) {
	$regions [] = $this->row->address->region;
}

if (! empty ( $this->row->address->state )) {
	$regions [] = $this->row->address->state;
}

if (! empty ( $this->row->address->zipcode )) {
	$regions [] = $this->row->address->zipcode;
}

$adaddress = implode ( ", ", $address );
$adregion = implode ( ", ", $regions );
$class = "";

if (isset ( $this->row->classsuffix )) {
	$class = $this->row->classsuffix;
}

?>
<div class="gb_listings_content" >
<div class="gb_listing normal_listing">
<div class="gb_wrapper <?php
echo $class;
?>">
<div class="gb_double_wrapper">

<div class="gb_thumbnail">

<?php 
if($this->params->get('enableimages',0))
{
?>

<div class="gb_thumbnail_wrapper"
	title="<?php
	echo $this->row->title;
	?>"><a class="gb_title_link"
	title="<?php
	echo $this->row->title;
	?>" href="<?php
	echo $link;
	?>"> <?php
	if (file_exists ( $basepath . $this->row->image . $suffix . "." . $this->row->extension )) {
		?> <img
	src="<?php
		echo $baseurl . $this->row->image . $suffix . "." . $this->row->extension;
		?>"
	alt="<?php
		echo $this->row->title;
		?>"
	width="<?php
		echo $this->params->get ( 'width_thumbnail_sml', 80 );
		?>"
	height="<?php
		echo $this->params->get ( 'height_thumbnail_sml', 65 );
		?>" /> <?php
	} else {
		?> <img src="<?php
		echo $adminbaseurl . "noimage.png"?>"
	width="<?php
		echo $this->params->get ( 'width_thumbnail_sml', 80 );
		?>"
	height="<?php
		echo $this->params->get ( 'height_thumbnail_sml', 65 );
		?>"
	alt="<?php
		echo $this->row->title;
		?>" /> <?php
	}
	?> </a></div>
<?php 
}
?>
</div>

<div class="gb_normal_section">

<div class="gb_listing_header"><a href="<?php
echo $link;
?>"><?php
echo $this->row->title;
?></a>
	<?php
	if (JRequest::getInt ( 'catid' ) == 0) {
		echo " (" . $this->row->category . ")";
	}
	?></div>
<div class="gb_listing_body"><?php
if ($this->params->get ( 'enable_listing_introtext' )) {
	$introtext_length = $this->params->get ( 'listing_introtext_length' );
	echo GHelper::trunchtml ( $this->row->description, $introtext_length );

}

if ($this->params->get ( 'enable_field_address1', 0 ) || $this->params->get ( 'enable_field_address2', 0 ))
{
	?> <strong><?php
	echo $adaddress?></strong><br />

<?php
	if(!empty($adregion))
	{
		echo $adregion. ", " . $this->row->country;
	}
	else
	{
		echo !empty($this->row->country)?$this->row->country:"";
	}
}
?></div>

<div class="gb_item_extrainfo">
<?php
$borderclass = "";
if ($this->row->hasprice && $this->params->get('enable_field_price')) {
	$borderclass = "class=\"bordernone\"";
	?>
	<span <?php
	echo $borderclass;
	?>>
	<?php	
		echo $price;	
	?>
	</span>
	<?php
	$borderclass = "";
} else {
	$borderclass = "class=\"bordernone\"";
}
?>
<span <?php
echo $borderclass;
?>><?php
echo ListbingoHelper::getDate ( $this->row->created_date, $this->params->get ( 'date_format' ) );
?></span>

</div>

<?php
$this->render ( 'itemextrainfo', array ("extrainfo" => $this->row->extrafields ) );
?>


<div class="gb_listing_actions">
<ul class="gb_popup_action">

<?php
if (($this->userid == $this->row->uid) && ! $this->guest) {
	?>
	<li id="gb_listing_viewdetails"><a href="<?php
	echo $editlink;
	?>"><?php
	echo JText::_ ( 'EDIT' );
	?></a></li>
	<?php
}
?>

	<li id="gb_listing_viewdetails"><a href="<?php
	echo $link;
	?>"><?php
	echo JText::_ ( 'VIEW_DETAIL' );
	?></a></li>

</ul>

</div>

</div>
<div class="gb_onafteritemdisplay">
<?php

GApplication::triggerEvent ( 'onLoadProfile', array (& $this->user, & $this->params ) );

GApplication::triggerEvent ( 'onAfterItemDisplay', array (&$this->row, &$this->params ) );

?>
</div>
</div>
<div class="clear" /></div>
</div>
</div>
</div>

