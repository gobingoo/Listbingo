<?php 
/**
 * Joomla! 1.5 component Regserver
 *
 * @version $Id: manifest.php 2009-10-14 07:12:58 svn $
 * @author www.gobingoo.com
 * @package Joomla
 * @subpackage Regserver
 * @license GNU/GPL
 *
 * Manifest Generator
 *
 * Code Alex
 *
 */
 
class GManifest {

    function parse($xmlstr = null) {
    
        if ($xmlstr) {
            $xml = new SimpleXMLElement($xmlstr);
            
            if ($xml->error->code == 0) {
                $parsed = new stdClass ();
                $parsed->product = (string)$xml->product->name;
                $parsed->version = (string)$xml->product->version;
                $parsed->updatedate = (string)$xml->product->date;
                $parsed->changelog = (string)$xml->product->changelog;
                $parsed->instruction = (string)$xml->product->instruction;
                $parsed->updateurl = (string)$xml->product->updateurl;
                return $parsed;
            } else {
            
                throw new ManifestException( (string)$xml->error->msg,(int)$xml->error->code);
            }

            
        } else {
            throw new ManifestException('Invalid Manifest File', 500);
        }
    }

    
    function getCurrentManifest() {
        global $option;
        $productx = explode("_", $option);
        $product = $productx[1];
        $manifestfile = JPATH_COMPONENT.DS.$product.".xml";
        $xml = simplexml_load_file($manifestfile);
        if ($xml) {
        	
    
            $parsed = new stdClass ();
            $parsed->version =(string) $xml->version;
           $parsed->updatedate = (string)$xml->creationDate;
            return $parsed;
        } else {
            throw new ManifestException("Could not load local manifest file", 502);
        }

        
    }
	
	function getManifestInformation($manifestfile=null)	
	{
		if($manifestfile)
		{
			  $xml = simplexml_load_file($manifestfile);
			  var_dump($xml);
		}
		else
		{
			  throw new ManifestException("Could not read downloaded manifest file", 502);
		}
		
	}
}
?>
