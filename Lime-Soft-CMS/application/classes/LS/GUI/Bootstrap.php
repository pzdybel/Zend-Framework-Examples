<?php

class LS_GUI_Bootstrap
{
	const GUI_NAMESPACE = 'limesoft.system';

	private static $instance;

	private $properties = array();

    private function init()
    {
		$this->setApplicationName();
		$this->setUserName();
    }

	private function setApplicationName()
	{
		$config = Zend_Registry::get('config');
		if(isset($config->app->name)) {
			$this->set('application', $config->app->name);
		}
	}

	private function setUserName()
	{
		$session = Zend_Registry::get('session');
		if(isset($session->user)) {
			$this->set('username', $session->user->name);
		}
	}

	private function set($key, $value)
	{
		$this->properties[$key] = $value;
	}

	public static function generate()
	{
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}

		self::$instance->init();

		$code = '';
		foreach(self::$instance->properties as $key => $value) {
			$code .= self::GUI_NAMESPACE . '.set("' . $key . '","' . $value . '");';
		}

		return 'function(){' . $code . 'dojo.publish(limesoft.topic.ready);}';
	}

}
