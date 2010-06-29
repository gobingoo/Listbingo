<?php
/**
 * @version		$Id: helper.php
 */

// no direct access
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.base.tree' );

jimport ( 'joomla.utilities.simplexml' );

/**
 * mod_bannerslider Helper class
 *
 * @static
 * @package		Joomla
 * @since		1.5
 */

class modLbtagcloudHelper {
	
	var $_xml;
	var $fullstring = NULL;
	var $wordsArray = array ();
	var $tagcolor = "#BC21FF";
	
	/*
	 * initializing the tagcloud
	 */
	function init(&$params) {
		
		$this->isInCacheTime ( $params );
		$this->readTagsFromXml ( $params );
	}
	
	/*
	 * Check whether xml file exists, if not create it
	 * If exists check the cache time and if cache time is over, tag.xml is regenerated again
	 */
	function isInCacheTime($params) {
		
		$cachefile = JPATH_ROOT . DS . "modules" . DS . "mod_lbtagcloud" . DS . "cache" . DS . "tag.xml";
		try {
			
			if (file_exists ( $cachefile )) {
				
				$contents = file_get_contents ( $cachefile );
				$xml = new SimpleXMLElement ( $contents );
				
				$cachetime = $params->get ( 'cache_time', 900 ) * 60;
				//echo ($xml ['cachetime'] +$cachetime )-time();
				

				if (($xml ['cachetime'] + $cachetime) > time ()) {
					return true;
				} else {
					$this->getWords ();
					$this->getWordsArrayWithCount ( $params );
					$this->createXml ();
				
				}
			
			} else {
				$this->getWords ();
				$this->getWordsArrayWithCount ( $params );
				$this->createXml ();
			}
		} catch ( Exception $e ) {
			@unlink ( $cachefile );
			self::isInCacheTime ( $params );
		}
	}
	
	/*
	 * fetch all the tags from database and return a full string
	 */
	function getWords() {
		$dbo = & JFactory::getDBO ();
		
		$cond = array ();
		$cond [] = "a.status=1";
		$cond [] = " (a.expiry_date > NOW() || a.expiry_date='" . $dbo->getNullDate () . "')";
		
		$country = self::getCurrentCountry ();
		$region = self::getCurrentRegion ();
		
		/*if ($country > 0) {
			$cond [] = " a.country_id=$country";
		}
		if ($region > 0) {
			$regions = self::getSubRegion ( $region, true );
			$regions [] = $region;
			$regioncondition = "";
			if (count ( $regions ) > 0) {
				$regioncondition = implode ( ", ", $regions );
			}
			if ($region) {
				$cond [] = " a.region_id in ($regioncondition)";
			}
		}*/
		
		$user = JFactory::getUser ();
		$cond [] = "cat.access<=" . ( int ) $user->get ( 'aid', 0 );
		$cond [] = "cat.published=1";
		
		if (count ( $cond ) > 0) {
			$condition = " WHERE " . implode ( " AND ", $cond );
		}
		
		$order = "a.created_date DESC";
		
		$sql = 'SELECT a.tags ' . ' FROM #__gbl_ads AS a' . ' LEFT JOIN #__gbl_countries as c on c.id=a.country_id' . ' LEFT JOIN #__gbl_categories as cat on cat.id=a.category_id' . ' LEFT JOIN #__gbl_regions as r on r.id=a.region_id' . ' LEFT JOIN #__users as u on u.id=a.user_id' . $condition . ' GROUP BY a.id' . ' ORDER BY ' . $order;
		
		$dbo->setQuery ( $sql );
		$dbo->Query ();
		
		if ($results = $dbo->loadObjectList ()) {
			//place them into 1 string without html
			$wordList = self::concatonateWords ( $results );
		} else {
			$wordList = '';
		}
		
		$this->fullstring = $wordList;
		
		return $this->fullstring;
	}
	
	/*
	 * return current country
	 */
	function getCurrentCountry() {
		$mainframe = JFactory::getApplication ();
		return $mainframe->getUserState ( 'com_listbingocountry' );
	
	}
	
	/*
	 * return current region
	 */
	function getCurrentRegion() {
		$mainframe = &JFactory::getApplication ();
		
		return $mainframe->getUserState ( "com_listbingoregion" );
	
	}
	
	/*
	 * return subregions for currency region
	 */
	
	function getSubRegion($id = 0, $published = true) {
		$cond = array ();
		
		$cond [] = " parent_id=$id";
		
		$cond [] = " published='1'";
		
		if (count ( $cond ) > 0) {
			$condition = " where " . implode ( " AND ", $cond );
		}
		
		$db = JFactory::getDBO ();
		$query = "SELECT id from #__gbl_regions $condition";
		$db->setQuery ( $query );
		$results = $db->loadResultArray ();
		
		if (count ( $results ) > 0) {
			foreach ( $results as $r ) {
				$results = array_merge ( $results, self::getSubRegion ( $r ) );
			}
		}
		return $results;
	
	}
	
	/*
	 * returns the concatenated words
	 */
	
	function concatonateWords($dataObj) {
		$words = '';
		foreach ( $dataObj as $row ) {
			foreach ( $row as $item ) {
				$words .= ' ' . strip_tags ( $item );
			}
		
		}
		return $words;
	}
	
	/*
	 * converts a full string to array that holds the repeated elements count
	 */
	
	function getWordsArrayWithCount(&$params) {
		if (! empty ( $this->fullstring )) {
			$this->fullstring = strtolower ( $this->fullstring );
			$this->wordsArray = preg_split ( "/[\s,]+/", $this->fullstring ); // split whole string with condition space and comma
			$this->wordsArray = array_filter ( $this->wordsArray ); // filter empty element in array
			$this->wordsArray = array_count_values ( $this->wordsArray ); // rebuild array with count values
		}
		
		return $this->wordsArray;
	}
	
	/*
	 * generate tag.xml if cache time is out or xml file not generated previously
	 */
	
	function createXml() {
		
		ob_start ();
		
		$xmlstr = "<tags></tags>";
		
		$xml = new SimpleXMLElement ( $xmlstr );
		$xml->addAttribute ( 'cachetime', time () );
		
		if (count ( $this->wordsArray ) > 0) {
			foreach ( $this->wordsArray as $w => $val ) {
				$tag = $xml->addChild ( 'tag', trim ( ( string ) $w ) );
				$tag->addAttribute ( 'frequency', $val );
			
			}
			
			echo $this->_xml = $xml->asXML ();
		}
		
		$contents = ob_get_contents ();
		
		ob_end_clean ();
		
		$tagdatapath = JPATH_ROOT . DS . "modules" . DS . "mod_lbtagcloud" . DS . "cache" . DS . "tag.xml";
		@chmod ( $tagdatapath, 00777 );
		return JFile::write ( $tagdatapath, $contents );
	
	}
	
	/*
	 * read tag.xml and set wordsArray
	 */
	function readTagsFromXml($params = null) {
		$filename = JPATH_ROOT . DS . "modules" . DS . "mod_lbtagcloud" . DS . "cache" . DS . "tag.xml";
		try {
			
			$contents = file_get_contents ( $filename );
			
			if (! empty ( $contents )) {
				
				$xml = simplexml_load_file ( $filename );
				
				if (count ( $xml->tag ) > 0) {
					foreach ( $xml->tag as $t ) {
						$this->wordsArray ["$t"] = ( int ) $t ['frequency'];
					}

					
					arsort ( $this->wordsArray ); // sort by ascending order
					
					$totaltags = $params->get ( 'totaltags', 25 );
					if (count($this->wordsArray)>$totaltags && $totaltags > 0) {
						$this->wordsArray = array_slice ( $this->wordsArray, 1, $totaltags );
					} // slice the array with param limit
					
					
				}
			} else {
				
			
			}
		} catch ( Exception $e ) {
			@unlink ( $filename );
			self::isInCacheTime ( $params );
			self::readTagsFromXml ( $params );
		}
	
	}
	
	/*
	 * suffle the tags for cloud
	 */
	function shuffleCloud() {
		
		$keys = array_keys ( $this->wordsArray );
		
		shuffle ( $keys );
		
		if (count ( $keys ) && is_array ( $keys )) {
			$tmpArray = $this->wordsArray;
			
			$this->wordsArray = array ();
			foreach ( $keys as $key => $value ) {
				$this->wordsArray [$value] = $tmpArray [$value];
			}
		}
	
	}
	
	/*
	 * render tagcloud
	 */
	function render(&$params) {
		
		$return = "";
		
		//check if wordsArray is array or not
		if (is_array ( $this->wordsArray ) && count ( $this->wordsArray ) > 0) {
			$minSize = $params->get ( 'minfontsize', 20 ); //minimum font size
			$maxSize = $params->get ( 'maxfontsize', 30 ); //maximum font size
			$tagcolor = "#" . $params->get ( 'tagcolor', 'BC21FF' );
			
			$biggest = max ( $this->wordsArray ); //highest frequency
			$smallest = min ( $this->wordsArray ); //lowest frequency
			

			$difference = $biggest - $smallest; // frequency difference
			$difference = ($difference) == 0 ? 1 : $difference; //set to 1 if difference is 0
			$fontDifference = $maxSize - $minSize; //font difference
			$fontDifference = ($fontDifference) == 0 ? 7 : $fontDifference; //set to 1 if fontdifference is 0
			

			//check if suffling is enabled or not
			if ($params->get ( 'enablesuffle', 0 )) {
				$this->shuffleCloud (); //randomizes the content
			} else {
				ksort ( $this->wordsArray ); //order word array in ascending order
			}
			
			foreach ( $this->wordsArray as $word => $frequency ) {
				$percent = round ( ($frequency - $smallest) / $difference, 1 );
				$fontSize = round ( $minSize + ($fontDifference * $percent) );
				$url = JRoute::_ ( 'index.php?option=com_listbingo&task=ads.search&q=' . $word );
				$return .= '<a href="' . $url . '" style="display:inline-block; text-decoration:none;padding-right:' . rand ( 1, 7 ) . 'px; padding-bottom:' . rand ( 1, 7 ) . 'px; font-size:' . $fontSize . 'px; color:' . $tagcolor . '">' . $word . '</a> ';
			}
			
			
		} else {
			$return .= JText::_ ( 'Tags not found' );
		}
		
		return $return;
	
	}

}


