<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap 
{
	protected function _initAutoload()
	{
	    $autoloader = new Zend_Application_Module_Autoloader(array(
		'namespace' => 'Admin',
		'basePath' => dirname(__FILE__),
		'resourceTypes' => array (
				'form' => array(
					'path' => 'forms',
					'namespace' => 'Form',
		    	),
				'model' => array(
					'path' => 'models',
					'namespace' => 'Model',
		    	),
		    	'filter' => array(
		    		'path' => 'views/filters',
		    		'namespace' => 'Filter'
		    	),
		    	'validator' => array(
		    		'path' => 'views/validators',
		    		'namespace' => 'Validator'
		    	)
	    	)

	    ));
	    return $autoloader;
	}
}
