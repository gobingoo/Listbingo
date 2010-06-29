<?php
require_once (JPATH_ROOT . DS . "administrator" . DS . "components" . DS . "com_content" . DS . "elements" . DS . "article.php");

$element = new JElementArticle ();

$param = null;

?>
<table width="100%" cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td width="40%">
		<fieldset class="adminform"><legend><?php
echo JText::_ ( 'Cron Settings' );
?></legend>
<table class="admintable" cellspacing="1">
	<tbody>
		<tr>
			<td width="100%" class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Run Cron on page load' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Cron will run on page load. Has severe performance issues' );
				?>">
						<?php
						echo JText::_ ( 'Run Cron on page load' );
						?>
					</span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_frontpage_cron]', 1, $this->config->get ( 'enable_frontpage_cron' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		<tr>
			<td  class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Enable Core Cron' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Cron associated with Ad will be run' );
				?>">
						<?php
						echo JText::_ ( 'Enable Core Cron' );
						?>
					</span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_core_cron]', 1, $this->config->get ( 'enable_core_cron' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
	<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Core Items to process' ); ?>::<?php echo JText::_('Set number of Ad Items to process in each cron'); ?>">
					<?php echo JText::_( 'Items to process' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[cron_core_items]" value="<?php echo $this->config->get('cron_core_items');?>" size="5" /> Per Cron
				</td>
			</tr>

		<tr>
			<td  class="key"><span class="hasTip"
				title="<?php
				echo JText::_ ( 'Process Addons Cron' );
				?>::<?php
				echo JText::_ ( 'If set to  yes, Cron associated with addons will be run' );
				?>">
						<?php
						echo JText::_ ( 'Enable Addons Cron' );
						?>
					</span></td>
			<td valign="top"><?php
			echo JHTML::_ ( 'select.booleanlist', 'config[enable_addons_cron]', 1, $this->config->get ( 'enable_addons_cron' ), JText::_ ( 'Yes' ), JText::_ ( 'No' ) );
			?>
			
			
				</td>
		</tr>
		<tr>
				<td class="key">
					<span class="hasTip" title="<?php echo JText::_( 'Core Items to process' ); ?>::<?php echo JText::_('Set number of Ad Items to process in each cron'); ?>">
					<?php echo JText::_( 'Items to process' ); ?>
					</span>
				</td>
				<td valign="top">
					<input type="text" name="config[cron_addon_items]" value="<?php echo $this->config->get('cron_addon_items');?>" size="5" /> Per Cron
				</td>
			</tr>

	</tbody>
</table>
</fieldset>
	</td>
	<td>
	<fieldset class="adminform"><legend><?php
echo JText::_ ( 'Cron on Cpanel' );
?></legend>
<div class="cron">
You will need to set up a cron job to run periodically for Listbingo. 

The cron job is required to
<ol>
<li>avoid excessive processing during a normal page load
</li>
<li>to send out system emails.</li>
<li>archive old Ads that are no longer relevant</li>
<li>perform optional administrative job such as remove old, unused ads, trim transaction histories, send expiry alerts 
</li>
</ol>

</div>
<div>
<h2>Setup a cron in CPanel (Linux Servers)</h2>
To setup a cron in CPanel you can set up a cron with following
<ol>
<li><strong>
lynx -source "<em>http://www.yourdomain.com/index.php?option=com_listbingo&amp;task=cron.run</em>" &gt; /dev/null</strong>
<div>lynx is a text based browser available in most linux distribution. If lynx is not available you can use <strong>wget</strong> as shown below</div>
</li>
<li><strong>
wget -O /dev/null "<em>http://www.yourdomain.com/index.php?option=com_listbingo&amp;task=cron.run</em>" &gt; /dev/null</strong>
</li>

</ol>
</div>
<div>
<h2>Setup a cron with Third party cron scheduler</h2>
You can use third party cron sheduler to run your cron as above. There is no security threat in running "index.php?option=com_listbingo&amp;task=cron.run" as it is publicly visible 
and open to everyone

</div>
<div>
<h4>You should run cron at certain interval, preferably 10 minutes for listbingo to work smoothly</h4>
</div>
</fieldset>
	</td>
	</tr>
</table>
