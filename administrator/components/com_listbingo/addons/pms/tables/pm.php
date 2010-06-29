<?php
/**
 * Joomla! 1.5 component Listbingo
 *
 * @version $Id: pm.php 2009-12-21 02:02:23 svn $
 * @author http://www.gobingoo.com
 * @package gobingoo
 * @subpackage Agent
 * @license GNU/GPL
 *
 * A Classified Ad Component from gobingoo.com
 *
 * Code Bruce
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
 * @subpackage		EstateBingo
 */
class JTablePm extends GTable {
	
	/**
	 * Primary Key
	 *
	 * @var int
	 */
	var $id = null;
	
	var $subject = null;
	
	var $ad_id = null;
	
	var $message_to = null;
	
	var $message_from = null;
	
	var $message = null;
	
	var $status = null;
	
	var $replyto = null;
	
	var $contact_name = null;
	
	var $contact_email = null;
	
	var $message_date = null;
	
	var $contact_phone = null;
	
	/**
	 * Constructor
	 *
	 * @param object Database connector object
	 * @since 1.0
	 */
	function __construct(& $db) {
		parent::__construct ( '#__gbl_messages', 'id', $db );
	}
	
	function check() {
		$datenow = & JFactory::getDate ();
		$this->message_date = $datenow->toFormat ( "%Y-%m-%d-%H-%M-%S" );
		
		$filter = new JFilterInput ( array (), array (), 1, 1 );
		
		$this->subject = $filter->clean ( $this->subject, "STRING" );
		
		$this->ad_id = $filter->clean ( $this->ad_id, "STRING" );
		
		$this->message_to = $filter->clean ( $this->message_to, "INT" );
		
		$this->message_from = $filter->clean ( $this->message_from, "INT" );
		
		$this->message = $filter->clean ( $this->message, "STRING" );
		
		$this->status = $filter->clean ( $this->status, "INT" );		
		
		$this->contact_name = $filter->clean ( $this->contact_name, "STRING" );
		
		$this->contact_email = $filter->clean ( $this->contact_email, "STRING" );
		
		$this->message_date = $filter->clean ( $this->message_date, "STRING" );
		
		$this->contact_phone = $filter->clean ( $this->contact_phone, "STRING" );
		
		return true;
	}

}
?>