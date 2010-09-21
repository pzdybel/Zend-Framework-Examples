<?php

class LS_Model_AbstractGateway
{

    protected static $instance;

	protected $config;

	protected $model;

	protected $table;

	protected $validators;

	protected function __construct($options = null)
	{
		$class = get_class($this);
		$prefix = substr($class, 0, strpos($class, '_', 0));

		// get model name
		$name = str_replace(array( $prefix . '_Model_', 'Gateway'), '', get_class($this));

		// get model specyfic options
		$config = null;
		if($prefix == 'LS') {
			// set config for application
			$config = Zend_Registry::get('config');
			if(isset($config->model->$name)) {
				$config = $config->model->$name;
			}
		}
		else {
			// set config for module
			$module = strtolower($prefix);
			$config = Zend_Registry::get('mconfig');
			if(isset($config->model) && isset($config->model->$name)) {
				$config = $config->$module->model->$name;
			}
		}

		// set model
		$this->model = $prefix . '_Model_' . $name;

		// set database
		$adapter = null;
		if($prefix == 'LS') {
			// set adapter for application
			$adapter = Zend_Registry::get('db');
		}
		else {
			// set adapter for module
			$adapter = Zend_Registry::get('mdb');
		}
		$table = $name . 's';
		if(isset($options['table'])) {
			$table = $options['table'];
		}
		$primary = 'id';
		if(isset($options['primary'])) {
			$primary = $options['primary'];
		}
		$this->table = new Zend_Db_Table(array(
			Zend_Db_Table::ADAPTER => $adapter,
			Zend_Db_Table::NAME => $table,
			Zend_Db_Table::PRIMARY => $primary
		));

		// set validators
		if($config != null && isset($config->validation)) {
			foreach($config->validation as $name => $props) {
				$this->validators[$name] = new $props->validator->class();
			}
		}
	}

	protected function setModel($model)
	{
		$this->model = $model;
	}

	public function getModel()
	{
		return $this->model;
	}

	protected function setTable($table)
	{
		$this->table = $table;
	}

	protected function getTable()
	{
		return $this->table;
	}

	public function getValidators()
	{
		return $this->validators;
	}

	protected function modelFactory($object)
	{
		if($object instanceof LS_Model_AbstractModel) {
			return $object;
		}
		else {
			return new $this->model($object, $this);
		}
	}

	public function fetch($id)
	{
		$table = $this->getTable();

		// get primary key
		$keys = $table->info(Zend_Db_Table::PRIMARY);
		if(count($keys) != 1) {
			throw new Exception('There is none or there is a multi-column primary key');
		}
		$key = $keys[1];

		// fetch
		$result = $table->fetchRow(
			$table->select()->where($key . '=?', $id)
		);

		// return as model
		if(null !== $result) {
			$result = $this->modelFactory($result);
		}

		return $result;
	}

	public function fetchAll($where = null)
	{
		$table = $this->getTable();

		// fetch
		$result = $table->fetchAll($where);

		return new LS_Model_Collection($result, $this);
	}

	protected function create($data)
	{
		// get model
		$model = $this->modelFactory($data);

		// insert
		$table = $this->table;
		$result = $table->insert($model->toArray());

		return $result;
	}

	protected function update($data)
	{
		// get model
		$model = $this->modelFactory($data);

		$table = $this->table;

		// get primary key
		$keys = $table->info(Zend_Db_Table::PRIMARY);
		if(count($keys) != 1) {
			throw new Exception('There is none or there is a multi-column primary key');
		}
		$key = $keys[1];

		// update
		$where = $table->getAdapter()->quoteInto($key . '=?', $model->id);
		$result = $table->update($model->toArray(), $where);

		return $result;
	}

	public function updateAll($data, $where = null)
	{
		// get model
		$model = $this->modelFactory($data);

		// update
		$table = $this->table;
		$result = $table->update($model->toArray(), $where);

		return $result;
	}

	public function delete($data)
	{
		// get model
		$model = $this->modelFactory($data);

		$table = $this->table;

		// get primary key
		$keys = $table->info(Zend_Db_Table::PRIMARY);
		if(count($keys) != 1) {
			throw new Exception('There is none or there is a multi-column primary key');
		}
		$key = $keys[1];

		// delete
		$where = $table->getAdapter()->quoteInto($key . '=?', $model->id);
		$result = $table->delete($where);

		return $result;
	}

	public function deleteAll($where = null)
	{
		// delete
		$table = $this->table;
		$result = $table->delete($where);

		return $result;
	}

}
