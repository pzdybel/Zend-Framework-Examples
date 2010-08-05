<?php

abstract class My_Model_Mapper_Db_Multi extends My_Model_Mapper_Db_Abstract
{
	public function __construct(Zend_Db_Adapter_Abstract $db, Zend_Db_Table_Abstract $dbTable = null)
	{
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		parent::__construct($dbTable);
	}
}