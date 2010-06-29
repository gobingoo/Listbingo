<?php

defined ( 'JPATH_BASE' ) or die ();

/**
 * Renders a checkbox element
 *
 * @package 	Joomla.Framework
 * @subpackage		Parameter
 * @since		1.5
 */

class GElementCheckbox extends GElement {
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var $_name = 'Checkbox';
	
	function fetchElement($id = null, $name = 'field', $value = null, $required = false, $options = null) {
		$reqclass = "";
		if ($required) {
			$reqclass = " required";
		}
		
		if (! is_array ( $value )) {
			$value = array ($value );
		}
		
		if (count ( $value ) > 0) {
			foreach ( $value as &$val ) {
				$val = JFilterOutput::cleanText ( $val );
			}
		}
		
		$db = JFactory::getDBO ();
		//get all super administrator
		$query = 'SELECT option_value as id, title' . ' FROM #__gbl_options where published=1 and field_id=' . $id ." order by ordering";
		$db->setQuery ( $query );
		$options = $db->loadObjectList ();
		if (count ( $options ) > 0) {
			foreach ( $options as &$o ) {
				JFilterOutput::objectHTMLSafe ( $o );
			
			}
			
			return self::checkbox ( $options, "field[$id]", 'class="inputtextbox" ', 'id', 'title', $value, "field" . str_replace ( " ", "_", $name ) );
		} else {
			return JText::_ ( "No Options Defined" );
		
		}
	
	}
	
	function checkbox($arr, $name, $attribs = null, $key = 'value', $text = 'text', $selected = null, $idtag = false, $translate = false) {
		reset ( $arr );
		$html = '';
		
		if (is_array ( $attribs )) {
			$attribs = JArrayHelper::toString ( $attribs );
		}
		
		$id_text = $name;
		if ($idtag) {
			$id_text = $idtag;
		}
		$html .= "<div class=\"gb_checkboxinput\">";
		for($i = 0, $n = count ( $arr ); $i < $n; $i ++) {
			$k = $arr [$i]->$key;
			$t = $translate ? JText::_ ( $arr [$i]->$text ) : $arr [$i]->$text;
			$id = (isset ( $arr [$i]->id ) ? @$arr [$i]->id : null);
			
			$extra = '';
			$extra .= $id ? " id=\"" . $arr [$i]->id . "\"" : '';
			if (is_array ( $selected )) {
				foreach ( $selected as $val ) {
					$k2 = is_object ( $val ) ? $val->$key : $val;
					if ($k == $k2) {
						$extra .= " checked=\"checked\"";
						break;
					}
				}
			} else {
				$extra .= (( string ) $k == ( string ) $selected ? " checked=\"checked\"" : '');
			}
			
			$html .= "\n\t<input type=\"checkbox\" name=\"$name" . "[]\" id=\"$id_text$k\" value=\"" . $k . "\"$extra $attribs />";
			$html .= "\n\t$t";
		
		}
		$html .= "</div>";
		$html .= "\n";
		return $html;
	}

}
