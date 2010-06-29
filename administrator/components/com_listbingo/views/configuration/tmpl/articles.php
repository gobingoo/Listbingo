<?php 
require_once(JPATH_ROOT.DS."administrator".DS."components".DS."com_content".DS."elements".DS."article.php");

$element=new JElementArticle(); 

$param=null;

?>
<fieldset class="adminform">
	<legend><?php echo JText::_( 'ARTICLE_SETTINGS' ); ?></legend>
	<table class="admintable" cellspacing="1">
		<tbody>
			<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'ARTICLE_ID_FOR_RULE' ); ?>::<?php echo JText::_('ARTICLE_ID_FOR_RULE'); ?>">
						<?php echo JText::_( 'ARTICLE_ID_FOR_RULE' ); ?>
					</span>
				</td>
				<td valign="top"><?php 
				echo $element->fetchElement("rules_id", $this->config->get('rules_id'), $param, "config");
				
				?>
			
				</td>
			</tr>
			
				<tr>
				<td width="300" class="key">
					<span class="hasTip" title="<?php echo JText::_( 'ARTICLE_ID_FOR_QUOTE' ); ?>::<?php echo JText::_('ARTICLE_ID_FOR_QUOTE'); ?>">
						<?php echo JText::_( 'ARTICLE_ID_FOR_QUOTE' ); ?>
					</span>
				</td>
				<td valign="top"><?php 
				echo $element->fetchElement("quote_id", $this->config->get('quote_id'), $param, "config");
				
				?>
			
				</td>
			</tr>
			
			
		</tbody>
	</table>
</fieldset>