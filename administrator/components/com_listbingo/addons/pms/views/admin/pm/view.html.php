<?php
/**
 * Joomla! 1.5 component estatebingo
 *
 * @version $Id: view.html.php 2009-11-17 10:19:05 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage estatebingo
 * @license GNU/GPL
 *
 * Code Alex
 *
 */

// no direct access
defined('_JEXEC') or die('Restricted access');

// Import Joomla! libraries
gbimport("gobingoo.addonsview");
class PmsViewPm extends GAddonsView {
	function display($tpl = null) {

		$cid			= JRequest::getVar( 'cid', array(0), '', 'array' );
		JArrayHelper::toInteger($cid, array(0));
		$id = $cid[0];

		$model=gbaddons('pms.model.pm');
		$row = $model->loadMessageDetails($id);

		
		$this->assignRef('row',$row);
		parent::display($tpl);
	}
}
?>