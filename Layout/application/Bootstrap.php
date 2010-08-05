<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Application_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
        	'basePath'	=> APPLICATION_PATH,
            'namespace' => '',
            'resourceTypes' => array(
                'model' => array(
                    'path' => 'models/',
                    'namespace' => 'Model_'
                )
            )
        ));
        return $autoloader;
    }
	
	
	protected function _initLayoutHelper()
    {
        $this->bootstrap('frontController');
        $layout = Zend_Controller_Action_HelperBroker::addHelper(new Amz_Controller_Action_Helper_LayoutLoader());
    }
}