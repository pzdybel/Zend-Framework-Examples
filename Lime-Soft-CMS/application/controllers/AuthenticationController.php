<?php

class AuthenticationController extends Zend_Controller_Action
{

	public function loginAction()
	{
		$this->view->dojo()
			->requireModule('limesoft.Login')
			->addOnLoad('function(){dojo.byId("login").appendChild(limesoft.Login.domNode);dojo.publish(limesoft.topic.login,[{ action:"show"}]);}');
	}

	public function logoutAction()
	{
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$userGateway = LS_Model_UserGateway::getInstance();
		$userGateway->logout();
		
		$this->getResponse()->setRedirect(APPLICATION_URL);
	}

}
