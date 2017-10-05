<?php
/**
*
* All requests come in index than go on routing class;
*/
ini_set('display_errors', 1);
require_once('Autoloader.php');
spl_autoload_register(array('Autoloader', 'loadPackages'));

require_once('config.php');
require_once('application/bootstrap.php');
