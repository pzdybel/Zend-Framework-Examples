<?php

class LS_Model_AclPrivilegeGateway extends LS_Model_AbstractGateway
{

	public static function getInstance()
	{
		if(!(self::$instance instanceof self))
		{
			self::$instance = new self();
		}

		return self::$instance;
	}

	protected function __construct()
	{
		parent::__construct(array(
			'table' => 'AclPrivilegeDict',
			'primary' => 'name'
		));
	}

	public function create($data)
	{
		// get model
		$model = $this->modelFactory($data);

		// check if privilege already exists
		$validator = new Zend_Validate_Db_NoRecordExists(array(
			'table' => 'AclPrivilegeDict',
			'field' => 'name',
			'adapter' => Zend_Registry::get('db')
		));
		if(!$validator->isValid($model->name)) {
			throw new Exception(implode(', ', $validator->getMessages()));
		}

		// validate properties
		if(!$model->isValid()) {
			throw new Exception($model->getError());
		}

		parent::create($model);

		return $model;
	}

	public function update($data)
	{
		throw new Exception('ACL privilege cannot be updated');
	}

}
