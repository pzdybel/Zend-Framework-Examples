<?php

class InstallController extends Zend_Controller_Action
{

	public function indexAction()
	{
		new LS_Install();
	}

}
