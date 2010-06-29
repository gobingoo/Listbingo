<?php 
require_once(JPATH_ROOT.DS."administrator".DS."components".DS."com_content".DS."elements".DS."article.php");

$element=new JElementArticle(); 

$param=null;
?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'Registration Settings' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Article ID Registration' ); ?>::<?php echo JText::_('Article Id for Registration Page'); ?>">
						<?php echo JText::_( 'Article for Registration' ); ?>
					</span>
				</td>
				<td valign="top"><?php 
				echo $element->fetchElement("reg_article_id", $this->config->get('reg_article_id'), $param, "config");
				
				?>
			
				</td>
			</tr>
			<tr>
			<td class="key"><span class="hasTip"
				title="<?php echo JText::_( 'Auto Login' ); ?>::<?php echo JText::_('If Set to yes, User will be automatically activated and logged in'); ?>">
				<?php echo JText::_( 'Auto Login' ); ?> </span></td>
			<td valign="top"><?php echo JHTML::_('select.booleanlist' , 'config[enable_reg_autologin]' , null ,  $this->config->get('enable_reg_autologin') , JText::_('Yes') , JText::_('No') ); ?>
			</td>
		</tr>
		<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Welcome Article' ); ?>::<?php echo JText::_('Welcome Article for Auto Login'); ?>">
						<?php echo JText::_( 'Welcome Article' ); ?>
					</span>
				</td>
				<td valign="top"><?php 
				echo $element->fetchElement("reg_welcome_id", $this->config->get('reg_welcome_id'), $param, "config");
				
				?>
			
				</td>
			</tr>
			
			
		</tbody>
	</table>
</fieldset>