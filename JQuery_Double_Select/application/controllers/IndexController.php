<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
		$a = new Application_Model_DbTable_Albums();
		$result = $a->fetchAll();
		$albums = array();
		foreach($result as $album)
		{
			$albums[$album->id] = $album->name;
		}
		if($this->getRequest()->isPost())
		{
			$c = new Application_Model_DbTable_Categories();
			$rows = $c->getCategoriesByIdAlbum($this->_getParam('album', -1));
		    $categories = array();
        	if(!empty($rows)) 
        	{
        		foreach($rows as $row)
        		{
        			$categories[$row->id] = $row->name;
        		}	
        	}
			$form = new Application_Form_DoubleSelect(array('albums' => $albums, 'categories' => $categories));
			if($form->isValid($this->getRequest()->getPost()))
			{
				$this->view->album = array(
					'id' => $form->getValue('album'),
					'name' => $albums[$form->getValue('album')]
				);
				if(isset($categories[$form->getValue('category')])) 
				{
					$this->view->category = array(
						'id' => $form->getValue('category'),
						'name' => $categories[$form->getValue('category')]
					);
				}
			}
		} else {
			$form = new Application_Form_DoubleSelect(array('albums' => $albums));
		}
		
		$this->view->form = $form;
		$this->view->headScript()->appendFile(BASE_URL . 'scripts/double_select.js');
    }
    
    public function ajaxAction()
    {
    	/* Wyłączenie renderowania widoku i layoutu */
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	if(!$this->getRequest()->isXmlHttpRequest()) return; /* tu możesz dać jakieś przekierowanie */
    	
		$categories = new Application_Model_DbTable_Categories();
		$rows = $categories->getCategoriesByIdAlbum($this->_getParam('id', -1));
        $result = array();
        if(!empty($rows)) 
        {
        	foreach($rows as $row)
        	{
        		$result[$row->id] = $row->name;
        	}	
        }
        echo Zend_Json::encode($result);
    }
}

