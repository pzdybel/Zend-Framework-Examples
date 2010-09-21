<?php

class LS_Service_Authentication
{

	public function login($username, $password)
	{
		$userGateway = LS_Model_UserGateway::getInstance();
		$user = $userGateway->login($username, $password);

		return $user->isLoggedIn();
	}

	public function logout()
	{
		$userGateway = LS_Model_UserGateway::getInstance();

		return $userGateway->logout();
	}

}
