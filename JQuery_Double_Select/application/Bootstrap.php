<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{	
	protected function _initAutoload()
	{
	    $autoloader = new Zend_Application_Module_Autoloader(array(
		'namespace' => '',
		'basePath' => dirname(__FILE__),
		'resourceTypes' => array (
				'model' => array(
					'path' => 'models',
					'namespace' => 'Model',
		    	)
	    	)

	    ));
	    return $autoloader;
	}

	protected function _initRoutesAndControllers() 
	{
		$frontController = Zend_Controller_Front::getInstance();
		$frontController->setBaseUrl(BASE_URL);
	}		
	
	protected function _initViewHelper()
	{
		$this->bootstrap('layout');
		$layout = $this->getResource('layout');
		$view = $layout->getView();
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');
		$baseUrl = $view->baseUrl();
		$baseUrl = empty($baseUrl) ? '/' : $baseUrl;
		$view->headScript()->prependScript('var BASE_APP = "' . $baseUrl . '";');
		$view->jQuery()->enable();
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
	}
    protected function _initDbProfiler() 
	{
		$this->bootstrap("db");
		$db = $this->getResource("db");
		$db->setProfiler(new Zend_Db_Profiler_Firebug());
		$db->getProfiler()->setEnabled(true);   
    }
}