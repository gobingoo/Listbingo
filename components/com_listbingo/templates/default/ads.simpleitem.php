<?php
global $option;
$suffix=$this->params->get($this->params->get('listlayout_thumbnail'));
$link = JRoute::_("index.php?option=$option&task=ads.view&adid=".$this->row->id);
$noimage = JUri::root().$this->params->get('path_default_profile_noimage');
$baseurl=JUri::root();
$adminbaseurl=JUri::root()."administrator/components/$option/images/";
$basepath = JPATH_ROOT.DS;

$class="";

if(isset($this->row->classsuffix))
{
	$class=$this->row->classsuffix;
}


if($this->row->hasprice==1)
{
	$currency=new GCurrency($this->row->price,$this->row->currencycode,$this->row->currency,$this->params->get('currency_format'),
	$this->params->get('decimals'),$this->params->get('decimal_separator'),$this->params->get('value_separator'));

}
$link = JRoute::_("index.php?option=$option&task=ads.view&adid=".$this->row->id);
?>
<tr class="row<?php echo $this->j;?> <?php echo $class;?>">

<?php 
if($this->params->get('enableimages',0))
{
?>
<td>

<?php 

if(file_exists($basepath.$this->row->image.$suffix.".".$this->row->extension))
	{
		?> <a href="<?php echo $link;?>"><img
	src="<?php echo $baseurl.$this->row->image.$suffix.".".$this->row->extension;?>"
	width="<?php echo $this->params->get('width_thumbnail_sml',80);?>"
	height="<?php echo $this->params->get('height_thumbnail_sml',65);?>"
	alt="<?php echo $this->row->title;?>" /> </a><?php 
	}
	else
	{
		?> <a href="<?php echo $link;?>"><img src="<?php echo $adminbaseurl."noimage.png"?>"
	width="<?php echo $this->params->get('width_thumbnail_sml',80);?>"
	height="<?php echo $this->params->get('height_thumbnail_sml',65);?>"
	alt="<?php echo $this->row->title;?>" /> </a><?php 
	}
?>

</td>
<?php 
}
?>

<td width="30%"><a href="<?php echo $link;?>"><?php echo $this->row->title; ?></a></td>
<?php 
if($this->params->get('enable_field_price',0))
{
?>
<td width="20%"><?php 

if($this->row->hasprice==1)
{

	switch($this->row->pricetype)
	{
		case 1:
			if($this->row->price>0) echo $currency->toString(); else echo JText::_('FREE');
			break;

		case 2:
			echo JText::_('FREE');
			break;
			
		case 3:
			echo JText::_('PRICE_NEGOTIABLE');
			break;

		default:
			if($this->row->price>0) echo $currency->toString(); else echo JText::_('FREE');
			break;
	}

}
else
{
	echo JText::_('NOT_APPLICABLE');
}
?></td>
<?php 
}
?>
<td width="15%"><?php echo ListbingoHelper::getDate($this->row->created_date,$this->params->get('dateonlyformat'));?></td>
<?php 
if($this->params->get('auto_expire_listings'))
{
?>
<td width="15%">
<?php 
if($this->row->expiry_date==$this->nulldate)
{
	echo JText::_('NEVER_EXPIRE');
}
else
{
	echo ListbingoHelper::getDate($this->row->expiry_date,$this->params->get('dateonlyformat'),false);
}
?>
</td>
<?php	
}

?>

</tr>


