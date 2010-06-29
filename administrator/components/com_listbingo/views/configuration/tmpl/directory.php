<?php
// Disallow direct access to this file
defined('_JEXEC') or die('Restricted access');
global $option;

$country=array();
$country[]=JHTML::_('select.option', '0', JText::_('No'), 'id', 'title');
$country[]=JHTML::_('select.option', '1', JText::_('Yes'), 'id', 'title');

$countryoption=JHTML::_('select.radiolist',  $country, 'config[country_selection]', array('class'=>"inputbox",'onclick'=>'return checkDefaultCountry(this.value)'), 'id', 'title',$this->config->get('country_selection') );



$region=array();
$region[]=JHTML::_('select.option', '0', JText::_('No'), 'id', 'title');
$region[]=JHTML::_('select.option', '1', JText::_('Yes'), 'id', 'title');

$regionoption=JHTML::_('select.radiolist',  $region, 'config[region_selection]', array('class'=>"inputbox",'onclick'=>'return checkDefaultRegion(this.value)'), 'id', 'title',$this->config->get('region_selection') );

$countrylink = JRoute::_("index.php?option=$option&task=countries");
$regionlink = JRoute::_("index.php?option=$option&task=regions");

$countrymsg = "( ".JText::_('Default country is set as ')." <strong>";
$countrymsg.=(!is_null($this->country))?$this->country->title:'None'."</strong>. ".JText::_('To change')." ";
$countrymsg .="<a href=\"$countrylink\">".JText::_('Click here')."</a> )";
$regionmsg = "( ".JText::_('Default region is set as ')." <strong>";
$regionmsg.=(!is_null($this->region))?$this->region->title:'None'."</strong>. ".JText::_('To change')." ";
$regionmsg .="<a href=\"$regionlink\">".JText::_('Click here')."</a> )";
?>
<script type="text/javascript">
<!--
_EVAL_SCRIPTS=true

	
	function checkDefaultCountry(country)
	{
		if(country==0)
		{
			document.getElementById('default_country_msg').innerHTML = '<?php echo $countrymsg;?>';
			document.getElementById('force_country_tr').style.display = 'none';
		}
		else
		{
			document.getElementById('default_country_msg').innerHTML = '';
			document.getElementById('force_country_tr').style.display = '';
		}
	}

	function checkDefaultRegion(region)
	{
		if(region==0)
		{
			document.getElementById('default_region_msg').innerHTML = '<?php echo $regionmsg;?>';
			document.getElementById('force_region_tr').style.display = 'none';
		}
		else
		{
			document.getElementById('default_region_msg').innerHTML = '';
			document.getElementById('force_region_tr').style.display = '';
		}
	}

-->
</script>

<fieldset class="adminform"><legend><?php echo JText::_( 'Directory Configuration' ); ?></legend>
<table class="admintable" cellspacing="1">
	<tbody>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Show country selection' ); ?>::<?php echo JText::_('If Yes, Regional Selection will show country selection. If No, default country will be used'); ?>">
				<?php echo JText::_( 'Show country selection' ); ?> </span></td>
			<td valign="top"><?php echo$countryoption;?> <span
				id="default_country_msg"> <?php 
					
				if(!$this->config->get('country_selection'))
				{
					echo $countrymsg;
				}
				?> </span></td>
		</tr>

		<?php 
		$cstyle="";
		if(!$this->config->get('country_selection'))
		{
			$cstyle="style=\"display:none;\"";	
		}
		else
		{
			$cstyle="";
		}
		?>
		<tr  id="force_country_tr" <?php echo $cstyle;?>>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'FORCE_COUNTRY_SELECTION' ); ?>::<?php echo JText::_('If Yes, Country is mandatory to select'); ?>">
				<?php echo JText::_( 'FORCE_COUNTRY_SELECTION' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[force_country_selection]' , null ,  $this->config->get('force_country_selection') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		
		<tr>
		<td>&nbsp;</td>
		<td><hr /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Show region selection' ); ?>::<?php echo JText::_('If Yes, Regional Selection is activated. If No, default country will be used'); ?>">

				<?php echo JText::_( 'Show region selection' ); ?> </span></td>
			<td valign="top"><?php echo $regionoption; ?> <span
				id="default_region_msg"> <?php 
				if(!$this->config->get('region_selection'))
				{
					echo $regionmsg;
				}
				?> </span></td>
		</tr>
		
		<?php 
		$rstyle="";
		if(!$this->config->get('region_selection'))
		{
			$rstyle="style=\"display:none;\"";	
		}
		else
		{
			$rstyle="";
		}
		?>
		

		<tr id="force_region_tr" <?php echo $rstyle;?>>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'FORCE_REGION_SELECTION' ); ?>::<?php echo JText::_('If Yes, Region is mandatory to select'); ?>">
				<?php echo JText::_( 'FORCE_REGION_SELECTION' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[force_region_selection]' , null ,  $this->config->get('force_region_selection') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>

		<tr>
		<td>&nbsp;</td>
		<td><hr /></td>
		</tr>

		<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Expand Directory' ); ?>::<?php echo JText::_('If Yes, Directory will be in expanded form'); ?>">
				<?php echo JText::_( 'Expand Directory' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[expand_directory]' , null ,  $this->config->get('expand_directory') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>



	</tbody>
</table>
</fieldset>
