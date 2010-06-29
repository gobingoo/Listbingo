<?php
/**
 * Core library for Gobingoo products
 */


function gbimport($filePath, $base = null, $key = 'libraries.') {
	global $option;


	static $paths;

	if (!isset($paths)) {
		$paths = array();
	}

	$keyPath = $key ? $key.$filePath : $filePath;


	if (!isset($paths[$keyPath])) {
		if (!$base) {
			$base = dirname(__FILE__);
		}

		$parts = explode('.', $filePath);

		$classname = array_pop($parts);




		$path = str_replace('.', DS, $filePath);

		if (strpos($filePath, 'gobingoo') === 0) {


			/*
			 * If we are loading a gobingoo class prepend the classname with a
			 * capital G.
			 */
			$classname = 'G'.$classname;
			$classpath = $base.DS.$path.'.php';


			$classes = JLoader::register($classname, $classpath);
			$rs = isset($classes[strtolower($classname)]);
		} else {

			switch ($classname) {
				case 'helper':
					$classname = ucfirst(array_pop($parts)).ucfirst($classname);


					break;

				default:
					$classname = ucfirst($classname);
					break;
			}
			/*
			 * Include other libaries
			 */
			if (strpos($filePath, 'tables') === 0) {

				$tablepath = JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'tables';
				JTable::addIncludePath($tablepath);
				$basepath= JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'addons';
				if(is_dir($basepath))
				{
					$folders=JFolder::folders($basepath,'tables',true,true);
					if(count($folders)>0)
					{
						foreach($folders as $f)
						{
							JTable::addIncludePath($f);
						}
					}
				}

				return;

			}




			if (strpos($filePath, 'css') === 0) {

				$csspaths = explode(".", $filePath);
				array_shift($csspaths);
				$csspath = implode("/", $csspaths);
				$csspath = JUri::root()."administrator/components/$option/css/".$csspath.".css";
				$document = JFactory::getDocument();
				$document->addStyleSheet($csspath);
				return;

			}

			if (strpos($filePath, 'jsi') === 0) {


				$jspath = explode(".", $filePath);
				array_shift($jspath);
				$jspath = implode("/", $jspath);
				$jspath = JUri::root()."administrator/components/$option/js/".$jspath.".js";
				ob_start();
				?>
<script src="<?php echo $jspath;?>"></script>
				<?php
				$content=ob_get_contents();
				ob_end_clean();
				return $content;

			}


			if (strpos($filePath, 'js') === 0) {

				$jspath = explode(".", $filePath);
				array_shift($jspath);
				$jspath = implode("/", $jspath);
				$jspath = JUri::root()."administrator/components/$option/js/".$jspath.".js";
				$document = JFactory::getDocument();
				$document->addScript($jspath);
				return;

			}

			if (strpos($filePath, 'model') > 0) {


				$modelpath = JPATH_ADMINISTRATOR.DS.'components'.DS.$option.DS.'models'.DS;
				$modelpaths = explode(".", $filePath);
				$file = array_pop($modelpaths);
				$prefix = ucfirst(array_shift($modelpaths));

				$modelpath .= strtolower($file).".php";
				$modelname=ucfirst($prefix)."Model".ucfirst($file);
				$classes = JLoader::register($modelname, $modelpath);
				return new $modelname();
			}

			/*
			 * If it is not in the gobingoo namespace then we have no idea if
			 * it uses our pattern for class names/files so just include.
			 */
			$rs = include ($base.DS.$path.'.php');
		}

		$paths[$keyPath] = $rs;

	}


	return $paths[$keyPath];

}

/**
 *
 * gaddons function to import addons specific files
 *
 *
 */


function gbaddons($filePath, $type=null)
{
	global $option;


	$xaddonspath=$addonspath = explode(".", $filePath);
	$package=$addonspath[0];
	$xtype=$addonspath[1];
	$useurl=$basepath=JPATH_ADMINISTRATOR.DS."components".DS.$option.DS."addons".DS;
	$baseurl=JUri::root()."administrator/components/$option/addons/";
	array_shift($addonspath);

	if(is_null($type))
	{
		switch($xtype)
		{
			case 'css':
				$addonspath = implode("/", $xaddonspath);
				$type="css";
				$useurl=$baseurl;
				$addonspath = $useurl.$addonspath.".".$type;
				$document = JFactory::getDocument();
				$document->addStyleSheet($addonspath);
				break;
					
			case 'js':
				$type="js";
				$addonspath = implode("/", $xaddonspath);
				$useurl=$baseurl;
				$addonspath = $useurl.$addonspath.".".$type;
				$document = JFactory::getDocument();
				$document->addScript($addonspath);
				
				$path='media/system/js/mootools.js';
				$path =  JURI::root(true).'/'.$path;
				unset($document->_scripts[$path]);
				$scripts=$document->_scripts;
				
				$document->addScript($path);
    			
				if(count($scripts)>0)
				{
					foreach($scripts as $key=>$s)
					{
						unset($document->_scripts[$key]);
						$document->addScript($key);
					}
				}
				break;

			case 'jsi':
				
				$type="js";
				$addonspath = implode("/", $xaddonspath);
				$useurl=$baseurl;
				$addonspath = $useurl.$addonspath.".".$type;
				 $addonspath=str_replace("jsi",'js',$addonspath);
				
				
				echo "<script src=\"$addonspath\"></script>";

				break;

			case 'controller':

				gbimport("gobingoo.controller");
				return GController::getAddonInstance($filePath);

				break;

			case 'model':
				gbimport("gobingoo.model");
				return GModel::getAddonInstance($filePath);

				break;
					
			default:
				$type="php";
				$addonspath = implode(DS, $addonspath);
				$useurl=$basepath.$package.DS;
				$addonspath = $useurl.$addonspath.".".$type;
				require_once($addonspath);
				break;
		}
	}

	return;

}

function gbext($type="js",$path="")
{
	$document = JFactory::getDocument();
	switch($type)
	{
		case 'js':
			$document->addScript($path);
			break;
		default:
			$document->addStylesheet($path);
			break;
	}

}
?>
