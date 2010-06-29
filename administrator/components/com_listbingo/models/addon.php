<?php
/**
 * Joomla! 1.5 component LISTBINGO
 *
 * @version $Id: addon.php 2010-01-10 00:57:37 svn $
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

class ListbingoModelAddon extends GModel {
	function __construct() {
		parent::__construct ();
	}
	
	function getList($published = false, $filter = array()) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$orderby = ' ORDER BY ' . $filter->order . ' ' . $filter->order_dir . ', ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT * from #__gbl_addons $pubcond $orderby";
		$db->setQuery ( $query, $filter->limitstart, $filter->limit );
		return $db->loadObjectList ();
	}
	
	function getListCount($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT count(*) from #__gbl_addons $pubcond";
		$db->setQuery ( $query );
		return $db->loadResult ();
	}
	
	function getListForSelect($published = false) {
		$pubcond = "";
		if ($published) {
			$pubcond = " where published='1'";
		}
		
		$orderby = ' ORDER BY  ordering';
		
		$db = JFactory::getDBO ();
		$query = "SELECT id as value, title as text from #__gbl_addons $pubcond $orderby";
		$db->setQuery ( $query );
		return $db->loadAssocList ();
	
	}
	
	function publish($task, $cid) {
		if ($task == 'publish') {
			$publish = '1';
		} else {
			$publish = '0';
		}
		$table = & JTable::getInstance ( 'addon' );
		
		return $table->publish ( $cid, $publish );
	
	}
	
	function load($id) {
		$table = JTable::getInstance ( "addon" );
		$table->load ( $id );
		return $table;
	
	}
	
	function save($post = null) {
		
		if (! is_array ( $post )) {
			throw new DataException ( JText::_ ( "INVALID_DATA" ), 400 );
		}
		
		$row = JTable::getInstance ( "addon" );
		if (! $row->bind ( $post )) {
			throw new DataException ( JText::_ ( "NO_BIND" ) . $row->getError (), 401 );
		}
		
		if (! $row->id) {
			$row->ordering = $row->getNextOrder ();
		}
		
		if (! $row->check ()) {
			throw new DataException ( $row->getError (), 402 );
		}
		
		if (! $row->store ( $post )) {
			throw new DataException ( JText::_ ( "NO_SAVE" ) . $row->getError (), 402 );
		}
		
		return $row->id;
	}
	
	function remove($cid = array()) {
		global $option;
		
		$db = JFactory::getDBO ();
		if (count ( $cid )) {
			
			$installer = & JInstaller::getInstance ();
			$adaptherPath = JPATH_ADMINISTRATOR . DS . "components" . DS . $option . DS . "libraries" . DS . "adapters" . DS . "addon.php";
			require_once ($adaptherPath);
			$adapterobj = new JInstallerAddon ( $installer );
			
			$installer->setAdapter ( 'addon', $adapterobj );
			
			foreach ( $cid as $c ) {
				
				$installer->uninstall ( 'addon', $c, 0 );
			
			}
			
			$cids = implode ( ',', $cid );
			$query = "DELETE from #__gbl_addons where id in ($cids)";
			$db->setQuery ( $query );
			if (! $db->query ()) {
				throw new DataException ( JText::_ ( "NO_DELETE" ), 400 );
			}
			return true;
		}
	}
	
	function saveorder($cid, $order, $total) {
		$db = & JFactory::getDBO ();
		$row = & JTable::getInstance ( 'addon' );
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
		$row = & JTable::getInstance ( 'addon' );
		$row->load ( $id );
		
		return $row->move ( $dir, '' );
	
	}
	
	function rebuild() {
		global $option;
		
		$newxmlstring = "<metadata></metadata>";
		$newxml = & JFactory::getXMLParser ( 'Simple' );
		$newxml->loadSTring ( $newxmlstring );
		
		if (isset ( $newxml->document )) {
			$newxml->document->addChild ( "menu" );
			$tmp = $newxml->document->getElementByPath ( "menu" );
		}
		
		$options = $tmp->addChild ( "options", array ("var" => "task" ) );
		
		$basemenuxmlpath = JPATH_ROOT . DS . "components" . DS . $option . DS . "menu.xml";
		$xpath = "menuitems";
		
		if (file_exists ( $basemenuxmlpath )) {
			$xml = & JFactory::getXMLParser ( 'Simple' );
			if ($xml->loadFile ( $basemenuxmlpath )) {
				if (isset ( $xml->document )) {
					$result = $xml->document->getElementByPath ( $xpath );
				}
			}
			
			$children = $result->children ();
			if (count ( $children ) > 0) {
				foreach ( $children as &$child ) {
					$options->addChild ( $child->name (), $child->attributes () );
				}
			
			}
		
		}
		
		$basepath = JPATH_ADMINISTRATOR . DS . 'components' . DS . $option . DS . 'addons';
		if (is_dir ( $basepath )) {
			$folders = JFolder::folders ( $basepath, '.', false, true );
			if (count ( $folders ) > 0) {
				foreach ( $folders as $f ) {
					$files = JFolder::files ( $f, ".xml", false, true );
					if (count ( $files ) > 0) {
						foreach ( $files as $file ) {
							if (file_exists ( $file )) {
								$adxml = & JFactory::getXMLParser ( 'Simple' );
								if ($adxml->loadFile ( $file )) {
									if (isset ( $adxml->document )) {
										$adresult = $adxml->document->getElementByPath ( $xpath );
									}
								}
								if ($adresult) {
									$adchildren = $adresult->children ();
									if (count ( $adchildren ) > 0) {
										foreach ( $adchildren as &$adchild ) {
											$options->addChild ( $adchild->name (), $adchild->attributes () );
										}
									
									}
								}
							
							}
						}
					}
				
				}
			}
		}
		
		$states = $newxml->document->addChild ( "state", array ("switch" => "task" ) );
		
		if (file_exists ( $basemenuxmlpath )) {
			$xpath = "state";
			$xml = & JFactory::getXMLParser ( 'Simple' );
			if ($xml->loadFile ( $basemenuxmlpath )) {
				if (isset ( $xml->document )) {
					$result = $xml->document->getElementByPath ( $xpath );
				}
			}
			
			$children = $result->children ();
			if(count($children)>0)
			{
				foreach($children as $child)
				{
					$states->_children[]=$child;
				}
			}	
			
		}
		
		
		
		$metadatapath = JPATH_ROOT . DS . "components" . DS . $option . DS . "metadata.xml";
		
		return JFile::write ( $metadatapath, $newxml->document->toString () );
	
	}
}
?>