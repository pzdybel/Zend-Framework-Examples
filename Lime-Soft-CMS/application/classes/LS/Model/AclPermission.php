<?php

class LS_Model_AclPermission extends LS_Model_AbstractModel
{

	protected $properties = array (
		'idRole' => null,
		'idResource' => null,
		'privilege' => null,
		'access' => 'deny'
	);

}
