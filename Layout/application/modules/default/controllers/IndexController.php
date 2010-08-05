<?php

class IndexController extends Zend_Controller_Action
{
	
    public function indexAction()
    {
        $model = new Application_Model_Test();
        $model2 = new Application_Model_DbTable_Test();
        
        $form = new Default_Form_Login();
        $model3 = new Default_Model_Test();
        $model4 = new Default_Model_DbTable_Test();
    }


}

