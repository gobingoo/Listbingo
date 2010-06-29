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

// Import Joomla! libraries
gbimport ( "gobingoo.model" );
jimport ( 'joomla.filter.input' );

class ListbingoModelCategory extends GModel {
	var $_count;
	
	var $_pagination = null;
	
	function __construct() {
		parent::__construct ();
	}
	
	function getPriceTypeCategories() {
		$db = JFactory::getDBO ();
		$query = "SELECT id,hasprice FROM #__gbl_categories WHERE published='1'";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function getListForProduct($published = false, $filter = array()) {
		
		$configmodel = gbimport ( "listbingo.model.configuration" );
		$params = $configmodel->getParams ();
		
		$pubcond = "";
		$condition = array ();
		if ($published) {
			$condition [] = " c.published='1'";
		}
		
		if (isset ( $filter->access )) {
			$condition [] = " c.access<=$filter->access";
		}
		
		if (count ( $condition ) > 0) {
			$pubcond = "AND " . implode ( " AND ", $condition );
		}
		
		$orderby = ' ORDER BY c.parent_id asc' . $filter->order_dir . ",c.ordering ASC";
		
		$db = JFactory::getDBO ();
		if ($filter->catid) {
			$query = "SELECT c.*,c.title as name,concat(c.id,':',c.alias) as slug,c.parent_id as parent,
			(SELECT count(*) FROM #__gbl_ads WHERE category_id=" . $filter->catid . ") as pcount
			FROM #__gbl_categories as c WHERE id='" . $filter->catid . "'
			$pubcond $orderby";
		} else {
			$query = "SELECT c.*,c.title as name,concat(c.id,':',c.alias) as slug,c.parent_id as parent, 0 as pcount 
			FROM #__gbl_categories as c WHERE parent_id=0 $pubcond $orderby";
		
		}
		
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		if (count ( $rows ) > 0) {
			$n = count ( $rows );
			for($i = 0; $i < $n; $i ++) {
				$r = $rows [$i];
				$accesscond = "";
				if (isset ( $filter->access )) {
					$accesscond = " AND access<=$filter->access";
				}
				
				$query2 = "SELECT *,concat(id,':',alias) as slug FROM #__gbl_categories WHERE parent_id='" . $r->id . "' AND published=1 $accesscond ORDER BY ordering ASC";
				$db->setQuery ( $query2 );
				$r->child = $db->loadObjectList ();
				
				if (count ( $r->child ) > 0) {
					$m = count ( $r->child );
					
					for($j = 0; $j < $m; $j ++) {
						$a = $r->child [$j];
						$a->adcat2 = $this->_getChildrens ( $a->id, $filter->access );
					}
				}
				
				if ($filter->catid) {
					$r->adcat = $this->_getChildrens ( $filter->catid, $filter->access );
				} else {
					
					$r->adcat = $this->_getChildrens ( $r->id, $filter->access );
				}
			
			}
		
		}
		
		return $rows;
	
	}
	
	function getList($published = false, $filter = array()) {
		global $mainframe;
		$pubcond = "";
		if ($published) {
			$pubcond = " where c.published='1'";
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ",c.parent_id asc,c.ordering";
		
		$db = JFactory::getDBO ();
		$query = "SELECT c.*,c.title as name,concat(id,':',alias) as alias, c.parent_id as parent from #__gbl_categories as c
		$pubcond $orderby";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		$children = array ();
		// first pass - collect children
		foreach ( $rows as $v ) {
			$pt = $v->parent;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			$children [$pt] = $list;
		}
		// second pass - get an indent list of the items
		$list = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, max ( 0, $filter->levellimit - 1 ) );
		//$list = JHTML::_('menu.treerecurse', 0, '', array(), $children, max( 0, $levellimit-1 ) );
		$newlist = array ();
		foreach ( $list as $item ) {
			$newlist [] = $item;
		}
		
		$total = count ( $newlist );
		
		jimport ( 'joomla.html.pagination' );
		$this->_pagination = new JPagination ( $total, $filter->limitstart, $filter->limit );
		
		// slice out elements based on limits
		$newlist = array_slice ( $newlist, $this->_pagination->limitstart, $this->_pagination->limit );
		
		return $newlist;
	
	}
	
	function getListCount($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) from #__gbl_categories $pubcond";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function &getPagination() {
		if ($this->_pagination == null) {
			$this->getItems ();
		}
		
		return $this->_pagination;
	}
	
	function getListForSelect($published = false, $id = 0, $rootonly = true, $type = null) {
		$pubcond = "";
		if ($published) {
			$pubcond = " and published='1'";
		}
		
		$orderby = ' ORDER BY  ordering';
		$rootcond = "";
		if ($rootonly) {
			$rootcond = " and parent_id=0";
		}
		$typecond = "";
		if (! is_null ( $type )) {
			
			$typecond = " and type_id in ($type)";
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT id as value, title as text,type_id from #__gbl_categories where id !=$id $pubcond $rootcond $typecond $orderby";
		$db->setQuery ( $query );
		return $db->loadAssocList ();
	
	}
	
	function getTreeForSelect($published = false, $filter = array()) {
		$wheres = array ();
		
		// If a not a new item, lets set the menu item id
		if ($filter->id) {
			$wheres [] = ' c.id != ' . ( int ) $filter->id;
		} else {
			$wheres [] = ' c.id != ' . ( int ) $filter->id;
		}
		
		if ($published) {
			$wheres [] = " c.published='1'";
		}
		
		if (count ( $wheres ) > 0) {
			$cond = " WHERE " . implode ( " AND ", $wheres );
		}
		
		$orderby = ' ORDER BY c.parent_id asc,c.ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT c.*, c.id as value,c.title as name,c.parent_id as parent from #__gbl_categories as c
		$cond $orderby";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		$children = array ();
		// first pass - collect children
		foreach ( $rows as $v ) {
			$pt = $v->parent_id;
			$list = @$children [$pt] ? $children [$pt] : array ();
			array_push ( $list, $v );
			/*if($filter->id && $v->parent_id==$filter->parent_id && $filter->parent_id>=0)
			 {

			 }
			 else
			 {
				$children[$pt] = $list;
				}*/
			$children [$pt] = $list;
		}
		// second pass - get an indent list of the items
		$list = JHTML::_ ( 'menu.treerecurse', 0, '', array (), $children, 9999, 0, 0 );
		$newlist = array ();
		foreach ( $list as $item ) {
			
			$newlist [] = $item;
		
		}
		
		return $newlist;
	
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		$table = & JTable::getInstance ( 'category' );
		
		return $table->publish ( $cid, $publish );
	
	}
	
	function load($id) {
		$table = JTable::getInstance ( "category" );
		$table->load ( $id );
		return $table;
	
	}
	
	function save($post = null, $file = null, $params = null) {
		
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$related = $post ['related'];
		
		$row = JTable::getInstance ( "category" );
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ( 'parent_id=' . $row->parent_id );
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ( $file, $params, $related )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		
		//$this->saveImages($images,$row->id);
		

		return $row->id;
	}
	
	function remove($cid = array()) {
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			$cids = implode ( ',', $cid );
			
			$db->setQuery ( "SELECT * FROM #__gbl_categories WHERE id not IN ($cids) AND parent_id IN ($cids)" );
			if ($db->loadResult ()) {
				throw new DataException ( JText::_ ( "LISTBINGO_DELETE_CATEGORY_SELECT_CHIDLS" ), 400 );
			}
			
			$query = "DELETE from #__gbl_categories where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'category' );
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
		$row = & JTable::getInstance ( 'category' );
		$row->load ( $id );
		
		return $row->move ( $dir, 'parent_id=' . $row->parent_id );
	
	}
	
	function getExtrafields($cid = 0, $id = 0, $published = true) {
		$pubcond = "";
		if ($published) {
			$pubcond = " and f.published='1'";
		
		}
		$query = "SELECT f.* from #__gbl_fields as f left join #__gbl_categories_fields as cf on cf.field_id=f.id where cf.category_id='$cid' $pubcond order by ordering";
		$db = JFactory::getDBO ();
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		if (count ( $rows ) > 0) {
			
			foreach ( $rows as &$r ) {
				
				$query = "SELECT field_value  from #__gbl_ads_fields where field_id='$r->id' and ad_id='$id'";
				$db->setQuery ( $query );
				$fields = $db->loadResultArray ();
				if (count ( $fields ) > 0) {
					$r->field_value = $fields;
					if (count ( $fields ) < 2) {
						$r->field_value = $fields [0];
					}
				} else {
					$r->field_value = $r->default_value;
				}
			
			}
		}
		
		return $rows;
	}
	
	function saveImages($images = null, $id = 0) {
		
		global $option;
		$params = &JComponentHelper::getParams ( $option );
		
		if (is_null ( $images )) {
			return false;
		}
		
		gbimport ( "gobingoo.upload" );
		$uploader = new GUpload ();
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
		$ratio = $params->get ( 'saveproportions' );
		
		if ($params->get ( 'enable_thumbnail_sml' )) {
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_sml' );
			$thumbnail->width = $params->get ( 'width_thumbnail_sml' );
			$thumbnail->height = $params->get ( 'height_thumbnail_sml' );
			$thumbnail->y = $params->get ( 'y_thumbnail_sml' );
			$thumbnail->x = $params->get ( 'x_thumbnail_sml' );
			$thumbnail->ration = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_sml' );
			$thumbnails [] = $thumbnail;
		}
		
		if ($params->get ( 'enable_thumbnail_mid' )) {
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_mid' );
			$thumbnail->width = $params->get ( 'width_thumbnail_mid' );
			$thumbnail->height = $params->get ( 'height_thumbnail_mid' );
			$thumbnail->y = $params->get ( 'y_thumbnail_mid' );
			$thumbnail->x = $params->get ( 'x_thumbnail_mid' );
			$thumbnail->ration = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_mid' );
			$thumbnails [] = $thumbnail;
		}
		
		if ($params->get ( 'enable_thumbnail_lrg' )) {
			$thumbnail = new stdClass ();
			$thumbnail->suffix = $params->get ( 'suffix_thumbnail_lrg' );
			$thumbnail->width = $params->get ( 'width_thumbnail_lrg' );
			$thumbnail->height = $params->get ( 'height_thumbnail_lrg' );
			$thumbnail->y = $params->get ( 'y_thumbnail_lrg' );
			$thumbnail->x = $params->get ( 'x_thumbnail_lrg' );
			$thumbnail->ration = $ratio;
			$thumbnail->resize = $params->get ( 'resize_thumbnail_lrg' );
			$thumbnails [] = $thumbnail;
		}
		
		$thumbparams->thumbnails = $thumbnails;
		
		$returns = $uploader->thumbnailArray ( $images, $thumbparams );
		
		if (count ( $returns->uploaded ) > 0) {
			foreach ( $returns->uploaded as $img ) {
				$table = JTable::getInstance ( 'category' );
				$table->id = $id;
				$imgtable->logo = $img->filename;
				$table->extension = $img->extension;
				$table->store ();
			}
		}
		
		GApplication::message ( $returns->success . " " . JText::_ ( "IMG_UPLOAD_SUCCESS" ) );
		
		return true;
	
	}
	
	function getAllParents($id = null) {
		
		$db = JFactory::getDBO ();
		
		$query = "SELECT c.id as cid, c.title as ctitle, c.description as cdesc,p.id, p.title, p.description
		FROM #__gbl_categories as c
		LEFT JOIN #__gbl_categories as p ON (c.parent_id=p.id) WHERE c.id=$id";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	}
	
	function _getParents($id) {
		$parents = array ();
		$db = JFactory::getDBO ();
		$query = "SELECT id,title,parent_id from #__gbl_categories where id=$id";
		$db->setQuery ( $query );
		$obj = $db->loadObject ();
		if ($obj) {
			$parents [] = $obj;
			return array_merge ( $parents, self::_getParents ( $obj->parent_id ) );
		} else {
			return $parents;
		}
	}
	
	function _getChildrens($cid, $access = 0) {
		$childrens = array ();
		$childrens [] = $cid;
		if ($cid == 0) {
			return false;
		}
		$db = JFactory::getDBO ();
		$query = "SELECT id from #__gbl_categories where parent_id=$cid and access<=$access and published='1' order by ordering ASC";
		$db->setQuery ( $query );
		$rows = $db->loadResultArray ();
		if (count ( $rows ) > 0) {
			foreach ( $rows as &$r ) {
				//$childrens[]=$r;
				$childrens = array_merge ( $childrens, self::_getChildrens ( $r, $access ) );
			
			}
		}
		
		return $childrens;
	
	}
	
	function _countTotalProducts($filter) {
		$db = JFactory::getDBO ();
		
		$configmodel = gbimport ( 'listbingo.model.configuration' );
		$params = $configmodel->getParams ();
		$regmodel = gbimport ( "listbingo.model.region" );
		$pubcond = "";
		$cond = array ();
		
		$cond [] = " (a.expiry_date > NOW() || a.expiry_date='" . $db->getNullDate () . "')";
		
		if (isset ( $filter->access )) {
			$condition = " AND cat.access<=$filter->access";
		}
		
		if ((isset ( $filter->country ) && $filter->country > 0)) {
			
			$cond [] = "(a.country_id=" . $filter->country . ")";
		}
		
		if (isset ( $filter->region ) && ! is_array ( $filter->region )) {
			$filter->region = array ($filter->region );
		}
		
		if (isset ( $filter->region ) && count ( $filter->region ) > 0) {
			
			$regionmodel = gbimport ( "listbingo.model.region" );
			$regions = array ();
			foreach ( $filter->region as $r ) {
				if ($r > 0) {
					$regions [] = $r;
					$xregions = $regionmodel->getSubRegion ( $r );
					$regions = array_merge ( $regions, $xregions );
				}
			}
			$regioncondition = "";
			if (count ( $regions ) > 0) {
				$regioncondition = implode ( ", ", $regions );
				$cond [] = "(a.region_id  in (" . $regioncondition . "))";
			}
		
		}
		
		if (count ( $cond ) > 0) {
			$pubcond = " AND " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT	cat.title, cat.id, " . "(" . "SELECT	count(*) " . "FROM	#__gbl_ads as a " . "WHERE	a.category_id = cat.id AND a.status=1 $pubcond" . ") AS adCount " . "FROM	#__gbl_categories as cat WHERE published=1 $condition";
		$db->setQuery ( $query );
		return $db->loadObjectList ();
	
	}
	
	function getSlug($id = 0) {
		$db = JFactory::getDBO ();
		
		$query = "SELECT id,title, alias FROM #__gbl_categories WHERE id=$id";
		$db->setQuery ( $query );
		$slug = "";
		$category = $db->loadObject ();
		if ($category) {
			
			$slug = strtolower ( $category->alias );
			$slug = JFilterOutput::stringURLSafe ( $slug );
			
			$slug = $category->id . ":" . $slug;
		
		}
		
		return $slug;
	
	}
	
	function getId($name = '') {
		$db = JFactory::getDBO ();
		
		$query = "SELECT id FROM #__gbl_categories WHERE title='$name'";
		$db->setQuery ( $query );
		return $db->loadObject ();
	}
	
	function getCategories($published = 1, $filter = null) {
		
		$condition = "";
		
		$cond = array ();
		
		if ($published) {
			
			$cond [] = " cat.published=1";
		}
		
		if (isset ( $filter->access )) {
			$cond [] = " cat.access<=" . $filter->access;
		}
		
		if (count ( $cond ) > 0) {
			
			$condition = " WHERE " . implode ( " AND ", $cond );
		}
		
		$expirycondition = "";
		
		$query = "SELECT cat.*,(select count(*) from #__gbl_ads where category_id=cat.id and status='1' $expirycondition ) as adcount from #__gbl_categories as cat $condition";
		$rows = $this->_getList ( $query );
		
		$categorytree = array ();
		if (count ( $rows ) > 0) {
			foreach ( $rows as $r ) {
				$categorytree [$r->id] = $r;
				$categorytree [$r->id]->totalcount = $r->adcount;
				if ($r->parent_id > 0) {
					$categorytree [$r->parent_id]->children [] = $r;
					$categorytree [$r->parent_id]->totalcount += $r->adcount;
				
				}
			
			}
		
		}
		
		if (isset ( $filter->catid )) {
			$returntree = array ();
			$returntree = $categorytree [$filter->catid];
			/*	echo "<pre>";
			print_r ( $returntree );
			echo "</pre>";*/
		} else {
			/*echo "<pre>";
			print_r ( $categorytree );
			echo "</pre>";*/
		}
	
	}
	
	function find(&$title = null, $access = 0) {
		global $option;
		
		$replacearray = array ('in', 'of', 'over', 'on', 'near', '+', 'and', 'or' );
		$tmpwords = explode ( "+", $title );
		
		$tmpwords = implode ( " + ", $tmpwords );
		$filterwords = explode ( " ", $tmpwords );
		$filterwords = array_filter ( $filterwords );
		
		$filterkey = array_diff ( $filterwords, $replacearray );
		
		$db = JFactory::getDBO ();
		
		$wheres = array ();
		$cond = array ();
		$condition = "";
		
		foreach ( $filterkey as $word ) {
			$word = $db->Quote ( '%' . $db->getEscaped ( $word, true ) . '%', false );
			$wheres [] = 'title LIKE ' . $word;
		}
		
		if (count ( $wheres ) > 0) {
			$cond [] = '(' . implode ( ') OR (', $wheres ) . ')';
		}
		
		$cond [] = " published='1'";
		
		$cond [] = " access<=$access ";
		
		if (count ( $cond ) > 0) {
			$condition = " WHERE " . implode ( " AND ", $cond );
		}
		
		$query = "SELECT id, title FROM #__gbl_categories $condition";
		$db->setQuery ( $query );
		$rows = $db->loadObjectList ();
		
		$catid = array ();
		$cattitle = array ();
		
		$catobj = new stdClass ();
		
		if (count ( $rows ) > 0) {
			foreach ( $rows as $r ) {
				$catx = self::_getChildrens ( $r->id, $access );
				$catid [] = $r->id;
				if (count ( $catx ) > 0) {
					$catid = array_merge ( $catid, $catx );
				}
			
			}
			$catid = array_unique ( $catid );
			
			$cattitle = self::_getChildrensTitle ( $catid );
			
			$catobj->catid = $catid;
			
			$catobj->cattitle = array_unique ( $cattitle );
			
			return $catobj;
		
		} else {
			return false;
		}
	
	}
	
	function _getChildrensTitle($cid = array()) {
		
		if (count ( $cid ) < 1) {
			return false;
		}
		
		$db = JFactory::getDBO ();
		
		$catids = implode ( ",", $cid );
		
		$query = "SELECT title from #__gbl_categories where id in ($catids) order by ordering ASC";
		$db->setQuery ( $query );
		$rows = $db->loadResultArray ();
		
		return $rows;
	
	}

}
?>