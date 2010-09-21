<?php

class LS_Controller_Service extends Zend_Controller_Action
{

	private $service;

	public function init()
	{
		$front = Zend_Controller_Front::getInstance();
		$front->setParam('noErrorHandler', true);

		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$this->service = new Zend_Json_Server();
	}

	protected function setClass($class)
	{
		$this->service->setClass($class);
	}

	public function postDispatch()
	{
		header('Content-Type: application/json');
		if('GET' == $_SERVER['REQUEST_METHOD']) {
			$this->service->setEnvelope(Zend_Json_Server_Smd::ENV_JSONRPC_2);
			$smd = $this->service->getServiceMap();
			echo Zend_Json::prettyPrint($smd);
		}
		else {
			$this->service->handle();
		}
	}

}
