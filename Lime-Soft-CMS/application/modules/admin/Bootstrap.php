<?php

class Admin_Bootstrap extends Zend_Application_Module_Bootstrap
{

	protected function _initAutoload()
	{
		set_include_path(implode(PATH_SEPARATOR, array(
			realpath(APPLICATION_PATH . '/modules/' . $this->getModuleName() . '/classes'),
			get_include_path(),
		)));
	}

}
