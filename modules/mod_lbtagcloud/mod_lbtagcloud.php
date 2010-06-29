<?php

// no direct access
defined('_JEXEC') or die('Restricted access');

// Include the helper.php only once
require_once (dirname(__FILE__).DS.'helper.php');

$obj = new modlbtagcloudHelper();
$obj->init($params);

echo $obj->render($params);

if ($params->get('signature'))
{
	echo '<a href="http://www.gobingoo.com" title="Tag cloud module for Listbingo developed by www.gobingoo.com" style="display:block;" target="_blank"><small>Tag Cloud by gobingoo.com</small></a>';
}

?>
