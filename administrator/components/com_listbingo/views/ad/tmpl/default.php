<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: default.php 2010-01-10 00:57:37 svn $
 * @author GOBINGOO
 * @package Joomla
 * @subpackage LISTBINGO
 * @license GNU/GPL
 *
 * A classified ad component from gobingoo.com.
 *
 * code Bruce
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');
$titlestring=($this->edit)?'Edit Ad':'Add Ad';
JToolBarHelper::title(JText::_($titlestring), 'ad.png');
JToolBarHelper::save("ads.save");
JToolBarHelper::apply("ads.apply");
JToolBarHelper::cancel("ads.cancel");


gbimport("css.icons");
gbimport("css.layout");
gbimport("js.adinput");

global $option;

$editor=&JFactory::getEditor();
$params = $this->params;
$suffix=$params->get($params->get('listlayout_thumbnail'));

?>
<script language="javascript" type="text/javascript">
//<!--

var pricetypecat = new Array;
<?
if(count($this->pricetypecategories)>0)
{

	foreach($this->pricetypecategories as $pt)
	{
		echo "pricetypecat[".$pt->id."] = $pt->hasprice;\n\t\t";
	}
}
?>


var ad_id=<?php if($this->row->id) echo $this->row->id; else echo 0;?>;
var imgcount=1;
var currentcount=0;
<?php
if($this->edit)
{
	?>
	window.addEvent('domready',function(){
		
		$('locality').setHTML('Loading...');
		url='index.php?option=com_listbingo&tmpl=component&task=regions.load&cid='+<?php echo $this->row->country_id?>+'&selected='+<?php echo $this->row->region_id;?>;
		req=new Ajax(url,			
				{
				update:'locality',
				method:'get',
				evalScripts:true
				}
				);
				
				req.request();

		$('ef').setHTML('Loading...');
		url='index.php?option=com_listbingo&tmpl=component&task=categories.loadef&cid='+<?php echo $this->row->category_id?>+'&adid='+<?php echo $this->row->id;?>;
		req2=new Ajax(url,			
				{
				update:'ef',
				method:'get',
				evalScripts:true
				}
				);
				
				req2.request();

		/*
			check if price type is available for the ad
		*/

		if(pricetypecat[<?php echo $this->row->category_id;?>]>0)
		{

			document.getElementById('pricetype-container').style.visibility="visible";
			document.getElementById('price-container').style.visibility="visible";

			<?php 
			if(!empty($this->row->pricetype))
			{
				?>
				if(<?php echo $this->row->pricetype;?>>1)
				{
					document.getElementById('price').value="";
					document.getElementById('price-container').style.display="none";
				}
				else
				{
					document.getElementById('price-container').style.display="00";
				}
				<?php 
			}
			?>
		}
		else
		{

			document.getElementById('pricetype-container').style.visibility="hidden";
			document.getElementById('price-container').style.visibility="hidden";
		}

				
		});
	
	
	<?php 
	
}


?>
function checkPriceType(val)
{
	
	if(val>1)
	{
		document.getElementById('price-container').style.visibility="hidden";
	}
	else
	{
		document.getElementById('price-container').style.visibility="visible";
	}
		
}
//-->
</script>
<form name="adminForm" id="adminForm" action="<?php echo JRoute::_("index.php"); ?>" method="post"
	enctype="multipart/form-data"><input type="hidden" name="id" id="id"
	value="<?php echo $this->row->id?>" />
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="50%" valign="top">
		<fieldset class="adminform"><legend><?php echo JText::_('AD_DETAILS');?></legend>
		<table width="100%" cellpadding="5" class="admintable">

			<tr>
				<td width="10%" valign="top" class="key"><?php echo JText::_('AD_ID');?></td>
				<td width="40%" colspan="2"><input name="globalad_id"
					type="text" class="inputbox" id="globalad_id"
					value="<?php echo $mainframe->getUserState($option.'admin_globalad_id');?>" size="15" /> <small>(<?php echo JText::_('GLOBAL_ID_INFO');?>) </small></td>

			</tr>
			<tr>
				<td width="10%" valign="top" class="key"><?php echo JText::_('TITLE');?></td>
				<td width="40%"><input name="title" type="text" class="inputbox"
					id="title" value="<?php echo $mainframe->getUserState($option.'admin_title');?>" size="45" /></td>
				<td>&nbsp;</td>
			</tr>
			<tr>
				<td valign="top" class="key"><?php echo JText::_('ALIAS');?> <small>(<?php echo JText::_('FOR_SEO');?>)</small></td>
				<td><input name="alias" type="text" class="inputbox" id="alias"
					value="<?php echo $mainframe->getUserState($option.'admin_alias');?>" size="45" /></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td valign="top" class="key"><?php echo JText::_('AD_STATUS');?></td>
				<td><?php echo $this->lists['status'];?></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr id="pricetype-container">
				<td valign="top" class="key"><?php echo JText::_('PRICE_TYPE');?></td>
				<td><?php echo $this->lists['pricetype'];?></td>
				<td>&nbsp;</td>
			</tr>

			
			<tr id="price-container">
				<td valign="top" class="key"><?php echo JText::_('PRICE');?></td>
				<td>
				<?php echo $this->lists['currencies'];?><input
					name="price" type="text" class="inputbox" id="price"
					value="<?php echo $mainframe->getUserState($option.'admin_price');?>" size="15" /> <br />
				<small>(<?php echo JText::_('PRICE_INFO');?>) </small></td>
				<td>&nbsp;</td>

			</tr>
			
			
			<tr>
				<td valign="top" class="key"><?php echo JText::_('EXPIRY_DATE');?></td>
				<td><?php echo JHTML::_('calendar', $mainframe->getUserState($option.'admin_expiry_date'), "expiry_date", 'expiry_date', '%Y-%m-%d', array('class'=>'inputtextbox ',  'maxlength'=>'19'));?></td>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td valign="top" class="key"><?php echo JText::_('SHOW_CONTACT');?></td>
				<td><?php echo $this->lists['showcontact'];?></td>
				<td>&nbsp;</td>
			</tr>
			
			
			<tr>
				<td colspan="3" align="left" valign="top"><strong><?php echo JText::_('DESCRIPTION');?></strong></td>
			</tr>
			<tr>
				<td colspan="3" valign="top"><?php echo $editor->display('description',$mainframe->getUserState($option.'admin_description'),'100%','350','60','5'); ?></td>
			</tr>
		</table>
		</fieldset>
		
		<fieldset class="adminform"><legend><?php echo JText::_('LOCATION_DETAILS');?></legend>
		<table width="100%" cellpadding="5" class="admintable">
			<tr>
				<td width="40%" valign="top" class="key"><?php echo JText::_('SELECT_COUNTRY');?></td>
				<td><?php echo $this->lists['countries'];?></td>

			</tr>
			<tr>
				<td width="40%" valign="top" class="key"><?php echo JText::_('SELECT_REGION');?></td>
				<td>
				<div id="locality"><?php if($this->edit)
				{
					echo JText::_('LOADING');

				}
				else
				{
					echo JText::_('SELECT_COUNTRY_TO_LOAD_REGIONS');
				}
				?></div>
				</td>

			</tr>
			
			<tr>
				<td width="50%" valign="top" class="key"><?php echo JText::_('STREET');?></td>
				<td><input name="address2" type="text" class="inputbox"
					id="address2" value="<?php echo $mainframe->getUserState($option.'admin_address2'); ?>" size="45" />
				</td>

			</tr>
			
			<tr>
				<td width="50%" valign="top" class="key"><?php echo JText::_('POSTAL_CODE');?></td>
				<td><input name="zipcode" type="text" class="inputbox"
					id="zipcode" value="<?php echo $mainframe->getUserState($option.'admin_zipcode');?>" size="45" />
				</td>

			</tr>

			<tr>
				<td width="50%" valign="top" class="key"><?php echo JText::_('ADDRESS');?></td>
				<td><textarea name="address1" id="address1" cols="45" rows="4"><?php echo $mainframe->getUserState($option.'admin_address1');?></textarea>
				</td>

			</tr>

			<tr>
				<td colspan="2"><?php   
				GApplication::triggerEvent("onAdminAdAddressButtonDisplay",array(&$this->row));
				?></td>
			</tr>

		</table>

		</fieldset>		
		</td>
		<td valign="top">
		<fieldset class="adminform"><legend><?php echo JText::_('ASSIGN_TO_CATEGORY');?></legend>

		<table width="100%" cellpadding="5" class="admintable">

			<tr>
				<td width="30%" valign="top" class="key"><?php echo JText::_('AD_CATEGORY');?></td>
				<td><?php echo $this->lists['categories'];?></td>
			</tr>

		</table>
		</fieldset>
		<div id="ef"></div>
		<fieldset class="adminform"><legend><?php echo JText::_('IMAGES');?></legend>

		<table width="100%" cellpadding="5" class="admintable">
			<tr>
				<td>
				<div class="gb_images_wrapper">
				<?php 
				if(($this->row->images)>0)
				{
					echo "Existing Images<br />";
					foreach($this->row->images as $i)
					{
						$deletelink=JRoute::_("index.php?option=$option&task=ads.removeImage&adid=$i->ad_id&iid=$i->id");
						if($i->published)
						{
							$checked = "CHECKED=\"CHECKED\"";	
						}
						else
						{
							$checked = "";	
						}
						?>
						<div class="gb_item_images">
						<img src="<?php echo JUri::root().$i->image.$suffix.".".$i->extension;?>"/>
						
						<input type="checkbox" name="publishimage[]" value="<?php echo $i->id; ?>" <?php echo $checked; ?>/>Publish
						<br />
						<input type="checkbox" name="deleteimage[]" value="<?php echo $i->id; ?>" />Delete
						
						</div>
						<?php		
					}			
				}
					
				?>
				</div>
				<br class="clear" />
				</td>
			</tr>
		
			<tr>

				<td>
				
				<div class="uploadWrapper">
				<div id="imageUploader">
				
				<div id="img_0" class="imageholder">
				<div class="image_upload_input"><input type="file" name="images[]" /></div>
				<br class="clear" />
				</div>
				
				
				</div>
				
				<div class="addmoreImages"><a id="addb" href="javascript:void(0);"><?php echo JText::_("ADD_MORE_IMAGES");?></a>
				</div>
				</div>
				
				
				</td>

			</tr>

		</table>
		</fieldset>
		<fieldset class="adminform"><legend><?php echo JText::_('ASSIGN_USER');?></legend>

		<table width="100%" cellpadding="5" class="admintable">
			<tr>
				<td width="30%" valign="top" class="key"><?php echo JText::_('USERS');?></td>
				<td><?php echo $this->lists['user_id'];?></td>

			</tr>

		</table>
		</fieldset>
		
		<fieldset class="adminform"><legend><?php echo JText::_('TAGS_EXCERPTS');?></legend>
		<table width="100%" cellpadding="5" class="admintable">
			<tr>
				<td class="key" style="text-align: left;"><?php echo JText::_('TAGS');?></td>
			</tr>

			<tr>
				<td valign="top"><textarea name="tags" id="tags" rows="3" cols="55"
					class="inputbox"><?php echo $mainframe->getUserState($option.'admin_tags',$this->row->tags);?></textarea></td>

			</tr>

			<tr>
				<td class="key" style="text-align: left;"><?php echo JText::_('EXCERPT_DESCRIPTION');?><br />
				<small><?php echo JText::_('EXCERPT_INFO');?></small></td>
			</tr>

			<tr>
				<td valign="top"><textarea name="metadesc" id="metadesc" rows="7"
					cols="55" class="inputbox"><?php echo $mainframe->getUserState($option.'admin_metadesc',$this->row->metadesc);?></textarea></td>
			</tr>



		</table>
		</fieldset>

		<?php
		GApplication::triggerEvent("onAdminAdInput",array(&$this->row));		
		?>
		</td>

	</tr>
</table>
<input type="hidden" name="ordering" value="<?php echo $this->row->ordering;?>" />
<input type="hidden" name="option" value="<?php echo $option?>" /> <input
	type="hidden" name="task" value="" /> <?php echo JHTML::_( 'form.token' ); ?>

</form>
