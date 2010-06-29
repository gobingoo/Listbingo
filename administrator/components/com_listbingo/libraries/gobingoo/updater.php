<?php 
/**
 * Gobingoo Update
 * code Alex
 *
 */
jimport('joomla.filesystem.archive');
jimport('joomla.filesystem.folder');
jimport('joomla.installer.installer');
jimport('joomla.installer.helper');
class GUpdater {

    function update() {
      
            global $option;
            $params = &JComponentHelper::getParams($option);
            $updateserver = $params->get('updateserver', '');
            
            $authkey = FeedbingoHelper::getAuthorizationKey();
            
         gbimport("gobingoo.snoopy");
            $snoopy = new GSnoopy();
            $submitvars = array();
            
            //Check for Registration Key
            $submitvars['option'] = 'com_regserver';
            $submitvars['mod'] = 'check';
            $submitvars['key'] = $params->get('registrationkey', '');

            
            $snoopy->submit($updateserver, $submitvars);
            $xml = $snoopy->results;
            
            if ($xml) {
                gbimport('gobingoo.manifest');
                
                $manifest = new GManifest();
                $remote_manifest = $manifest->parse($xml);
                //No Error in Registration Key. Now Download the zip
                $submitvars['option'] = 'com_regserver';
                $submitvars['mod'] = 'download';
                $submitvars['key'] = $params->get('registrationkey', '');
                $submitvars['auth'] = $authkey;
                echo "<strong>Downloading Update files...</strong><br/>";
                $snoopy->submit($updateserver, $submitvars);
                $update = $snoopy->results;
                if(sizeof($update)<=100)
                {
                	  throw new UpdateException("Download Archive Invalid", 505);
                }
    

                
                $tmppath = JPATH_ROOT.DS."tmp".DS."updates".DS.$option;
                JFolder::create($tmppath);

                
                $tmppath2 = JPATH_ROOT.DS."tmp".DS."updates".DS.$option.DS."latest";
                 $tmppath .= DS."latest.zip";
                if (file_put_contents($tmppath, $update)) {
                	
                    echo "<strong>Exracting Downloaded files...</strong><br/>";
                    if ($archive = JArchive::extract($tmppath, $tmppath2)) {
                    
                        echo "<strong>Exract successful...</strong><br/>";
                        
                        echo "<strong>Updating...</strong><br/>";
                        //Read Manifest File
                        $installer = &JInstaller::getInstance();
                        if (!$installer->install($tmppath2)) {
                            throw new UpdateException('Update failure...', 506);
                        } else {
                            echo "<strong>Updated...</strong><br/>";
                            JInstallerHelper::cleanupInstall($tmppath, $tmppath2);
                            echo "<strong>Cleaned up install...</strong><br/>";
                            
                            echo "<br/><h3>Thanks for updating</h3>";
                        }

                        
                    } else {

                    
                        throw new UpdateException("Could not extract archive", 505);
                    }
                } else {
                    throw new UpdateException('Could not save update file', 503);
                }

                
            } else {
                throw new ServerException('Could not connect to server', 500);
            }

          
    }
    
    function check() {
        global $option;
        $params = &JComponentHelper::getParams($option);
        $updateserver = $params->get('updateserver', '');
        
        gbimport("gobingoo.snoopy");
        $snoopy = new GSnoopy();
        $submitvars = array();
        $submitvars['option'] = 'com_regserver';
        $submitvars['mod'] = 'check';
        $submitvars['key'] = $params->get('registrationkey', '');
        
        $snoopy->submit($updateserver, $submitvars);
        $xml = $snoopy->results;
        
        if ($xml) {
        
            gbimport('gobingoo.manifest');
            
            $manifest = new GManifest();
            $remote_manifest = $manifest->parse($xml);
            
            $local_manifest = $manifest->getCurrentManifest();
             if ($local_manifest->updatedate < $remote_manifest->updatedate || $local_manifest->version < $remote_manifest->version) {
             	return true;
			 }
			 else
			 {
			 	return false;
			 }
          

            
        } else {
            throw new ServerException('Could not connect to server', 500);
        }
        
    }
}
?>
