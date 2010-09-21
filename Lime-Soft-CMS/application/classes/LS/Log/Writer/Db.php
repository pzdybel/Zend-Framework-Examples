<?php

class LS_Log_Writer_Db extends Zend_Log_Writer_Db
{

	protected function _write($event)
	{
		// get user name from session object
		$username = null;
		$session = Zend_Registry::get('session');
		if(isset($session->user)) {
			$username = $session->user->name;
		}

		// save log
		parent::_write(array_merge($event, array(
			'ip' => $_SERVER['REMOTE_ADDR'],
			'username' => $username,
			'useragent' => $_SERVER['HTTP_USER_AGENT'],
			'url' => LS_Utils::getCurrentPageURL()
		)));
	}

}
