<?php 
defined('_JEXEC') or die('Restricted access');
$titlestring='Listbingo - Global Configuration';
ListbingoHelper::cpanel('default','home');
JToolBarHelper::title(JText::_($titlestring), 'settings.png');
JToolBarHelper::save("settings.save");

JToolBarHelper::cancel("default");

gbimport("css.icons");
global $option;

$editor=&JFactory::getEditor();
	$pane = &JPane::getInstance('tabs', array('allowAllClose' => true,'useCookies'=>true));
?>


<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data">
<div id="config-document">
	<div id="page-main">
	<?php 
	echo $pane->startPane("settings-pane");
	
		echo $pane->startPanel(JText::_("Site"), 'sitepanel' );
		?>
		<table class="noshow"  width="50%">
			<tr>
				<td>
					<?php require_once( dirname(__FILE__) . DS . 'frontpage.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'template.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'articles.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'error.php' ); ?>
					
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . DS . 'locale.php' ); ?>
					
					<?php require_once( dirname(__FILE__) . DS . 'prefix.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'directory.php' ); ?>
				</td>
			</tr>
			</table>
		<?php 
		echo $pane->endPanel();
		
		echo $pane->startPanel(JText::_("Listing"), 'listingpanel' );
		
		
		?>
		
	
			<table class="noshow"  width="50%">
	
			<tr>
				<td width="50%">
					
					<?php require_once( dirname(__FILE__) . DS . 'basic.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'breadcrumb.php' ); ?>
				<?php require_once( dirname(__FILE__) . DS . 'tab.php' ); ?>
					
				</td>
				<td>
		
				<?php require_once( dirname(__FILE__) . DS . 'perpost.php' ); ?>
				<?php require_once( dirname(__FILE__) . DS . 'listing.php' ); ?>
				
				<?php require_once( dirname(__FILE__) . DS . 'archive.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'security.php' ); ?>
				</td>
			</tr>
			
			
		</table>
		<?php 
		
		echo $pane->endPanel();
		
		echo $pane->startPanel(JText::_("Search"), 'searchpanel' );
			
		?>
		
		<table class="noshow" >
	
			
			<tr>
			<td >
					<?php require_once( dirname(__FILE__) . DS . 'search.php' ); ?>
				</td>
			</tr>
			
		</table>
		
		
		<?php 
		
		echo $pane->endPanel();
		echo $pane->startPanel(JText::_("Category"), 'categorypanel' );
		?>
		
		<table class="noshow"  width="50%">
	
			
			<tr>
			
				<td width="50%">
					<?php require_once( dirname(__FILE__) . DS . 'category.php' ); ?>
				
				</td>
				<td>&nbsp;</td>
			</tr>
			
		</table>
		
		
		<?php 
		echo $pane->endPanel();
			echo $pane->startPanel(JText::_("Profile"), 'profilepanel' );
			?>
			<table class="noshow"  width="50%">
	
			
			<tr>
			
				<td width="50%">
					<?php require_once( dirname(__FILE__) . DS . 'profile.php' ); ?>
				
				</td>
				<td>&nbsp;</td>
			</tr>
			
		</table>
			<?php 
			echo $pane->endPanel();
			
				echo $pane->startPanel(JText::_("Core Fields"), 'fieldpanel' );
			?>
		
					<?php require_once( dirname(__FILE__) . DS . 'field.php' ); ?>
				
				
			<?php 
			echo $pane->endPanel();
			
				echo $pane->startPanel(JText::_("Cron"), 'cronpanel' );
			?>
			<table class="noshow"  width="100%">
	
			
			<tr>
			
				<td width="100%">
					<?php require_once( dirname(__FILE__) . DS . 'cron.php' ); ?>
				
				</td>
				
			</tr>
			
		</table>
			<?php 
			echo $pane->endPanel();
	echo $pane->endPane();
	?>
	
	</div>

	<div id="page-media">
		<table class="noshow">
			<tr>
				<td  width="50%">
				<?php require_once( dirname(__FILE__) . DS . 'attachment.php' ); ?>
					<?php require_once( dirname(__FILE__) . DS . 'photos.php' ); ?>
					<?php // require_once( dirname(__FILE__) . DS . 'videos.php' ); ?>
				</td>
				<td>
					<?php require_once( dirname(__FILE__) . DS . 'thumbnails.php' ); ?>
				</td>
				
			</tr>
		</table>
	</div>
	
<?php 
	GApplication::triggerEvent('onSettingsPageDisplay',array(&$this->config));
?>

	

	
</div>
<div class="clr"></div>
<?php echo JHTML::_( 'form.token' ); ?>
<input type="hidden" name="task" value="settings.save" />

<input type="hidden" name="option" value="<?php echo $option;?>" />
</form>
