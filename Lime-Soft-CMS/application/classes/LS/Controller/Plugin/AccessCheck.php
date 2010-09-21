<?php

class LS_Controller_Plugin_AccessCheck extends Zend_Controller_Plugin_Abstract
{

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$role = 'guest';
		$auth = Zend_Auth::getInstance();
		if($auth->hasIdentity()) {
			$session = Zend_Registry::get('session');
			$role = $session->user->role;
		}

		$module = $request->getModuleName();
		$controller = $request->getControllerName();
		$action = $request->getActionName();
		$resource = '/' . $module . '/' . $controller . '/' . $action;

		$acl = new LS_Acl();
		if(($acl->has($resource) && $acl->isAllowed($role, $resource, 'read')) || $resource == '/default/install/index') {
			$request->setModuleName($module);
			$request->setControllerName($controller);
			$request->setActionName($action);
		}
		else {
			$request->setModuleName('default');
			$request->setControllerName('error');
			$request->setActionName('permission');
		}
	}

}
