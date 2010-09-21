<?php

class LS_Acl extends Zend_Acl
{

	public function __construct()
	{
		// get roles
		$roleGateway = LS_Model_AclRoleGateway::getInstance();
		$roles = $roleGateway->getList();
		foreach($roles as $role) {
			if(isset($role->nameParent)) {
				$this->addRole($role, $role->nameParent);
			}
			else {
				$this->addRole($role);
			}
		}
		// get resources
		$resourceGateway = LS_Model_AclResourceGateway::getInstance();
		$resources = $resourceGateway->getList();
		foreach($resources as $resource) {
			if(isset($resource->nameParent)) {
				$this->addResource($resource, $resource->nameParent);
			}
			else {
				$this->addResource($resource);
			}
		}
		// get permissions
		$permissionGateway = LS_Model_AclPermissionGateway::getInstance();
		$permissions = $permissionGateway->getList();
		foreach($permissions as $permission) {
			if($permission->access == 'allow') {
				// allow
				$this->allow($permission->roleName, $permission->resourceName, $permission->privilege);
			}
			else if($permission->access == 'deny') {
				// deny
				$this->deny($permission->roleName, $permission->resourceName, $permission->privilege);
			}
		}
	}

}
