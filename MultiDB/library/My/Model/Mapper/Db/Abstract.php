<?php

abstract class My_Model_Mapper_Db_Abstract
{
	/**
	 * @var string
	 */
	protected $_classname;
	
	/**
	 * @var Zend_Db_Table_Abstract
	 */
	protected $_dbTable;
	
	/**
	 * @param Zend_Db_Table_Abstract $adapter
	 */
	public function __construct(Zend_Db_Table_Abstract $dbTable = null)
	{
		if(!is_null($dbTable)) $this->_dbTable = $dbTable;
	}
	
	/**
	 * @return Zend_Db_Table_Abstract
	 */
	public function getDbTable()
	{
		if(is_null($this->_dbTable)) {
			if(empty($this->_classname)) {
				throw new My_Model_Mapper_Exception("Nie wybrano klasy komunikującej się z bazą");
			} elseif(is_string($this->_classname)) {
				$dbTable = new $this->_classname;
				if(!$dbTable instanceof Zend_Db_Table_Abstract)
				{
					throw new My_Model_Mapper_Exception("Wybrana klasa nie dziedziczy po klasie Zend_Db_Table_Abstract");
				}
				$this->_dbTable = $dbTable;
			} else {
				throw new My_Model_Mapper_Exception("Niewłaściwa nazwa klasy komunikującej się z bazą");
			}
		}
		
		return $this->_dbTable;
	}
	
	/**
	 * @param Zend_Db_Table_Abstract|string $dbTable
	 */
	public function setDbTable($dbTable = null)
	{
		if(is_string($dbTable)) {
			$dbTable = new $dbTable;
		}
		if(!$dbTable instanceof Zend_Db_Table_Abstract)
		{
			throw new My_Model_Mapper_Exception("Wybrana klasa komunikująca się z bazą nie dziedziczy po klasie Zend_Db_Table_Abstract");
		}
		$this->_dbTable = $dbTable;
	}
	
	protected function toArray($obj)
	{
		if(!is_object($obj)) throw new My_Model_Mapper_Exception("Podana zmienna nie jest obiektem");
		$reflection = new ReflectionClass($obj);
		$vars = $reflection->getProperties();
		$result = array();
		foreach($vars as $var)
		{
			$name = $var->getName();
			if(substr($name, 0, 1) == '_') continue;
			$func = 'get' . ucwords($name);
			if(!method_exists($obj, $func)) continue;
			$result[$name] = $obj->$func();
		}
		
		return $result;
	}
}