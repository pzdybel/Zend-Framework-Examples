<?php

class Congregation_IndexController extends Zend_Controller_Action
{

	public function init()
	{
		$config = Zend_Registry::get('config');
		$theme = $config->resources->view->theme->limesoft;
		$module = $this->getRequest()->getModuleName();

		$this->view->dojo()
			->addStyleSheetModule('limesoft.' . $module . '.themes.' . $theme)
			->requireModule('limesoft.congregation.PublicationStock');
	}

	public function indexAction()
	{
	}

}
