<?php

class LS_Application_Module_Bootstrap extends Zend_Application_Module_Bootstrap
{

	protected function _initAutoload()
	{
		set_include_path(implode(PATH_SEPARATOR, array(
			realpath(APPLICATION_PATH . '/modules/' . $this->getModuleName() . '/classes'),
			get_include_path(),
		)));
	}

	protected function _initComponents()
	{
		// module configuration settings
		$config = new Zend_Config($this->_options);
		Zend_Registry::set('mconfig', $config);

		// module database resource
		$this->bootstrap('db');
		$db = $this->getPluginResource('db');
		Zend_Registry::set('mdb', $db->getDbAdapter());
	}

}
