<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: profile.php 2010-01-10 00:57:37 svn $
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
defined ( '_JEXEC' ) or die ( 'Restricted access' );
gbimport ( "gobingoo.table" );
// Include library dependencies
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableProfile extends GTable {
	
	/**
	 * Primary Key
	 * @var int
	 */
	var $id = null;
	
	var $user_id = null;
	
	var $address1 = null;
	
	var $address2 = null;
	
	var $country_id = null;
	
	var $region_id = null;
	
	var $preferences = null;
	
	//var $show_contact = null;
	
	var $image = null;
	
	var $extension = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_profile', 'id', $db );
	}
	
	function load($id = 0) {
		global $option;
		
		parent::load ( $id );
		if (empty ( $this->image )) {
			$basepath = "administrator/components/$option/images/nouser.png";
			$this->image = $basepath;
		}
	
	}
	
	function store($image, $params) {
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_profile where user_id='$this->user_id'";
		$db->setQuery ( $query );
		$p = $db->loadObject ();
		if ($p) {
			$this->id = $p->id;
		}
		self::saveImage ( $image, $params );
		return parent::store ();
	
	}
	
	function saveImage($image = null, $params) {
		
		global $option;
		
		if ($image ['name'] == "") {
			return false;
		}
		
		//Delete previous files
		if ($this->id) {
			$db = JFactory::getDBO ();
			$query = "SELECT image,extension from #__gbl_profile where id=$this->id";
			$db->setQuery ( $query );
			$obj = $db->loadObject ();
			
			if (! empty ( $obj->image )) {
				if (strpos ( $obj->image, "/" ) == 0) {
					
					$photo = str_replace ( "/", DS, $obj->image );
					@unlink ( JPATH_ROOT . $photo . $params->get ( 'suffix_profile_image' ) . "." . $obj->extension );
				} else {
					
					$photo = str_replace ( "/", DS, $obj->image );
					@unlink ( JPATH_ROOT . DS . $photo . $params->get ( 'suffix_profile_image' ) . "." . $obj->extension );
				}
			
			}
		}
		
		gbimport ( "gobingoo.upload" );
		$uploader = new GUpload ();
		
		$uploader->setFolderPermission ( $params );
		$returnvar = array ();
		
		$thumbparams = new stdClass ();
		$thumbparams->prefix = $params->get ( 'prefix' );
		$thumbparams->saveoriginal = 0;
		$thumbparams->convert = $params->get ( 'profile_convertto' );
		
		$uploadfolder = $params->get ( 'path_profile_image' );
		if (strpos ( $uploadfolder, "/" ) == 0) {
			$thumbparams->uploadfolder = JPATH_ROOT . $uploadfolder;
		} else {
			$thumbparams->uploadfolder = JPATH_ROOT . DS . $uploadfolder;
		}
		
		$thumbnails = array ();
		$ratio = $params->get ( 'saveproportions' );
		
		$thumbnail = new stdClass ();
		$thumbnail->suffix = $params->get ( 'suffix_profile_image' );
		$thumbnail->width = $params->get ( 'width_profile_image' );
		$thumbnail->height = $params->get ( 'height_profile_image' );
		$thumbnail->y = $params->get ( 'y_profile_image' );
		$thumbnail->x = $params->get ( 'x_profile_image' );
		$thumbnail->ration = $ratio;
		$thumbnail->resize = $params->get ( 'resize_profile_image' );
		$thumbnail->crop = $params->get ( 'crop_profile_image' );
		$thumbnails [] = $thumbnail;
		
		$thumbparams->thumbnails = $thumbnails;
		
		$returns = $uploader->thumbnail ( $image, $thumbparams );
		//var_dump($returns);exit;
		

		if ($returns->success > 0) {
			$this->image = $uploadfolder . "/" . $returns->uploaded->filename;
			$this->image = str_replace ( "//", "/", $this->image );
			$this->extension = $returns->uploaded->converted_to;
		
		}
		
		GApplication::message ( $returns->success . " " . JText::_ ( "IMG_UPLOAD_SUCCESS" ) );
		
		return true;
	
	}
	
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check() {
		$datenow = & JFactory::getDate ();
		$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		
		$this->user_id = $filter->clean ( $this->user_id, "INT" );
		$this->address1 = $filter->clean ( $this->address1, "STRING" );
		$this->address2 = $filter->clean ( $this->address2, "STRING" );
		$this->country_id = $filter->clean ( $this->country_id, "INT" );
		$this->region_id = $filter->clean ( $this->region_id, "INT" );
		$this->preferences = $filter->clean ( $this->preferences, "STRING" );
		$this->image = $filter->clean ( $this->image, "STRING" );
		$this->extension = $filter->clean ( $this->extension, "STRING" );
		$this->ordering = $filter->clean ( $this->ordering, "INT" );
		$this->created_date = $filter->clean ( $this->created_date, "STRING" );
		
		return true;
	}
	
	function removeImage($userid) {
		global $option;
		$model = gbimport ( 'listbingo.model.profile' );
		$profile = $model->loadProfile ( $userid );
		$db = JFactory::getDBO ();
		$db->setQuery ( "UPDATE #__gbl_profile SET image='' WHERE user_id=$userid" );
		
		if ($db->query ()) {
			unlink ( JPATH_ROOT . DS . "components" . DS . $option . $profile->image );
			return true;
		} else {
			return false;
		}
	}

}
?>