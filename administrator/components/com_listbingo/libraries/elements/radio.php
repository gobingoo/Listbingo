<?php

defined ( 'JPATH_BASE' ) or die ();

/**
 * Renders a radio element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class GElementRadio extends GElement {
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = 'Radio';
	
	function fetchElement($id = null, $name = 'field', $value = null, $required = false, $options = null) {
		$reqclass = "";
		if ($required) {
			$reqclass = " required";
		}
		$value=JFilterOutput::cleanText ( $value);
		$db = JFactory::getDBO ();
		//get all super administrator
		$query = 'SELECT option_value as id, title' . ' FROM #__gbl_options where published=1 and field_id=' . $id." order by ordering";
		$db->setQuery ( $query );
		$options = $db->loadObjectList ();
		if (count ( $options ) > 0) {
			
			foreach ( $options as &$o ) {
				JFilterOutput::objectHTMLSafe ( $o );
			
			}
			
			return JHTML::_ ( 'select.radiolist', $options, "field[$id]", 'class="inputtextbox" ', 'id', 'title', $value, "field" . str_replace ( " ", "_", $name ) );
		} else {
			return JText::_ ( "No Options Defined" );
		}
	
	}
}
