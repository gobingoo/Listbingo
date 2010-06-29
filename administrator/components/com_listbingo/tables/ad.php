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
gbimport ( "gobingoo.table" );
// Include library dependencies
jimport ( 'joomla.filter.input' );

/**
 * Table class
 *
 * @package          Joomla
 * @subpackage		LISTBINGO
 */
class JTableAd extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $globalad_id = null;
	
	var $title = null;
	
	var $pricetype = null;
	
	var $currency = null;
	
	var $currencycode = null;
	
	var $price = null;
	
	var $alias = null;
	
	var $email = null;
	
	var $region_id = null;
	
	var $country_id = null;
	
	var $zipcode = null;
	
	var $address1 = null;
	
	var $address2 = null;
	
	var $description = null;
	
	var $ordering = null;
	
	var $created_date = null;
	
	var $status = null;
	
	var $hascalendar = null;
	
	var $featured = null;
	
	var $category_id = null;
	
	var $views = null;
	
	var $tags = null;
	
	var $metadesc = null;
	
	var $user_id = null;
	
	var $expiry_date = null;
	
	var $modified_date = null;
	
	var $show_contact = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_ads', 'id', $db );
	}
	
	/**
	 * Overloaded check method to ensure data integrity
	 *
	 * @access public
	 * @return boolean True on success
	 */
	function check($params = null) {
		
		$datenow = & JFactory::getDate ();
		
		$db = JFactory::getDBO ();
		
		$error = array ();
		
		if (empty ( $this->title )) {
			$error [] = JText::_ ( 'Ad must have a title' );
		
		}
		
		if ($params->get ( 'enable_field_address1' ) && $params->get ( 'required_field_address1' ) && empty ( $this->address1 )) {
			$error [] = JText::_ ( 'Address1 is required and must be filled' );
		}
		
		if ($params->get ( 'enable_field_address2' ) && $params->get ( 'required_field_address2' ) && empty ( $this->address2 )) {
			$error [] = JText::_ ( 'Address1 is required and must be filled' );
		}
		
		if ($params->get ( 'enable_field_metadesc' ) && $params->get ( 'required_field_metadesc' ) && empty ( $this->metadesc )) {
			$error [] = JText::_ ( 'Meta desc is required and must be filled' );
		}
		
		if ($params->get ( 'enable_field_tags' ) && $params->get ( 'required_field_tags' ) && empty ( $this->tags )) {
			$error [] = JText::_ ( 'Tag is required and must be filled' );
		}
		
		if (empty ( $this->metadesc )) {
			$this->metadesc = GHelper::truncate ( $this->description, 255, '' );
		}
		
		if ($params->get ( 'enable_field_price' )) {
			if (isset ( $params->hasprice ) && $params->hasprice) {
				
				if (empty ( $this->pricetype )) {
					$error [] = JText::_ ( 'Price type must be selected' );
				
				} else {
					if ($this->pricetype == 1) {
						if (empty ( $this->price ) || empty ( $this->currency )) {
							$error [] = JText::_ ( 'Currency and price must be provided' );
						}
					}
				}
			}
		}
		
		if (count ( $error ) > 0) {
			$this->setError ( implode ( "<br />", $error ) );
			return false;
		}
		
		if (empty ( $this->alias )) {
			$this->alias = $this->title;
		}
		
		if ($params->get ( 'enable_email_replacement' )) {
			$this->title = GHelper::obsfucateEmail ( $this->title, $params->get ( 'email_replace_text' ) );
			$this->price = GHelper::obsfucateEmail ( $this->price, $params->get ( 'email_replace_text' ) );
			$this->zipcode = GHelper::obsfucateEmail ( $this->zipcode, $params->get ( 'email_replace_text' ) );
			$this->address1 = GHelper::obsfucateEmail ( $this->address1, $params->get ( 'email_replace_text' ) );
			$this->address2 = GHelper::obsfucateEmail ( $this->address2, $params->get ( 'email_replace_text' ) );
			$this->description = GHelper::obsfucateEmail ( $this->description, $params->get ( 'email_replace_text' ) );
			$this->tags = GHelper::obsfucateEmail ( $this->tags, $params->get ( 'email_replace_text' ) );
			$this->metadesc = GHelper::obsfucateEmail ( $this->metadesc, $params->get ( 'email_replace_text' ) );
		}
		
		if ($params->get ( 'enable_badword_filter' )) {
			
			gbimport ( "listbingo.filter" );
			$filter = new ListbingoFilter ();
			
			$filter->strings = NULL;
			if ($params->get ( 'bad_keywords' ) != "") {
				$filter->strings = explode ( ",", $params->get ( 'bad_keywords' ) );
			}
			$filter->keep_first_last = false;
			
			if ($params->get ( 'enable_inside_filter' )) {
				$filter->replace_matches_inside_words = true;
			} else {
				$filter->replace_matches_inside_words = false;
			}
			
			$filter->replace_text = $params->get ( 'email_replace_text', '*' );
			
			$filter->text = $this->title;
			$this->title = $filter->filter ();
			
			$filter->text = $this->price;
			$this->price = $filter->filter ();
			
			$filter->text = $this->zipcode;
			$this->zipcode = $filter->filter ();
			
			$filter->text = $this->address1;
			$this->address1 = $filter->filter ();
			
			$filter->text = $this->address2;
			$this->address2 = $filter->filter ();
			
			$filter->text = $this->description;
			$this->description = $filter->filter ();
			
			$filter->text = $this->tags;
			$this->tags = $filter->filter ();
			
			$filter->text = $this->metadesc;
			$this->metadesc = $filter->filter ();
		
		}
		
		if (empty ( $this->globalad_id )) {
			$this->globalad_id = ListbingoHelper::getGlobalAdId ( $this->title, $params );
		}
		
		$this->alias = JFilterOutput::stringURLSafe ( $this->alias );
		
		if (trim ( str_replace ( '-', '', $this->alias ) ) == '') {
			
			$this->alias = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		}
		
		if (trim ( str_replace ( '&nbsp;', '', $this->description ) ) == '') {
			$this->description = '';
		}
		
		if (! $this->id) {
			
			$this->created_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
			
			if ($params->get ( 'auto_expire_listings', 0 )) {
				$expirydays = $params->get ( 'expiry_days', 10 );
				$expirydate = JFactory::getDate ( strtotime ( "+ $expirydays days" ) );
				
				$this->expiry_date = $expirydate->toFormat ( "%Y-%m-%d-%H-%M-%S" );
			} else {
				$this->expiry_date = $db->getNullDate ();
			}
		} else {
			$this->modified_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		}
		
		if (isset ( $this->currency ) && ! empty ( $this->currency )) {
			
			$currency_code = explode ( ":", $this->currency );
			if (count ( $currency_code ) > 1) {
				$this->currencycode = $currency_code [0];
				$this->currency = $currency_code [1];
			}
		
		} else {
			
			/*$query = "SELECT * from #__gbl_countries where default_country='1'";
			$db->setQuery ( $query );
			$obj = $db->loadObject ();
			if (is_object ( $obj )) {
				$this->currencycode = $obj->currency_symbol;
				$this->currency = $obj->currency;
			} else {
				$curr = explode ( ":", $params->get ( 'default_currency', '$:AUD' ) );
				
				$this->currencycode = $curr [0];
				$this->currency = $curr [1];
			}*/
			
			$curr = explode ( ":", $params->get ( 'default_currency', '$:AUD' ) );
			
			$this->currencycode = $curr [0];
			$this->currency = $curr [1];
		
		}
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		
		$this->globalad_id = $filter->clean ( $this->globalad_id, "STRING" );
		$this->title = $filter->clean ( $this->title );
		$this->pricetype = $filter->clean ( $this->pricetype, "INT" );
		$this->currency = $filter->clean ( $this->currency, "STRING" );
		$this->currencycode = $filter->clean ( $this->currencycode, "STRING" );
		$this->price = $filter->clean ( $this->price, "FLOAT" );
		$this->alias = $filter->clean ( $this->alias, "STRING" );
		$this->email = $filter->clean ( $this->email, "STRING" );
		$this->region_id = $filter->clean ( $this->region_id, "INT" );
		$this->country_id = $filter->clean ( $this->country_id, "INT" );
		$this->zipcode = $filter->clean ( $this->zipcode, "STRING" );
		$this->address1 = $filter->clean ( $this->address1, "STRING" );
		$this->address2 = $filter->clean ( $this->address2, "STRING" );
		$this->description = $filter->clean ( $this->description, "STRING" );
		$this->ordering = $filter->clean ( $this->ordering, "INT" );
		$this->created_date = $filter->clean ( $this->created_date, "STRING" );
		$this->status = $filter->clean ( $this->status, "INT" );
		$this->hascalendar = $filter->clean ( $this->hascalendar, "INT" );
		$this->featured = $filter->clean ( $this->featured, "INT" );
		$this->category_id = $filter->clean ( $this->category_id, "INT" );
		$this->views = $filter->clean ( $this->views, "INT" );
		$this->tags = $filter->clean ( $this->tags, "STRING" );
		$this->metadesc = $filter->clean ( $this->metadesc, "STRING" );
		$this->user_id = $filter->clean ( $this->user_id, "INT" );
		$this->expiry_date = $filter->clean ( $this->expiry_date, "STRING" );
		$this->modified_date = $filter->clean ( $this->modified_date, "STRING" );
		$this->show_contact = $filter->clean ( $this->show_contact, "INT" );
		
		return true;
	}
	
	function load($id = 0) {
		parent::load ( $id );
	}
	
	function loadWithFields($id = 0, $infobar = false) {
		parent::load ( $id );
		
		$user = JFactory::getUser ();
		$userid = $user->get ( 'id' );
		
		//Get Application
		$app = & JFactory::getApplication ();
		
		if ($this->status == 1 || $this->user_id == $userid || $app->isAdmin ()) {
			$this->canbeviewed = 1;
			
			$db = JFactory::getDBO ();
			$query = "SELECT hasprice FROM #__gbl_categories WHERE id='" . $this->category_id . "'";
			$db->setQuery ( $query );
			$this->hasprice = $db->loadResult ();
			$aid = ( int ) $user->get ( 'aid', 0 );
			
			$this->aduser = JFactory::getUser ( $this->user_id );
			
			$query = "SELECT lf.*,lf.title, lf.type, GROUP_CONCAT( lfs.field_value order by ordering SEPARATOR ', ' ) as value
				FROM #__gbl_ads_fields AS lfs
				LEFT JOIN #__gbl_fields AS lf ON lfs.field_id = lf.id
				WHERE lfs.ad_id = '" . $this->id . "' AND lf.published='1' and lf.access<=$aid
				GROUP BY lfs.field_id order by lf.ordering";
			
			$db->setQuery ( $query );
			$this->extrafields = $db->loadObjectList ();
			
			$query = "SELECT r.id as rid,r.title as region,p.id pid,p.title as parentregion,c.id as cid,c.title as country from #__gbl_regions as r
		left join #__gbl_regions as p on p.id=r.parent_id
		left join #__gbl_countries as c on c.id=r.country_id
		where r.id=$this->region_id";
			
			$address = new stdClass ();
			$address->address = $this->address1;
			$address->street = $this->address2;
			$address->zipcode = $this->zipcode;
			
			$db->setQuery ( $query );
			$obj = $db->loadObject ();
			
			if ($obj) {
				
				$address->region = $obj->region;
				$address->state = $obj->parentregion;
				$address->country = $obj->country;
				
				$this->region = $obj->region;
				$this->country = $obj->country;
			}
			
			$this->address = $address;
			
			$query = "SELECT * from #__gbl_ads_images where published='1' and ad_id=$this->id order by ordering";
			$db->setQuery ( $query );
			$this->images = $db->loadObjectList ();
		
		} else {
			$this->canbeviewed = 0;
			$this->reset ();
		
		}
	}

}
?>