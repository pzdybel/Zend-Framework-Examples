<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
    	$form = new Application_Form_Test();
        $this->view->form = $form;
    }
    
    public function autocompleteAction()
    {
    	/* Wyłączenie renderowania widoku i layoutu */
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	if(!$this->getRequest()->isXmlHttpRequest()) return; /* tu możesz dać jakieś przekierowanie */
    	
		$keywords = new Application_Model_DbTable_Keywords();
		$rows = $keywords->getKeywords($this->_getParam('term', ''));
        $result = array();
        if(!empty($rows)) 
        {
        	foreach($rows as $row)
        	{
        		$result[] = $row->keyword;
        	}	
        }
        echo Zend_Json::encode($result);
    }
}

