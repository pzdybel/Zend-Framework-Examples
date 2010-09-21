<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

	protected function _initDefaults()
	{
		// time zone
		$options = $this->_options;
		if(function_exists('date_default_timezone_set')) {
			date_default_timezone_set($options['app']['timezone']);
		}

		// locale
		$this->bootstrap('locale');
		setlocale(LC_CTYPE, $this->getResource('locale')->toString() . '.utf-8');
	}

	protected function _initComponents()
	{
		// configuration settings
		$config = new Zend_Config($this->_options);
		Zend_Registry::set('config', $config);

		// database resource
		$this->bootstrap('db');
		$db = $this->getPluginResource('db');
		Zend_Registry::set('db', $db->getDbAdapter());

		// session resource
		$this->bootstrap('session');
		$session = $this->getPluginResource('session');
		Zend_Registry::set('session', $session->getSession());

		// logger resource
		$this->bootstrap('log');
		$log = $this->getPluginResource('log');
		Zend_Registry::set('log', $log->getLog());

		// authentication resource
		$this->bootstrap('auth');
		$auth = $this->getPluginResource('auth');
		Zend_Registry::set('auth', $auth->getAuth());
	}

	protected function _initPlugins()
	{
		// front controller resource
		$this->bootstrap('frontcontroller');
		$front = $this->getResource('frontcontroller');

		// error handler plugin
		$front->registerPlugin(new LS_Controller_Plugin_ErrorHandler());

		// access check plugin
		$front->registerPlugin(new LS_Controller_Plugin_AccessCheck());

		// session plugin
		$front->registerPlugin(new LS_Controller_Plugin_Session());

		// module loader plugin
		$front->registerPlugin(new LS_Controller_Plugin_ModuleLoader());

	}

}
