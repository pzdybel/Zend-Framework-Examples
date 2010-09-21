<?php

class LS_Controller_Plugin_ErrorHandler extends Zend_Controller_Plugin_ErrorHandler
{

	public function preDispatch(Zend_Controller_Request_Abstract $request)
	{
		$this->_handleError($request);
	}

}
