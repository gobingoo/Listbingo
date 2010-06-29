<?php
/**
 * List layout for breadcrumb template
 *
 * @package Gobingoo
 * @subpackage Listbingo
 * code Bruce
 */
//var_dump($this->rows);exit;
defined('_JEXEC') or die('Restricted access');
$this->addCSS('layout');

if(!empty($this->loc))
{
	echo $this->loc." >> ";
}

$url = 'index.php?option&option='.$option.'&task=categories.select&catid=';
ListbingoHelper::makeBreadcrumb($url);

?>

<div class="gbNavigation"><?php 
global $mainframe;
if(!$this->nav['country'])
{
	
	if($this->params->get('country_selection'))
	{
		
		$changelink=JRoute::_("index.php?option=$option&task=regions.select&type=country");
		?> <a href="<?php echo $changelink;?>"><?php echo JText::_("CHANGE_COUNTRY");?></a>&nbsp;
		<?php
	}
}
if(!$this->nav['region'])
{
	if($this->params->get('region_selection'))
	{
		
		
		
		$changelink=JRoute::_("index.php?option=$option&task=regions.select&type=region");
		?> <a href="<?php echo $changelink;?>"><?php echo JText::_("CHANGE_REGION");?></a>
		<?php
	}
}

if(JRequest::getInt('catid',0) || JRequest::getInt('adid',0))
{
	?>
	<a href="<?php echo JRoute::_('index.php?option='.$option.'&task=categories.list');?>">(<?php echo JText::_('CHANGE_CATEGORY');?>)</a>
	<?php
}
?>
</div>
