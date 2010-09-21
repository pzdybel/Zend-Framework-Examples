<?php

class LS_Controller_Plugin_ModuleLoader extends Zend_Controller_Plugin_Abstract
{

	protected $modules;

	public function __construct()
	{
		$modules = Zend_Controller_Front::getInstance()->getControllerDirectory();
		$this->modules = $modules;
	}

	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
	{
		$module = $request->getModuleName();

		if(!isset($this->modules[$module])) {
			throw new Exception('Module does not exist');
		}

		if($module != 'default' && $module != 'services') {

			$application = new Zend_Application(
				APPLICATION_ENV,
				APPLICATION_PATH . '/modules/' . $module . '/configs/module.ini'
			);

			$path = $this->modules[$module];
			$class = ucfirst($module) . '_Bootstrap';
			if(Zend_Loader::loadFile('Bootstrap.php', dirname($path)) && class_exists($class)) {
				$bootstrap = new $class($application);
				$bootstrap->bootstrap();
			}
		}
	}

}
