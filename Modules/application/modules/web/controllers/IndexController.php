<?php

class Web_IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {	
		$model = new Web_Model_Test();
		$model->sayHello('Micheal');
    }
    
    public function testAction()
    {
    }
}

