<?php

require_once 'Zend/Application.php';

defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(__DIR__ . '/../application'));
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

$dir = implode('/', array_intersect(explode('/', $_SERVER['REQUEST_URI']), explode('/', str_replace('\\', '/', APPLICATION_PATH))));
if ($dir[strlen($dir)-1] != '/') {
	$dir .= '/';
}
define('APPLICATION_URL', 'http' . (isset($_SERVER['HTTPS'])?'s':'') . '://' . $_SERVER['HTTP_HOST'] . '/' . $dir);

set_include_path(implode(PATH_SEPARATOR, array(
	realpath(APPLICATION_PATH . '/../application/classes'),
	realpath(APPLICATION_PATH . '/../library'),
	get_include_path()
)));

$application = new Zend_Application(
	APPLICATION_ENV,
	APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()->run();
