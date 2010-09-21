<?php

class LS_Model_AclResourceGateway extends LS_Model_AbstractGateway
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

	public function fetchResourceTree($roleName)
	{
		$db = $this->table->getAdapter();
		$stmt = $db->prepare('call getResourceTree(?)');
		$stmt->bindParam(1, $roleName, PDO::PARAM_STR | PDO::PARAM_INPUT_OUTPUT);
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

		// check if resource already exists
		$validator = new Zend_Validate_Db_NoRecordExists(array(
			'table' => 'AclResources',
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

		// set id property
		$model->id = (int) parent::create($model);

		return $model;
	}

	public function update($data)
	{
		// normalize data
		if(is_array($data)) {
			$data = $this->normalize($data);
		}

		// get model
		$model = $this->modelFactory($data);

		// validate properties
		if(!$model->isValid()) {
			throw new Exception($model->getError());
		}

		return parent::update($model);
	}

	public function getList()
	{
		$db = $this->table->getAdapter();
		$stmt = $db->prepare(
			'select t1.*, t2.name as nameParent from AclResources t1 ' .
			'left join AclResources t2 on t1.idParent = t2.id order by t1.id, t1.idParent'
		);
		$stmt->execute();
		$result = $stmt->fetchAll();

		return new LS_Model_Collection($result, $this);
	}

	private function normalize($data)
	{
		if(isset($data['parent'])) {
			$name = $data['parent'];
			$result = $this->fetchAll(array(
				'name=?' => $name
			));
			if($result->count()==1) {
				$resource = $result->current();
				$data['idParent'] = (int) $resource->id;
				unset($data['parent']);
			}
		}

		return $data;
	}

}
