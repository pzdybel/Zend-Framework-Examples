<?php

class LS_Model_AclPermissionGateway extends LS_Model_AbstractGateway
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
			'primary' => array('idRole', 'idResource', 'privilege')
		));
	}

	public function fetchPermissions($roleId, $resourceId)
	{
		$db = $this->table->getAdapter();
		$stmt = $db->prepare('select * from AclPermissionView where roleId=? and resourceId=?');
		$stmt->bindParam(1, $roleId, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
		$stmt->bindParam(2, $resourceId, PDO::PARAM_INT | PDO::PARAM_INPUT_OUTPUT);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return new LS_Model_Collection($result, $this);
	}

	public function create($data)
	{
		// normalize data
		if(is_array($data)) {
			$data = $this->normalize($data);
		}

		// get model
		$model = $this->modelFactory($data);

		// check if permission already exists
		$result = $this->fetchAll($model->toArray());
		if($result->count()>=1) {
			throw new Exception('Permission already exists');
		}

		// validate properties
		if(!$model->isValid()) {
			throw new Exception($model->getError());
		}

		parent::create($model);

		return $model;
	}

	public function update($date)
	{
		throw new Exception('ACL permission cannot be updated');
	}

	public function getList()
	{
		$db = $this->table->getAdapter();
		$stmt = $db->prepare('select * from AclPermissionView');
		$stmt->execute();
		$result = $stmt->fetchAll();

		return new LS_Model_Collection($result, $this);
	}

	private function normalize($data)
	{
		if(isset($data['role'])) {
			$name = $data['role'];
			$roleGateway = new LS_Model_AclRoleGateway();
			$result = $roleGateway->fetchAll(array(
				'name=?' => $name
			));
			if($result->count()==1) {
				$role = $result->current();
				$data['idRole'] = (int) $role->id;
				unset($data['role']);
			}
		}
		if(isset($data['resource'])) {
			$name = $data['resource'];
			$resourceGateway = new LS_Model_AclResourceGateway();
			$result = $resourceGateway->fetchAll(array(
				'name=?' => $name
			));
			if($result->count()==1) {
				$resource = $result->current();
				$data['idResource'] = (int) $resource->id;
				unset($data['resource']);
			}
		}

		return $data;
	}

}
