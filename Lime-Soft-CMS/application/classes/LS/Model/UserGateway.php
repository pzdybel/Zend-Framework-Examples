<?php

class LS_Model_UserGateway extends LS_Model_AbstractGateway
{

	public static function getInstance()
	{
		if(!(self::$instance instanceof self))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function fetchByName($name)
	{
		$table = $this->getTable();

		// fetch
		$result = $table->fetchRow(
			$table->select()->where('name=?', $name)
		);

		// return as model
		if(null !== $result) {
			$result = $this->modelFactory($result);
		}

		return $result;
	}

	public function create($data, $validate = true)
	{
		// get model
		$model = $this->modelFactory($data);

		// check if user already exists
		$validator = new Zend_Validate_Db_NoRecordExists(array(
			'table' => 'Users',
			'field' => 'name',
			'adapter' => Zend_Registry::get('db')
		));
		if(!$validator->isValid($model->name)) {
			throw new Exception(implode(', ', $validator->getMessages()));
		}

		// validate properties
		if($validate && !$model->isValid()) {
			throw new Exception($model->getError());
		}

		// hash password
		$model->hashPassword();

		// set id property
		$model->id = (int) parent::create($model);

		return $model;
	}

	public function update($data, $validate = true)
	{
		// get model
		$model = $this->modelFactory($data);

		$modified = $model->isModified('password');
		$element = null;
		if(!$modified) {
			// do not validate password
			$element = 'password';
		}

		// validate properties
		if($validate && !$model->isValid($element, true)) {
			throw new Exception($model->getError());
		}

		if($modified) {
			// hash new password
			$model->hashPassword();
		}

		return parent::update($model);
	}

	public function login($username, $password)
	{
		$user = $this->modelFactory(array(
			'name' => $username,
			'password' => $password
		));
		$user->hashPassword();
		$user->login();

		return $user;
	}

	public function logout()
	{
		$session = Zend_Registry::get('session');
		if(isset($session->user)) {
			return $session->user->logout();
		}

		return false;
	}

}
