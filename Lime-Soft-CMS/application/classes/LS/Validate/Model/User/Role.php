<?php

class LS_Validate_Model_User_Role extends Zend_Validate
{

	public function __construct()
	{
		$this->addValidator(new Zend_Validate_Db_RecordExists(array(
			'table' => 'AclRoles',
			'field' => 'name',
			'adapter' => Zend_Registry::get('db')
		)));
		$this->addValidator(new LS_Validate_Model_AclRole_Name());
	}

}
