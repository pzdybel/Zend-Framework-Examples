<?php

class LS_Controller_Plugin_Session extends Zend_Controller_Plugin_Abstract
{

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		Zend_Session::start();
	}

	public function postDispatch(Zend_Controller_Request_Abstract $request)
	{
		// extend cookie time only if this is a production environemnt
		if('production' == APPLICATION_ENV) {
			$config = Zend_Registry::get('config');
			$session = Zend_Registry::get('session');
			if(isset($session->user)) {
				Zend_Session::rememberMe($config->plugin->session->rememberMe->auth);
			}
			else {
				Zend_Session::rememberMe($config->plugin->session->rememberMe->guest);
			}
		}
	}

}
