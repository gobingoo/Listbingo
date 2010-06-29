<?php
/**
 *
 * @author Alex
 *
 */

class GHelper
{

	function quickiconButton($link, $image, $text,$package=null) {
		global $mainframe,$option;
		$lang = &JFactory::getLanguage();
		$template = $mainframe->getTemplate();
		$iconsfolder='/images/icons/';
		if(!is_null($package))
		{
			$iconsfolder="/addons/$package/images/icons/";
		}

		?>
<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
<div class="icon"><a href="<?php echo $link; ?>"> <?php echo JHTML::_('image.site', $image, '/components/'.$option.$iconsfolder, NULL, NULL, $text); ?>
<span><?php echo $text; ?></span></a></div>
</div>
		<?php
	}


	/**
	 * Get Real IP Address of the host
	 * @return
	 */

	function getIP() {
		if (! empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}

	function getServerIP() {
		return $_SERVER['SERVER_ADDR'];
	}
	/**
	 * Get Authorization Key for product
	 * @return
	 */
	function getAuthorizationKey() {
		global $mainframe,$option;
		$sitename = $mainframe->getCfg('sitename', 'none');
		$siteurl = JUri::root();
		$ip = self::getServerIP();
		$authkey = $siteurl."|".$option."|".$ip;

		return base64_encode($authkey);
	}


	function published( &$row, $i, $taskprefix,$imgY = 'tick.png', $imgX = 'publish_x.png', $prefix='' )
	{
		$img 	= $row->published ? $imgY : $imgX;
		$task 	= $row->published ? $taskprefix.'.unpublish' : $taskprefix.'.publish';
		$alt 	= $row->published ? JText::_( 'Published' ) : JText::_( 'Unpublished' );
		$action = $row->published ? JText::_( 'Unpublish Item' ) : JText::_( 'Publish item' );

		$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $prefix.$task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
		;

		return $href;
	}


	function cpanel($task = '', $icon = '')
	{
		JToolbarHelper::customX($task,$icon,'','Home',false);
	}

	function truncate($string, $length = 200, $etc = '...',$break_words = false, $middle = false)
	{
		if ($length == 0)
		return '';

		if (strlen($string) > $length) {
			$length -= min($length, strlen($etc));
			if (!$break_words && !$middle) {
				$string = preg_replace('/\s+?(\S+)?$/', '', substr($string, 0, $length+1));
			}
			if(!$middle) {
				return substr($string, 0, $length) . $etc;
			} else {
				return substr($string, 0, $length/2) . $etc . substr($string, -$length/2);
			}
		} else {
			return $string;
		}
	}

	function tick( &$row,$i,$objField=null,$actionable=false,$imgY = 'tick.png', $imgX = 'publish_x.png' )
	{
		$field=$objField->field;
		$taskprefix=$objField->taskprefix;

		$task1=$objField->task1;
		$task2=$objField->task2;
		$alt1=$objField->alt1;
		$alt2=$objField->alt2;
		$action1=$objField->action1;
		$action2=$objField->action2;




		$img 	= $row->$field ? $imgY : $imgX;
		$task 	= $row->$field ? $taskprefix.'.'.$task1 : $taskprefix.'.'.$task2;

		$alt 	= $row->$field ? JText::_( $alt1 ) : JText::_( $alt2 );
		$action = $row->$field ? JText::_( $action1 ) : JText::_( $action2 );
		if($actionable)
		{

			$href = '
		<a href="javascript:void(0);" onclick="return listItemTask(\'cb'. $i .'\',\''. $task .'\')" title="'. $action .'">
		<img src="images/'. $img .'" border="0" alt="'. $alt .'" /></a>'
		;
		}
		else
		{

			$href = '
				<img src="images/'. $img .'" border="0" alt="'. $alt .'" />';
		}
		return $href;
	}


	function checkbox( $arr, $name, $attribs = null, $key = 'value', $text = 'text', $selected = null, $idtag = false, $translate = false )
	{
		reset( $arr );
		$html = '';

		if (is_array($attribs)) {
			$attribs = JArrayHelper::toString($attribs);
		}

		$id_text = $name;
		if ( $idtag ) {
			$id_text = $idtag;
		}

		for ($i=0, $n=count( $arr ); $i < $n; $i++ )
		{
			$k	= $arr[$i]->$key;
			$t	= $translate ? JText::_( $arr[$i]->$text ) : $arr[$i]->$text;
			$id	= ( isset($arr[$i]->id) ? @$arr[$i]->id : null);

			$extra	= '';
			$extra	.= $id ? " id=\"" . $arr[$i]->id . "\"" : '';
			if (is_array( $selected ))
			{
				foreach ($selected as $val)
				{
					$k2 = is_object( $val ) ? $val->$key : $val;
					if ($k == $k2)
					{
						$extra .= " checked=\"checked\"";
						break;
					}
				}
			} else {
				$extra .= ((string)$k == (string)$selected ? " checked=\"checked\"" : '');
			}
			$html .= "\n\t<input type=\"checkbox\" name=\"$name"."[]\" id=\"$id_text$k\" value=\"".$k."\"$extra $attribs />";
			$html .= "\n\t<label for=\"$id_text$k\">$t</label>";
		}
		$html .= "\n";
		return $html;
	}

	function popup($selector="a.popup")
	{
		$document=JFactory::getDocument();
		$document->addScriptDeclaration("
		window.addEvent('domready',function(){

			$$('$selector').each(function(el){
				el.addEvent('click',function(e){
			var e =new Event(e);
			e.stop();
			eval('rel='+this.rel);
			window.open(this.href,this.id,'status=0,height='+rel.height+',width='+rel.width+',toolbar=0,location=0,menubar=0,resizable=0,scrollbars=1');
				
			
				});
			});
			});
		");

	}


	/**
	 * Auto Event Populator
	 */




	function _getEvents($xmlfile="")
	{
		$eventsarray=array();
		if(empty($xmlfile))
		{
			return $eventsarray;
		}
		$parser=JFactory::getXMLParser('simple');
		if($parser->loadFile($xmlfile))
		{
			if($events=$parser->document->getElementByPath("emailevents"))
			{
				if(count($events->children())>0)
				{
					foreach($events->children() as $event)
					{
						$eventsarray[$event->attributes("name")]=$event->data();


					}
				}
			}
		}
		return $eventsarray;
	}

	function getEventsList()
	{
		global $option;

		$manifest=substr($option,4);
		$parser=JFactory::getXMLParser('simple');
		$manifestfile=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS.$manifest.".xml";
		$eventsarray=self::_getEvents($manifestfile);

		$addonspath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons";
		if(JFolder::exists($addonspath))
		{
			$folders=JFolder::folders($addonspath,'.',false,false);

			if(count($folders)>0)
			{
				foreach($folders as $f)
				{


					$files=JFolder::files($addonspath.DS.$f,"xml",false,true);
					if(count($f)>0)
					{

						foreach($files as $xf)
						{
							$eventsarray=array_merge($eventsarray,self::_getEvents($xf));

						}
					}
				}
			}
		}

		return $eventsarray;


	}

	function route($link,$xhtml=true)
	{
		$uri	        =& JURI::getInstance(JURI::base());

		return  $uri->toString( array('scheme', 'host', 'port') ).JRoute::_($link,$xhtml);
	}



	function trunchtml($text, $length = 100, $ending = '...', $exact = false, $considerHtml = true) {
		if ($considerHtml) {
			// if the plain text is shorter than the maximum length, return the whole text
			if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
				return $text;
			}
			// splits all html-tags to scanable lines
			preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
			$total_length = strlen($ending);
			$open_tags = array();
			$truncate = '';
			foreach ($lines as $line_matchings) {
				// if there is any html-tag in this line, handle it and add it (uncounted) to the output
				if (!empty($line_matchings[1])) {
					// if it's an "empty element" with or without xhtml-conform closing slash
					if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
						// do nothing
						// if tag is a closing tag
					} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
						// delete tag from $open_tags list
						$pos = array_search($tag_matchings[1], $open_tags);
						if ($pos !== false) {
							unset($open_tags[$pos]);
						}
						// if tag is an opening tag
					} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
						// add tag to the beginning of $open_tags list
						array_unshift($open_tags, strtolower($tag_matchings[1]));
					}
					// add html-tag to $truncate'd text
					$truncate .= $line_matchings[1];
				}
				// calculate the length of the plain text part of the line; handle entities as one character
				$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
				if ($total_length+$content_length> $length) {
					// the number of characters which are left
					$left = $length - $total_length;
					$entities_length = 0;
					// search for html entities
					if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
						// calculate the real length of all entities in the legal range
						foreach ($entities[0] as $entity) {
							if ($entity[1]+1-$entities_length <= $left) {
								$left--;
								$entities_length += strlen($entity[0]);
							} else {
								// no more characters left
								break;
							}
						}
					}
					$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
					// maximum lenght is reached, so get off the loop
					break;
				} else {
					$truncate .= $line_matchings[2];
					$total_length += $content_length;
				}
				// if the maximum length is reached, get off the loop
				if($total_length>= $length) {
					break;
				}
			}
		} else {
			if (strlen($text) <= $length) {
				return $text;
			} else {
				$truncate = substr($text, 0, $length - strlen($ending));
			}
		}
		// if the words shouldn't be cut in the middle...
		if (!$exact) {
			// ...search the last occurance of a space...
			$spacepos = strrpos($truncate, ' ');
			if (isset($spacepos)) {
				// ...and cut the text in this position
				$truncate = substr($truncate, 0, $spacepos);
			}
		}
		// add the defined ending to the text
		$truncate .= $ending;
		if($considerHtml) {
			// close all unclosed html-tags
			foreach ($open_tags as $tag) {
				$truncate .= '</' . $tag . '>';
			}
		}
		return $truncate;
	}

	function obsfucateEmail($text, $replaceword)
	{
		$replaceby = "";
		if($replaceword=="")
		{
			$replaceby = "[obfuscated]";
		}
		else
		{
			$replaceby = $replaceword;
		}
		$regEx = "/([\s]*)[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i";
		$finaltxt=preg_replace($regEx, " <em>$replaceby</em> ",$text);
		return $finaltxt;
	}

	function censor($string,$all=false, $censortxt, $replace_word)
	{

		$censor_words = array();

		if($censortxt != "")
		{
			$censor_words = explode(",", $censortxt);
		}

		$replaceby = "";

		if($replace_word=="")
		{
			$replaceby = "[obfuscated]";
		}
		else
		{
			$replaceby = $replace_word;
		}

		foreach ($censor_words as $word)
		{

			/*if (!$all)
			 {
				$censors[] = substr($word,0,1).str_repeat($replaceby, strlen($word)-2).substr($word,-1);
				}

				else
				{
				$censors[] = str_repeat($replaceby, strlen($word));
				}*/
			//$replaceby = '*';
			$word1= '/^'.$word.'/i';
			$string = preg_replace($word1, $replaceby, $string);
				
			$word2= '/\s'.$word.'/i';
			$string = preg_replace($word2, $replaceby, $string);

			/*			$replaceby = '*';
			 $word1= '/[^][\s]'.$word.'/i';
			 $string = preg_replace($word1, $replaceby, $string);*/

		}
		//echo $string;exit;
		//$string = str_replace($censor_words, $censors, $string);

		return $string;
	}

	function isValidDateTime($dateTime)
	{
		if (preg_match("/^(\d{4})-(\d{2})-(\d{2}) ([01][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])$/", $dateTime, $matches)) {
			if (checkdate($matches[2], $matches[3], $matches[1])) {
				return true;
			}
		}

		return false;
	}
	
	function isValidExtension($extension=null)
	{
		if(is_null($extension))
		{
			return false;
		}
		
		 $basepath=JPATH_ADMINISTRATOR.DS."components".DS.$extension;
		if(!is_dir($basepath))
		{
			return false;
		}
	
		$db=JFactory::getDBO();
		 $query="SELECT * from #__components where `option`='$extension' and enabled=1 and parent=0";
		$db->setQuery($query);
		$obj=$db->loadObject();
		if($obj)
		{
			return true;
		}
		else
		{
			return false;
		}
	}


}
?>