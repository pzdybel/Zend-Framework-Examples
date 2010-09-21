<?php

class LS_Install
{

	private $db;

	public function __construct()
	{
		$this->db = Zend_Registry::get('db');

		$options = new Zend_Config(require APPLICATION_PATH . '/configs/install.php');

		$this->populateResources();
		$this->populatePrivileges();
		$this->populateRoles($options->acl->role);
		$this->populatePermissions($options->acl->permission);
		$this->populateUsers($options->user);
	}

	private function populateResources()
	{
		$rg = LS_Model_AclResourceGateway::getInstance();
		$rg->deleteAll();

		$application = new LS_Reflection_Application();
		$rg->create(array('name' => '/'));
		foreach($application->getModules() as $moduleName => $module) {
			$rg->create(array(
				'name' => "/$moduleName",
				'parent' => '/'
			));
			foreach($module->getControllers() as $controlerName => $controller) {
				$rg->create(array(
					'name' => "/$moduleName/$controlerName",
					'parent' => "/$moduleName"
				));
				foreach($controller->getActionNames() as $actionName) {
					$rg->create(array(
						'name' => "/$moduleName/$controlerName/$actionName",
						'parent' => "/$moduleName/$controlerName"
					));
				}
			}
		}
	}

	private function populatePrivileges()
	{
		$pg = LS_Model_AclPrivilegeGateway::getInstance();
		$pg->deleteAll();
		$pg->create(array('name' => 'create'));
		$pg->create(array('name' => 'read'));
		$pg->create(array('name' => 'update'));
		$pg->create(array('name' => 'delete'));
	}

	private function populateRoles($roles)
	{
		$rg = LS_Model_AclRoleGateway::getInstance();
		$rg->deleteAll();
		foreach($roles as $name => $parent) {
			if($parent === null) {
				$rg->create(array(
					'name' => $name
				));
			}
			else {
				$rg->create(array(
					'name' => $name,
					'parent' => $parent
				));
			}
		}
	}

	private function populatePermissions($permissions)
	{
		$pg = LS_Model_AclPermissionGateway::getInstance();
		$pg->deleteAll();
		foreach($permissions as $role => $permission) {
			foreach($permission as $resource => $privileges) {
				foreach($privileges as $privilege => $access) {
					$pg->create(array(
						'role' => $role,
						'resource' => $resource,
						'privilege' => $privilege,
						'access' => $access
					));
				}
			}
		}
	}

	private function populateUsers($user)
	{
		$userGateway = LS_Model_UserGateway::getInstance();
		$userGateway->deleteAll();
		foreach($user->list as $name) {
			$userGateway->create(array(
				'name' => $name,
				'fullName' => $user->$name->fullName,
				'password' => $user->$name->password,
				'email' => $user->$name->email,
				'role' => $user->$name->role
			), false);
		}
	}

}
