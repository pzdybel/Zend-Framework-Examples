<?php

class Default_Bootstrap extends Zend_Application_Module_Bootstrap 
{
    protected function _initAutoload()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('Default_');
        $resourceLoader = new Zend_Loader_Autoloader_Resource(array(
            'basePath'	=> APPLICATION_PATH,
            'namespace' => '',
            'resourceTypes' => array(
                'form' => array(
                    'path' => 'forms/',
                    'namespace' => 'Form_'
                ),
                'model' => array(
                    'path' => 'models/',
                    'namespace' => 'Model_'
                )
            )
        ));
        return $autoloader;
    }
	
}
