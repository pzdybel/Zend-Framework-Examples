<?php

class LS_Reflection_Application
{

	private $modules = array();

	public function __construct()
	{
		$fc = Zend_Controller_Front::getInstance();
		$directories = $fc->getControllerDirectory();
		foreach($directories as $name => $directory) {
			$this->modules[$name] = new LS_Reflection_Module($name, $directory);
		}
	}

	public function getModules()
	{
		return $this->modules;
	}

}
