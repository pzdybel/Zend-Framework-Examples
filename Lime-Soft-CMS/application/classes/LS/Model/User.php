<?php

class LS_Model_User extends LS_Model_AbstractModel
{

	protected $properties = array (
		'id' => null,
		'name' => null,
		'fullName' => null,
		'password' => null,
		'email' => null,
		'role' => 'guest',
		'dateCreated' => null,
		'dateConfirmed' => null,
		'dateLastLogin' => null,
		'banned' => false
	);

	public function __construct($data, $gateway)
	{
		$config = Zend_Registry::get('config');
		$format = $config->app->datetime->format;
		$date = Zend_Date::now();
		$this->properties['dateCreated'] = $date->toString($format);

		parent::__construct($data, $gateway);
	}

    public function login()
    {
		$session = Zend_Registry::get('session');

		if(isset($session->user)) {
			$session->user->logout();
		}

		$auth = Zend_Registry::get('auth');
		$auth->setIdentity($this->name);
		$auth->setCredential($this->password);

		$log = Zend_Registry::get('log');

		$result = Zend_Auth::getInstance()->authenticate($auth)->getCode();
		switch($result) {
			case Zend_Auth_Result::SUCCESS:
				$user = $this->gateway->fetchByName($this->name);
				$this->populate($user->toArray());
				$session->user = $this;
				$log->info('user has logged in');
				break;
			case Zend_Auth_Result::FAILURE:
			case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
			case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
			case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
			case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
			default:
				$this->error = 'Invalid credential';
				$log->warn('unsuccessful attempt to login');
				break;
		}

		return Zend_Auth::getInstance()->hasIdentity();
    }

    public function logout()
    {
		if($this->isLoggedIn()) {

			$log = Zend_Registry::get('log');
			$log->info('user has logged out');

			// clear identity
			Zend_Auth::getInstance()->clearIdentity();
			// clear session variables
			$session = Zend_Registry::get('session');
			$session->unsetAll();

			return true;
		}

		return false;
    }

	public function isLoggedIn()
	{
		if(Zend_Auth::getInstance()->hasIdentity()) {
			$identity = Zend_Auth::getInstance()->getIdentity();

			// to return true this user must be logged in
			if($identity == $this->name) {
				return true;
			}
		}

		return false;
	}

	public function hashPassword()
	{
		$this->password = hash('sha256', $this->password, false);
	}

}
