<?php

defined ( 'JPATH_BASE' ) or die ();

/**
 * Renders a country element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class GElementCountry extends GElement {
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = 'Country';
	
	function fetchElement($id = null, $name = 'field', $value = null, $required = false, $options = null) {
		$reqclass = "";
		if ($required) {
			$reqclass = " required";
		}
		$value=JFilterOutput::cleanText ( $value);
		$db = JFactory::getDBO ();
		//get all super administrator
		 $query = 'SELECT *  FROM #__gbl_countries where published=1  order by  title,ordering';
		$db->setQuery ( $query );
		$countries = $db->loadObjectList ();
		if (count ( $countries ) > 0) {
			
			foreach ( $countries as &$o ) {
				JFilterOutput::objectHTMLSafe ( $o );
			
			}
			
			array_unshift ( $countries, JHTML::_ ( 'select.option', '0', JText::_ ( '-Select Country-' ), 'code', 'title' ) );
			
			return JHTML::_ ( 'select.genericlist', $countries, "field[$id]", 'class="inputtextbox ' . $reqclass . '" size="' . $options->size . '"', 'code', 'title', $value, "field" . $name );
		} else {
			return JText::_ ( "No Countries Defined" );
		
		}
	
	}
	
	function render($val = "") {
		if ($val != "") {
			$db = JFactory::getDBO ();
			$query = "SELECT title FROM #__gbl_countries WHERE code='$val' AND published='1'";
			$db->setQuery ( $query );
			$country = $db->loadObject ();
			if($country)
			{
			
				return $country->title;
			}
			else
			{
				return JText::_("NOT_AVAILABLE");
			}
		} else {
			return;
		}
	}
}
