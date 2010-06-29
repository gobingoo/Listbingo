<?php
/**
 * @package gobingoo
 * @subpackage listbingo
 * post new ad subtemplate
 * @author Bruce@gobingoo.com
 * code Bruce
 */
defined('_JEXEC') or die('Restricted access');

?>

<script language="javascript" type="text/javascript">

//<!--

window.addEvent('domready',function(){

	$('country_id').addEvent('change',function(){
		
		$('locality').setHTML('Loading...');
		url='index.php?option=com_listbingo&format=raw&task=regions.load&cid='+this.value;
		
		req=new Ajax(url,			
				{
				update:'locality',
				method:'get',
					evalscript:true
				}
				);
				
				req.request();
		
	});

});
<?php 
if($this->profile->user_id)
{
	?>			
	
	url='index.php?option=com_listbingo&format=raw&task=regions.load&cid='+<?php echo $this->profile->country_id?>+'&selected='+<?php echo $this->profile->region_id;?>;
	req=new Ajax(url,			
			{
			update:'locality',
			method:'get',
				evalscript:true
			}
			);			
			req.request();			
		
<?php 
}
?>	
	
//-->
</script>


<div id="roundme" class="gb_round_corner">

<div class="gb_form_heading">
<h3><?php echo JText::_('EDIT_YOUR_PROFILE');?></h3>
</div>

<div id="roundme" class="gb_profileimg_round_corner">
<div class="gb_listing_userimg">
	<img src="<?php echo $this->imgurl;?>" alt="<?php echo $this->profile->name;?>" />
</div>

<div class="gb_user_name">
<?php echo $this->delimagelink; ?>
</div>

</div>

<div id="gbjosFormHolder">
<form action="<?php echo JRoute::_('index.php'); ?>" method="post" id="josForm" name="josForm" class="form-validate" enctype="multipart/form-data">

<div>
<label id="namemsg" for="name"><?php echo JText::_('NAME');?></label>
<input name="name" type="text" class="inputtextbox required" id="name" value="<?php echo $this->profile->name;?>" />
</div>

<div>
<label id="emailmsg" for="email"><?php echo JText::_('EMAIL');?></label>
<input name="email" type="text" class="inputtextbox required" id="email" value="<?php echo $this->profile->email;?>"  />
</div>

<div>
<label id="address1msg" for="address1"><?php echo JText::_('ADDRESS1');?></label>
<input name="address1" type="text" class="inputtextbox required" id="address1" value="<?php echo $this->profile->address1;?>" />
</div>


<div>
<label id="address2msg" for="address1"><?php echo JText::_('ADDRESS2');?></label>
<input name="address2" type="text" class="inputtextbox" id="address2" value="<?php echo $this->profile->address2;?>"/>
</div>

<div>
<label id="country_idmsg" for="country_id"><?php echo JText::_('Country');?></label>
<?php echo $this->lists['countries'];?>
</div>

<div id="locality">
</div>

<div>
<label id="imagemsg" for="image"><?php echo JText::_('PHOTO');?></label>
<input type="file" name="image" size="27" />
</div>


<button class="gbButton validate" type="submit"><?php echo JText::_('SAVE'); ?></button>
<input type="hidden" name="option" value="<?php echo $option?>" /> <input
	type="hidden" name="task" value="profile.save" /> <?php echo JHTML::_( 'form.token' ); ?>

</form>
</div>
<br class="clear" />
</div>

