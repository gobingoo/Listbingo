<?php

class GElementSelect extends GElement
{

	function fetchElement($id=null,$name='field',$value=null,$required=false,$xoptions=null)
	{
		$reqclass="";
		if($required)
		{
			$reqclass=" required";
		}
		$value=JFilterOutput::cleanText ( $value);
		
		$db=JFactory::getDBO();
		//get all super administrator
		$query = 'SELECT option_value as id, title' .
		' FROM #__gbl_options where published=1 and field_id='.$id." order by ordering";
		$db->setQuery( $query );
		$options = $db->loadObjectList();
		
		if(count($options)>0)
		{
			foreach($options as &$o)
			{
				JFilterOutput::objectHTMLSafe ( $o );	
				
			}
			
			array_unshift($options, JHTML::_('select.option', '', JText::_('-Select-'), 'id', 'title'));

			return JHTML::_('select.genericlist',  $options, "field[$id]", 'class="inputtextbox '.$reqclass.'" size="'.$xoptions->size.'" ', 'id', 'title', $value, "field".str_replace(" ","_",$name));
		}
		else
		{
			return JText::_("No Options Defined");
		}

	}

}
?>