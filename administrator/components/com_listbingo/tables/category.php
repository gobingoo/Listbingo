<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: category.php 2010-01-10 00:57:37 svn $
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
class JTableCategory extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $title = null;
	
	var $hasprice = null;
	
	var $alias = null;
	
	var $logo = null;
	
	var $parent_id = null;
	
	var $description = null;
	
	var $published = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	var $access = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_categories', 'id', $db );
	}
	
	function load($id = 0) {
		global $option;
		
		parent::load ( $id );
		if (empty ( $this->logo )) {
			$basepath = "administrator/components/$option/images/nologo.png";
			$this->logo = $basepath;
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT related as value from #__gbl_related_categories where catid=$this->id";
		$db->setQuery ( $query );
		$this->related = $db->loadObjectList ();
	
	}
	
/*	function store($logo, $params, $related = null) {
		self::saveLogo ( $logo, $params );
		$el = parent::store ();
		self::saveRelatedCategories ( $related );
		return $el;
	}*/
	
	function store($logo, $params, $related = null) {	
		
		self::saveLogo ( $logo, $params );
		self::saveRelatedCategories ( $related );
		parent::store ();
		
		return $this->id;
	
	}
	
	function saveRelatedCategories($related) {
		
		if ($this->id) {
			
			$db = JFactory::getDBO ();
			$query = "DELETE  from #__gbl_related_categories where catid=$this->id";
			
			$db->setQuery ( $query );
			$db->query ();
			if (count ( $related ) > 0) {
				
				foreach ( $related as $r ) {
					$relatedtable = JTable::getInstance ( 'relatedcategory' );
					$relatedtable->catid = $this->id;
					$relatedtable->related = $r;
					$relatedtable->store ();
				
				}
			}
		
		}
	}
	
	function saveLogo($image = null, $params) {
		
		global $option;
		
		if (is_null ( $image ) || empty ( $image ['name'] )) {
			return false;
		}
		
		//Delete previous files
		if ($this->id) {
			
			if (! empty ( $obj->logo )) {
				
				$db = JFactory::getDBO ();
				$query = "SELECT logo from #__gbl_categories where id=$this->id";
				$db->setQuery ( $query );
				$obj = $db->loadObject ();
				
				if (strpos ( $obj->logo, "/" ) == 0) {
					$logo = str_replace ( "/", DS, $obj->logo );
					@unlink ( JPATH_ROOT . $logo );
				} else {
					$logo = str_replace ( "/", DS, $obj->logo );
					@unlink ( JPATH_ROOT . DS . $logo );
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
		$thumbparams->convert = $params->get ( 'category_convertto' );
		
		$uploadfolder = $params->get ( 'path_category_logo' );
		if (strpos ( $uploadfolder, "/" ) == 0) {
			$thumbparams->uploadfolder = JPATH_ROOT . $uploadfolder;
		} else {
			$thumbparams->uploadfolder = JPATH_ROOT . DS . $uploadfolder;
		}
		
		$thumbnails = array ();
		$ratio = $params->get ( 'saveproportions' );
		
		$thumbnail = new stdClass ();
		$thumbnail->suffix = $params->get ( 'suffix_category_logo' );
		$thumbnail->width = $params->get ( 'width_category_logo' );
		$thumbnail->height = $params->get ( 'height_category_logo' );
		$thumbnail->y = $params->get ( 'y_category_logo' );
		$thumbnail->x = $params->get ( 'x_category_logo' );
		$thumbnail->ration = $ratio;
		$thumbnail->resize = $params->get ( 'resize_category_logo' );
		$thumbnail->crop = $params->get ( 'crop_category_logo' );
		$thumbnails [] = $thumbnail;
		
		$thumbparams->thumbnails = $thumbnails;
		
		$returns = $uploader->thumbnail ( $image, $thumbparams );
		//var_dump($returns);exit;
		

		if ($returns->success > 0) {
			
			$this->logo = $uploadfolder . "/" . $returns->uploaded->filename . $thumbnail->suffix . "." . $returns->uploaded->converted_to;
			$this->logo = str_replace ( "//", "/", $this->logo );
		
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
		
		$db = JFactory::getDBO ();
		
		if (empty ( $this->alias )) {
			$this->alias = $this->title;
		}
		$this->alias = JFilterOutput::stringURLSafe ( $this->alias );
		
		if (trim ( str_replace ( '-', '', $this->alias ) ) == '') {
			
			$this->alias = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		}
		
		$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		if (trim ( str_replace ( '&nbsp;', '', $this->description ) ) == '') {
			$this->description = '';
		}
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		$this->title = $filter->clean ( $this->title, "STRING" );
		$this->hasprice = $filter->clean ( $this->hasprice, "INT" );
		$this->alias = $filter->clean ( $this->alias, "STRING" );
		/*$this->logo = $filter->clean ( $this->logo, "STRING" );*/
		$this->parent_id = $filter->clean ( $this->parent_id, "STRING" );
		$this->description = $filter->clean ( $this->description, "STRING" );
		$this->published = $filter->clean ( $this->published, "INT" );
		$this->ordering = $filter->clean ( $this->ordering, "INT" );
		$this->created_date = $filter->clean ( $this->created_date, "STRING" );
		$this->access = $filter->clean ( $this->access, "INT" );
		
		return true;
	}

}
?>