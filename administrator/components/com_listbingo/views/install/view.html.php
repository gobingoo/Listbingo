<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: view.html.php 2010-01-10 00:57:37 svn $
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

// Import Joomla! libraries
gbimport("gobingoo.view");

class ListbingoViewInstall extends GView {
	function display($tpl = null) {
		global $mainframe;
		$model	= gbimport("listbingo.model.addon");
		
		$model->setState( 'install.directory', $mainframe->getCfg( 'config.tmp_path' ));

		

		$ftp =& JClientHelper::setCredentialsFromRequest('ftp');
		$this->assignRef('ftp', $ftp);

		$this->setModel( $model, true );
		/*
		 * Set toolbar items for the page
		 */


		$paths = new stdClass();
		$paths->first = '';

		$this->assignRef('paths', $paths);
		$this->assignRef('state', $this->get('state'));

		parent::display($tpl);
	}
}
?>