<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: ad.php 2010-01-10 00:57:37 svn $
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

// Import Joomla! libraries
gbimport ( "gobingoo.model" );

class ListbingoModelAd extends GModel {
	
	var $_count = 0;
	var $_ucount = 0;
	var $_admincount = 0;
	
	function __construct() {
		parent::__construct ();
	}
	
	function hit($id = null) {
		$db = JFactory::getDBO ();
		$query = "UPDATE #__gbl_ads SET views=views+1 WHERE id=$id";
		$db->setQuery ( $query );
		$db->query ();
	}
	
	function getUserAds($published = false, $filter = array()) {
		
		$db = JFactory::getDBO ();
		
		$expirecond = "";
		
		$textcondition = ($filter->searchtxt == 'all') || empty ( $filter->searchtxt );
		
		if (! $textcondition) {
			
			$words = explode ( ' ', $filter->searchtxt );
			
			$wheres = array ();
			
			foreach ( $words as $word ) {
				$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
				$wheres2 = array ();
				
				$wheres2 [] = 'p.title LIKE ' . $word;
				
				if (count ( $wheres2 ) > 0) {
					$wheres [] = implode ( ' OR ', $wheres2 );
				}
			}
			
			if (count ( $wheres ) > 0) {
				$cond [] = '(' . implode ( ') OR (', $wheres ) . ')';
			}
		}
		
		$cond [] = " (p.user_id=" . ( int ) $filter->userid . ")";
		
		if (( int ) $filter->catid) {
			
			$catmodel = gbimport ( "listbingo.model.category" );
			$children = $catmodel->_getChildrens ( ( int ) $filter->catid, ( int ) $filter->access );
			//var_dump($children);
			//$cond [] = " (p.category_id=".(int)$filter->catid.")";
			if (count ( $children ) > 0) {
				$catids = implode ( ",", $children );
				//echo " (p.category_id IN $catids) ";
				$cond [] = " (p.category_id IN ($catids) )";
			}
		
		}
		
		switch (( int ) $filter->status) {
			
			case 0 :
			case 1 :
			case 2 :
			case 3 :
			case 4 :
				$cond [] = " (p.status=" . ( int ) $filter->status . ")";
				break;
			default :
			case - 1 :
				break;
		
		}
		
		$condition = "";
		
		if (count ( $cond ) > 0) {
			$condition = " WHERE " . implode ( " AND ", $cond );
		}
		
		$orderby = 'ORDER BY p.created_date DESC,p.status ASC';
		
		$query = "SELECT p.*,concat(p.id,':',p.title) as id,cat.title as category,p.expiry_date as expiring_date
		FROM #__gbl_ads as p	
		LEFT JOIN #__gbl_categories as cat on cat.id=p.category_id
		$condition $orderby";
		
		$rows = $this->_getList ( $query, $filter->limitstart, $filter->limit );
		
		$this->_ucount = $this->_getListCount ( $query );
		
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				$query1 = "SELECT * FROM #__gbl_ads_images WHERE ad_id='" . $r->id . "'";
				$db->setQuery ( $query1 );
				$r->images = &$db->loadObjectList ();
				
				$db->setQuery ( "SELECT hasprice FROM #__gbl_categories WHERE id='" . $r->category_id . "'" );
				$r->hasprice = $db->loadResult ();
			}
		}
		
		return $rows;
	}
	
	function getUserAdsCount($published = false, $filter = array()) {
		
		return $this->_ucount;
	}
	
	function getList($filter = array()) {
		global $option;
		$db = JFactory::getDBO ();
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		$pubcond = "";
		$cond = array ();
		$flagcond = "";
		if ($filter->flag > 0) {
			$flagcond = "INNER join #__gbl_flag as f on f.item_id=a.id";
		}
		
		switch ($filter->status) {
			
			case 0 :
			case 1 :
			case 2 :
			case 3 :
			case 4 :
				$cond [] = " a.status=$filter->status";
				break;
			case - 1 :
				break;
		
		}
		/*		if($filter->status!="")
		 {
			$cond [] = " a.status=$filter->status";
			}
			*/
		
		if ($filter->newpost > 0) {
			$cond [] = "(TO_DAYS(DATE_ADD(a.created_date, INTERVAL " . $params->get ( 'new_post_assumption' ) . " DAY)) - TO_DAYS(CURDATE()) )>0";
		}
		
		if ($filter->country > 0) {
			$cond [] = " a.country_id=$filter->country";
		}
		
		if ($filter->pricetype > 0) {
			$cond [] = " a.pricetype=$filter->pricetype";
		}
		
		if ($filter->region > 0) {
			$regionmodel = gbimport ( "listbingo.model.region" );
			$regions = $regionmodel->getSubRegion ( $filter->region );
			$regions [] = $filter->region;
			$regioncondition = "";
			if (count ( $regions ) > 0) {
				$regioncondition = implode ( ", ", $regions );
			}
			$cond [] = " a.region_id in ($regioncondition)";
		
		}
		
		if ($filter->category_id > 0) {
			$cond [] = "a.category_id=$filter->category_id";
		
		}
		
		if ($filter->featured > 0) {
			$cond [] = "a.featured=$filter->featured";
		
		}
		
		$textcondition = ($filter->searchtxt == 'all') || empty ( $filter->searchtxt );
		
		if (! $textcondition) {
			
			$words = explode ( ' ', $filter->searchtxt );
			$wheres = array ();
			
			foreach ( $words as $word ) {
				$nativeword = $word;
				$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
				$wheres2 = array ();
				
				if ($params->get ( 'search_adid' )) {
					$wheres2 [] = 'a.globalad_id =\'' . $nativeword . '\'';
				}
				
				if ($params->get ( 'search_title' )) {
					$wheres2 [] = 'a.title LIKE ' . $word;
				}
				
				if ($params->get ( 'search_description' )) {
					$wheres2 [] = 'a.description LIKE ' . $word;
				}
				if ($params->get ( 'search_address' )) {
					$wheres2 [] = 'a.address1 LIKE ' . $word;
					$wheres2 [] = 'a.address2 LIKE ' . $word;
				}
				
				if ($params->get ( 'search_tags' )) {
					$wheres2 [] = 'a.tags LIKE ' . $word;
				}
				if ($params->get ( 'search_metadesc' )) {
					$wheres2 [] = 'a.metadesc LIKE ' . $word;
				}
				
				if ($params->get ( 'search_zipcode' )) {
					$wheres2 [] = 'a.zipcode LIKE ' . $word;
				}
				if ($params->get ( 'search_category' )) {
					$wheres2 [] = 'cat.title LIKE ' . $word;
				}
				
				if ($params->get ( 'search_price' ) && ( int ) $nativeword) {
					
					$wheres2 [] = 'a.price = \'' . $nativeword . '\'';
				}
				
				if (count ( $wheres2 ) > 0) {
					$wheres [] = implode ( ' OR ', $wheres2 );
				}
			}
			if (count ( $wheres ) > 0) {
				$cond [] = '(' . implode ( ') OR (', $wheres ) . ')';
			}
		}
		
		if (count ( $cond ) > 0) {
			$pubcond = " WHERE " . implode ( " AND ", $cond );
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', a.ordering';
		
		$query = "SELECT a.*,a.id as id,cat.title as category,u.email as uemail
		from #__gbl_ads as a			
		left join #__gbl_categories as cat on cat.id=a.category_id
		left join #__users as u on u.id=a.user_id
		$flagcond
		$pubcond $orderby";
		
		$db->setQuery ( $query, $filter->limitstart, $filter->limit );
		$rows = $db->loadObjectList ();
		
		$this->_admincount = $this->_getListCount ( $query );
		
		if (count ( $rows ) > 0) {
			for($i = 0, $n = count ( $rows ); $i < $n; $i ++) {
				$r = $rows [$i];
				$query1 = "SELECT * FROM #__gbl_images WHERE ad_id='" . $r->id . "'";
				$db->setQuery ( $query1 );
				$r->images = &$db->loadObjectList ();
				
				$query2 = "SELECT * FROM #__gbl_flag WHERE item_id='" . $r->id . "'";
				$db->setQuery ( $query2 );
				$r->flag = &$db->loadObjectList ();
			}
		}
		
		return $rows;
	}
	
	function getListCount($filter = array()) {
		return $this->_admincount;
	}
	
	function getAdStats($filter) {
		$db = JFactory::getDBO ();
		$query = "SELECT
		(SELECT count(id) from #__gbl_ads WHERE ((TO_DAYS(DATE_ADD(created_date, INTERVAL " . $filter->params->get ( 'new_post_assumption' ) . " DAY)) - TO_DAYS(CURDATE()) )>0)) as newpostcount,
		(SELECT count(id) from #__gbl_ads WHERE featured='1') as featuredcount,
		(SELECT count(id) from #__gbl_ads) as totalcount,
		(SELECT count(id) from #__gbl_ads WHERE status='1') as publishedcount,
		(SELECT count(id) from #__gbl_ads WHERE status='0') as unpublishedcount
		";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getListForSelect($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where status='1'";
		}
		
		$orderby = ' ORDER BY  ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT id as value, title as text from #__gbl_ads $pubcond $orderby";
		$db->setQuery ( $query );
		return $db->loadAssocList ();
	
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		
		if (count ( $cid ) > 0) {
			foreach ( $cid as $c ) {
				$table = & JTable::getInstance ( 'ad' );
				$table->id = $c;
				$table->status = $publish;
				$table->store ();
			
			}
		
		}
		//$table->publish($cid,$publish);
	

	}
	
	function load($id) {
		$db = JFactory::getDBO ();
		
		$table = JTable::getInstance ( "ad" );
		$table->load ( $id );
		
		$r = $table;
		$query = "SELECT * FROM #__gbl_ads_images WHERE ad_id=$id";
		$db->setQuery ( $query );
		$r->images = $db->loadObjectList ();
		
		return $table;
	
	}
	
	function loadWithFields($id, $infobar = false) {
		$table = JTable::getInstance ( "ad" );
		$table->loadWithFields ( $id, $infobar );
		return $table;
	}
	
	function save($post = null, $images = array(), $fields = array()) {
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		if (isset ( $post ['hasprice'] )) {
			$params->hasprice = $post ['hasprice'];
		}
		
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "ad" );
		$row->load ( $post ['id'] );
		
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ();
		}
		
		if (! $row->check ( $params )) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ( $post )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		
		$this->saveImages ( $images, $row->id );
		
		$attachs = array ();
		
		if (isset ( $fields ['attachments'] ) && ! empty ( $fields ['attachments'] ) && count ( $fields ['attachments'] ) > 0) {
			
			$attachs = $this->saveAttachments ( $fields ['attachments'], $row->id );
			
			unset ( $fields ['attachments'] );
			
			$fields = $fields + $attachs;
		}
		
		if (isset ( $fields ['available_attachments'] ) && ! empty ( $fields ['available_attachments'] ) && count ( $fields ['available_attachments'] ) > 0) {
			$availableattachs = $fields ['available_attachments'];
			unset ( $fields ['available_attachments'] );
			
			$oldattach = array_diff ( $availableattachs, $attachs );
			
			$fields = $fields + $oldattach;
		
		}
		
		$this->saveFields ( $fields, $row->id );
		
		return $row->id;
	}
	
	function remove($cid = array()) {
		
		/*$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_ads where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}*/
		
		if (count ( $cid )) {
			foreach ( $cid as $c ) {
				self::removeUserAd ( $c, null );
			}
		}
		return true;
	
	}
	
	function removeUserAd($adid = null, $userid = null) {
		
		//Get Application
		$app = & JFactory::getApplication ();
		
		$db = JFactory::getDBO ();
		if ($adid) {
			$db->setQuery ( "SELECT id FROM #__gbl_ads_images WHERE ad_id=$adid" );
			$images = $db->loadObjectList ();
			
			$cids = array ();
			foreach ( $images as $i ) {
				$cids [] = $i->id;
			}
			$imageids = "";
			if (count ( $cids ) > 0) {
				$imageids = implode ( ",", $cids );
			}
			
			$configmodel = gbimport ( "listbingo.model.configuration" );
			$params = $configmodel->getParams ();
			
			self::deleteImages ( $adid, $imageids, $params );
			self::removeAdExtrafield ( $adid, $params );
			
			GApplication::triggerEvent ( 'onAdDelete', array ($adid, $userid, $params ) );
			
			//check if the user is admin or not
			if (! $app->isAdmin ()) {
				
				$query = "DELETE from #__gbl_ads where id=$adid AND user_id=$userid";
				$db->setQuery ( $query );
				if (! $db->query ()) {
					throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
				}
				return true;
			
			} else {
				$query = "DELETE from #__gbl_ads where id=$adid";
				$db->setQuery ( $query );
				if (! $db->query ()) {
					throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
				}
				return true;
			}
		
		}
	}
	
	function removeAdExtrafield($adid = null, $params) {
		
		$db = JFactory::getDBO ();
		
		$query = "SELECT af.field_value FROM #__gbl_ads_fields as af " . " INNER JOIN #__gbl_fields as f ON (f.id=af.field_id) " . " WHERE ad_id=$adid AND f.type='attachment'";
		
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		foreach ( $rows as $r ) {
			@unlink ( JPATH_ROOT . $r->field_value );
		}
		
		$query = "DELETE from #__gbl_ads_fields where ad_id=$adid";
		$db->setQuery ( $query );
		if (! $db->query ()) {
			throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
		}
		return true;
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'ad' );
		$groupings = array ();
		
		// update ordering values
		for($i = 0; $i < $total; $i ++) {
			$row->load ( ( int ) $cid [$i] );
			// track categories
			

			if ($row->ordering != $order [$i]) {
				$row->ordering = $order [$i];
				if (! $row->store ()) {
					throw new DataException ( JText::_ ( "NO_ORDER_SAVE" ), 500 );
				}
			}
		}
	
	}
	
	function order($task, $id) {
		
		if ($task == 'orderup') {
			
			$dir = - 1;
		} else {
			$dir = 1;
		}
		$row = & JTable::getInstance ( 'ad' );
		$row->load ( $id );
		
		return $row->move ( $dir, '' );
	
	}
	
	function saveImages($images = null, $id = 0) {
		//var_dump($images);
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		if (is_null ( $images )) {
			return false;
		}
		
		gbimport ( "gobingoo.upload" );
		$uploader = new GUpload ();
		
		$uploader->setFolderPermission ( $params );
		$uploader->setMaxFileSize ( $params->get ( 'maxuploadsize', 204800 ) ); // default size is 200 KB
		//echo $uploader->maxfilesize;
		//exit;
		

		$returnvar = array ();
		
		$thumbparams = new stdClass ();
		$thumbparams->prefix = $params->get ( 'prefix' );
		$thumbparams->saveoriginal = $params->get ( 'saveoriginal' );
		$thumbparams->convert = $params->get ( 'convertto' );
		
		$uploadfolder = $params->get ( 'imagespath' );
		if (strpos ( $uploadfolder, "/" ) == 0) {
			$thumbparams->uploadfolder = JPATH_ROOT . $uploadfolder . DS . $id;
		} else {
			$thumbparams->uploadfolder = JPATH_ROOT . DS . $uploadfolder . DS . $id;
		}
		
		$thumbnails = array ();
		$ratio = $params->get ( 'saveproportion' );
		
		if ($params->get ( 'enable_thumbnail_sml' )) {
			
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_sml' );
			$thumbnail->width = $params->get ( 'width_thumbnail_sml' );
			$thumbnail->height = $params->get ( 'height_thumbnail_sml' );
			$thumbnail->y = $params->get ( 'y_thumbnail_sml' );
			$thumbnail->x = $params->get ( 'x_thumbnail_sml' );
			$thumbnail->ratio = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_sml' );
			$thumbnail->crop = $params->get ( 'crop_thumbnail_sml' );
			$thumbnails [] = $thumbnail;
		}
		
		if ($params->get ( 'enable_thumbnail_mid' )) {
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_mid' );
			$thumbnail->width = $params->get ( 'width_thumbnail_mid' );
			$thumbnail->height = $params->get ( 'height_thumbnail_mid' );
			$thumbnail->y = $params->get ( 'y_thumbnail_mid' );
			$thumbnail->x = $params->get ( 'x_thumbnail_mid' );
			$thumbnail->ratio = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_mid' );
			$thumbnail->crop = $params->get ( 'crop_thumbnail_mid' );
			$thumbnails [] = $thumbnail;
		}
		
		if ($params->get ( 'enable_thumbnail_lrg' )) {
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_lrg' );
			$thumbnail->width = $params->get ( 'width_thumbnail_lrg' );
			$thumbnail->height = $params->get ( 'height_thumbnail_lrg' );
			$thumbnail->y = $params->get ( 'y_thumbnail_lrg' );
			$thumbnail->x = $params->get ( 'x_thumbnail_lrg' );
			$thumbnail->ratio = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_lrg' );
			$thumbnail->crop = $params->get ( 'crop_thumbnail_lrg' );
			$thumbnails [] = $thumbnail;
		}
		
		$thumbparams->thumbnails = $thumbnails;
		
		$returns = $uploader->thumbnailArray ( $images, $thumbparams );
		if ($returns) {
			$baseurl = $uploadfolder . "/" . $id . "/";
			
			if (count ( $returns->uploaded ) > 0) {
				foreach ( $returns->uploaded as $img ) {
					if ($img->uploaded) {
						$imgtable = JTable::getInstance ( 'adimage' );
						$imgtable->ad_id = $id;
						$image = $baseurl . $img->filename;
						$imgtable->image = str_replace ( "//", "/", $image );
						$imgtable->extension = $img->converted_to;
						$imgtable->ordering = $imgtable->getNextOrder ( "ad_id=" . $id );
						$imgtable->published = $params->get ( 'images_autopublish' );
						$imgtable->store ();
					}
				}
				//GApplication::message($returns->success." ".JText::_("IMG_UPLOAD_SUCCESS"));
			}
			
			if ($returns->failed) {
				GApplication::message ( $returns->failed . " " . JText::_ ( "IMG_UPLOAD_FAILED" ) );
			}
		}
		
		return true;
	}
	
	function saveAttachments($attachments = null, $id = 0) {
		//var_dump($images);
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		if (is_null ( $attachments )) {
			return false;
		}
		
		gbimport ( "gobingoo.upload" );
		$uploader = new GUpload ();
		
		$uploader->setFolderPermission ( $params );
		$uploader->setMaxFileSize ( $params->get ( 'maxuploadsize', 204800 ) ); // default size is 200 KB
		//echo $uploader->maxfilesize;
		//exit;
		

		$returnvar = array ();
		
		$attachparams = new stdClass ();
		$attachparams->prefix = $params->get ( 'attach_prefix' );
		
		$uploadfolder = $params->get ( 'attachment_path' );
		if (strpos ( $uploadfolder, "/" ) == 0) {
			$attachparams->uploadfolder = JPATH_ROOT . $uploadfolder . DS . $id;
		} else {
			$attachparams->uploadfolder = JPATH_ROOT . DS . $uploadfolder . DS . $id;
		}
		
		$returns = $uploader->uploadArray ( $attachments, $attachparams );
		
		$baseurl = $uploadfolder . "/" . $id . "/";
		
		$fields = array ();
		
		if (count ( $returns->uploaded ) > 0) {
			foreach ( $returns->uploaded as $att ) {
				
				if ($att->uploaded) {
					$file = $baseurl . $att->filename;
					$fields [$att->fid] = str_replace ( "//", "/", $file );
				
				}
			}
		
		}
		
		if ($returns->failed) {
			GApplication::message ( $returns->failed . " " . JText::_ ( "ATTACH_UPLOAD_FAIL" ) );
		}
		
		return $fields;
	}
	
	function saveFields($fields = null, $id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "DELETE from #__gbl_ads_fields where ad_id='" . $id . "'";
		$db->setQuery ( $query );
		$db->query ();
		
		if (is_null ( $fields )) {
			return false;
		}
		
		if (count ( $fields ) > 0) {
			
			foreach ( $fields as $key => $f ) {
				
				if (is_array ( $f )) {
					foreach ( $f as $x ) {
						$table = JTable::getInstance ( 'adfield' );
						$table->field_id = $key;
						$table->ad_id = $id;
						$table->field_value = $x;
						$table->store ();
					
					}
				} else {
					$table = JTable::getInstance ( 'adfield' );
					$table->field_id = $key;
					$table->ad_id = $id;
					$table->field_value = $f;
					$table->store ();
				
				}
			
			}
		}
		
		return true;
	
	}
	
	function getListWithInfobar($published = false, $filter = array()) {
		
		//var_dump($filter->params);exit;
		$db = JFactory::getDBO ();
		
		$params = $filter->params;
		
		$queryobject = new stdClass ();
		
		$queryobject->fields = array ();
		$queryobject->conditions = array ();
		$queryobject->joins = array ();
		$queryobject->ordering = array ();
		
		$queryobject->fields = array ("a.*", "concat(a.id,':',a.alias) as id", "c.title as country", "cat.title as category", "r.title as region", "u.email as uemail", 'u.name', "u.id as uid", "(select image from #__gbl_ads_images where published='1' and ad_id=a.id order by ordering asc limit 1) as image", "(select extension from #__gbl_ads_images where published='1' and ad_id=a.id order by ordering asc limit 1) as extension" );
		
		$cond = array ();
		
		if ($filter->category_id > 0) {
			
			if (isset ( $filter->access )) {
				$access = $filter->access;
			}
			
			$catmodel = gbimport ( 'listbingo.model.category' );
			$cats = $catmodel->_getChildrens ( $filter->category_id, $access );
			$impcats = implode ( ',', $cats );
			$cond [] = "a.category_id IN ($impcats)";
		
		} else {
			if (! empty ( $filter->catObj )) {
				
				if (count ( $filter->catObj->catid ) > 0) {
					$impcats = implode ( ',', $filter->catObj->catid );
					$cond [] = "a.category_id IN ($impcats)";
				}
			}
		}
		
		if ($published) {
			$cond [] = " a.status=1";
		}
		
		$cond [] = " (a.expiry_date > NOW() || a.expiry_date='" . $db->getNullDate () . "')";
		
		$countries = array ();
		
		if (isset ( $filter->country ) && ! is_array ( $filter->country ) && $filter->country > 0) {
			$filter->country = array ($filter->country );
		}
		
		if (isset ( $filter->country ) && count ( $filter->country ) > 0 && $filter->country > 0) {
			$countries = array_unique ( $filter->country );
			$countrycondition = implode ( ",", $filter->country );
			$cond [] = " a.country_id in ($countrycondition)";
		}
		
		if (isset ( $filter->region ) && ! is_array ( $filter->region ) && $filter->region > 0) {
			$filter->region = array ($filter->region );
		}
		
		if (isset ( $filter->region ) && count ( $filter->region ) > 0 && $filter->region > 0) {
			
			$regionmodel = gbimport ( "listbingo.model.region" );
			$regions = array ();
			foreach ( $filter->region as $r ) {
				
				if ($r > 0) {
					
					$regions [] = ( int ) $r;
					$xregions = $regionmodel->getSubRegion ( $r );
					$regions = array_merge ( $regions, $xregions );
				}
			}
			
			$regioncondition = "";
			if (count ( $regions ) > 0) {
				$regioncondition = implode ( ", ", $regions );
				$cond [] = " a.region_id in ($regioncondition)";
			}
		
		}
		
		if (isset ( $filter->price_from ) && $filter->price_from > 0) {
			$cond [] = " a.price >=" . ( float ) $db->getEscaped ( $filter->price_from, false );
		}
		
		if (isset ( $filter->price_to ) && $filter->price_to > 0) {
			$cond [] = " a.price <=" . ( float ) $db->getEscaped ( $filter->price_to, false );
		}
		
		$textcondition = ($filter->searchtxt == 'all') || empty ( $filter->searchtxt );
		
		if (! $textcondition) {
			
			$words = explode ( ' ', $filter->searchtxt );
			$wheres = array ();
			
			foreach ( $words as $word ) {
				$nativeword = $word;
				$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
				$wheres2 = array ();
				
				if ($params->get ( 'search_title' )) {
					$wheres2 [] = 'a.title LIKE ' . $word;
				}
				
				if ($params->get ( 'search_adid' )) {
					$wheres2 [] = 'a.globalad_id =\'' . $nativeword . '\'';
				}
				
				if ($params->get ( 'search_description' )) {
					$wheres2 [] = 'a.description LIKE ' . $word;
				}
				if ($params->get ( 'search_address' )) {
					$wheres2 [] = 'a.address1 LIKE ' . $word;
					$wheres2 [] = 'a.address2 LIKE ' . $word;
				}
				
				if ($params->get ( 'search_price' ) && ( int ) $nativeword) {
					
					$wheres2 [] = 'a.price = \'' . $nativeword . '\'';
				}
				
				if ($params->get ( 'search_tags' )) {
					$wheres2 [] = 'a.tags LIKE ' . $word;
				}
				if ($params->get ( 'search_metadesc' )) {
					$wheres2 [] = 'a.metadesc LIKE ' . $word;
				}
				
				if ($params->get ( 'search_zipcode' )) {
					$wheres2 [] = 'a.zipcode LIKE ' . $word;
				}
				if ($params->get ( 'search_category' )) {
					$wheres2 [] = 'cat.title LIKE ' . $word;
				}
				
				if ($params->get ( 'search_state' )) {
					$wheres2 [] = 'r.title LIKE ' . $word;
				}
				/*				
				if ($params->get ( 'search_extrafields' )) {
					$wheres2 [] = 'af.field_value LIKE ' . $word;
				}*/
				
				if (! $filter->category_id) {
					if (isset ( $filter->catObj->cattitle ) && is_array ( $filter->catObj->cattitle )) {
						$catcond = array ();
						if (count ( $filter->catObj->cattitle ) > 0) {
							foreach ( $filter->catObj->cattitle as $t ) {
								$t = $db->Quote ( '%' . $db->getEscaped ( $t, true ) . '%', false );
								$catcond [] = 'cat.title LIKE ' . $t;
							}
							
							if (count ( $catcond ) > 0) {
								$wheres2 [] = '((' . implode ( ') OR (', $catcond ) . '))';
							}
						
						}
					}
				}
				
				if (count ( $wheres2 ) > 0) {
					$wheres [] = implode ( ' OR ', $wheres2 );
				}
			}
			if (count ( $wheres ) > 0) {
				$cond [] = '((' . implode ( ') OR (', $wheres ) . '))';
			}
		}
		
		if (isset ( $filter->access )) {
			$cond [] = "cat.access<=" . $db->getEscaped ( $filter->access, true );
		}
		
		$cond [] = "cat.published=1";
		
		//Assign Default Conditions
		$queryobject->conditions = array_merge ( $queryobject->conditions, $cond );
		
		//Assign Default Ordering
		$queryobject->ordering = array ($filter->order . ' ' . $filter->order_dir, 'a.ordering' );
		
		/*$queryobject->joins = array ("LEFT JOIN #__gbl_countries as c on c.id=a.country_id", "LEFT JOIN #__gbl_categories as cat on cat.id=a.category_id", "LEFT JOIN #__gbl_regions as r on r.id=a.region_id", "LEFT JOIN #__users as u on u.id=a.user_id", "LEFT JOIN #__gbl_ads_fields as af on af.ad_id=a.id" );*/
		
		$queryobject->joins = array ("LEFT JOIN #__gbl_countries as c on c.id=a.country_id", "LEFT JOIN #__gbl_categories as cat on cat.id=a.category_id", "LEFT JOIN #__gbl_regions as r on r.id=a.region_id", "LEFT JOIN #__users as u on u.id=a.user_id" );
		
		GApplication::triggerEvent ( "onBuildSearch", array (&$queryobject, &$params ) );
		
		$fields = "*";
		
		if (count ( $queryobject->fields ) > 0) {
			$fields = implode ( ",", $queryobject->fields );
		
		}
		
		$condition = "";
		
		if (count ( $queryobject->conditions ) > 0) {
			$condition = " WHERE " . implode ( " AND ", $queryobject->conditions );
		}
		
		$ordering = "";
		
		if (count ( $queryobject->ordering ) > 0) {
			$ordering = implode ( ",", $queryobject->ordering );
		}
		
		$joins = "";
		
		if (count ( $queryobject->joins ) > 0) {
			$joins = implode ( " ", $queryobject->joins );
		}
		
		$query = "SELECT $fields
		from #__gbl_ads as a
		$joins
		$condition GROUP BY a.id ORDER BY $ordering";
		
		$rows = $this->_getList ( $query, $filter->limitstart, $filter->limit );
		
		$user = JFactory::getUser ();
		
		if (! is_null ( $rows )) {
			$this->_count = $this->_getListCount ( $query );
		}
		
		$aid = ( int ) $user->get ( 'aid', 0 );
		
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				
				$query = "SELECT lf.*, lf.title, lf.type, GROUP_CONCAT( lfs.field_value SEPARATOR ', ' ) as value
				FROM #__gbl_ads_fields AS lfs
				LEFT JOIN #__gbl_fields AS lf ON lfs.field_id = lf.id
				WHERE lfs.ad_id = '" . $r->id . "' AND lf.published='1' and lf.access<=$aid
				GROUP BY lfs.field_id order by lf.ordering";
				
				$db->setQuery ( $query );
				$r->extrafields = $db->loadObjectList ();
				
				$db->setQuery ( "SELECT hasprice FROM #__gbl_categories WHERE id='" . $r->category_id . "'" );
				$r->hasprice = $db->loadResult ();
				
				$address = new stdClass ();
				$address->address = $r->address1;
				$address->street = $r->address2;
				$address->zipcode = $r->zipcode;
				
				$query = "SELECT r.id as rid,r.title as region,p.id pid,p.title as parentregion,c.id as cid,c.title as country from #__gbl_regions as r
		left join #__gbl_regions as p on p.id=r.parent_id
		left join #__gbl_countries as c on c.id=r.country_id
		where r.id=$r->region_id";
				
				$db->setQuery ( $query );
				$obj = $db->loadObject ();
				if ($obj) {
					$address->region = $obj->region;
					$address->state = $obj->parentregion;
					$address->country = $obj->country;
				}
				$r->address = $address;
			}
		}
		//var_dump($rows);exit;
		return $rows;
	}
	
	function getListCountForSearch($published = false, $filter = null) {
		
		return $this->_count;
	}
	
	function resetBasket() {
		
		gbimport ( "gobingoo.basket" );
		
		$basket = GBasket::getInstance ();
		$basket->reset ();
	}
	
	function isPayable($user, &$row = null, $edit, $params = null) {
		global $option;
		if ($edit && ($row->status == 1)) {
			return false;
		}
		
		gbimport ( "gobingoo.basket" );
		
		$basket = GBasket::getInstance ();
		$adpayable = false;
		
		if ($params->get ( 'posting_scheme', 0 ) == 1) {
			$userpostmodel = gbimport ( "listbingo.model.userpost" );
			if (! $userpostmodel->canPost ( $user, $params )) {
				if ($params->get ( 'price_per_post', 0 ) > 0) {
					$item = new stdClass ();
					$item->title = JText::_ ( 'Payment for Posting Ad' );
					$currency = $params->get ( 'default_currency', '$:USD' );
					list ( $item->currencysymbol, $item->currency ) = explode ( ":", $currency );
					$item->price = $params->get ( 'price_per_post', 0 );
					$item->quantity = 1;
					$item->description = JText::_ ( "Payment for Posting Ad" );
					$IPNUrl = "index.php?option=$option&task=ads.update";
					$item->ipr = $IPNUrl;
					$item->referenceid = $row->id;
					$basket->addToBasket ( $item );
					$adpayable = true;
				
				}
			
			}
		
		}
		
		$total = $basket->calculateTotal ();
		
		if ($total > 0) {
			
			$row->adpayable = $adpayable;
			/*$IPNUrl=JRoute::_("index.php?option=$option&task=ads.notify",false);
			 $basket->registerIPR($IPNUrl);*/
			return true;
		} else {
			return false;
		}
	
	}
	
	function isPublished($row) {
		return $row->status === 1;
	}
	
	function getSlug($id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "SELECT title, alias FROM #__gbl_ads WHERE id=$id";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getId($name = '') {
		$db = JFactory::getDBO ();
		
		$query = "SELECT id FROM #__gbl_ads WHERE title='$name'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function publishImages($adid = 0, $imageids = 0) {
		if ($adid && $imageids) {
			$db = JFactory::getDBO ();
			
			$query = "UPDATE #__gbl_ads_images SET published=0 WHERE ad_id=$adid ";
			$db->setQuery ( $query );
			$db->query ();
			
			$query = "UPDATE #__gbl_ads_images SET published=1 WHERE id IN ($imageids) ";
			$db->setQuery ( $query );
			$db->query ();
			
			return true;
		
		} else {
			return false;
		}
	}
	
	function deleteImages($adid = 0, $imageids = 0, $params = null) {
		
		$db = JFactory::getDBO ();
		if ($adid && $imageids) {
			
			$query = "SELECT image, extension FROM #__gbl_ads_images WHERE id IN ($imageids)";
			$db->setQuery ( $query );
			$rows = $db->loadObjectList ();
			
			$smallsfx = $params->get ( 'suffix_thumbnail_sml' );
			$midsfx = $params->get ( 'suffix_thumbnail_mid' );
			$largesfx = $params->get ( 'suffix_thumbnail_lrg' );
			
			foreach ( $rows as $r ) {
				
				@unlink ( JPATH_ROOT . $r->image . $smallsfx . "." . $r->extension );
				@unlink ( JPATH_ROOT . $r->image . $midsfx . "." . $r->extension );
				@unlink ( JPATH_ROOT . $r->image . $largesfx . "." . $r->extension );
				@unlink ( JPATH_ROOT . $r->image . "." . $r->extension );
			}
			
			$query = "DELETE FROM #__gbl_ads_images WHERE id IN ($imageids)";
			$db->setQuery ( $query );
			$db->query ();
			
			return true;
		} else {
			return false;
		}
	}
	
	function close($id = 0) {
		$table = JTable::getInstance ( 'ad' );
		$table->load ( $id );
		
		$table->status = 3;
		if ($table->store ()) {
			return true;
		} else {
			throw new Exception ( JText::_ ( 'Could not close' ), 123 );
		}
	
	}

}
?>
