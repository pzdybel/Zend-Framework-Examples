<?php

class Congregation_Service_Publication
{

	public function test()
	{
		$pg = Congregation_Model_PublicationGateway::getInstance();
		$result = $pg->fetchAll();

		return $result->toArray();
	}

}
