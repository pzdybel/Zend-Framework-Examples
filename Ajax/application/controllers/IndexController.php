<?php

class IndexController extends Zend_Controller_Action
{
    public function indexAction()
    {
    	$photos = new Model_DbTable_Photos();
        $result = $photos->fetchAll();
        
        $this->view->headScript()->appendFile($this->view->baseUrl('/scripts/jquery.votes.js'));
        $this->view->photos = $result;
    }
    
    public function voteAction()
    {
    	/* Wyłączenie renderowania widoku i layoutu */
    	$this->_helper->layout()->disableLayout();
    	$this->_helper->viewRenderer->setNoRender(true);
    	
    	if(!$this->getRequest()->isXmlHttpRequest()) return; /* tu możesz dać jakieś przekierowanie */
    	
   		$do = $this->getRequest()->getPost('action', null);
        $vid = $this->getRequest()->getPost('id', null);
        
        if($do === null || $vid === null) return; /* tutaj też */

        $photos = new Model_DbTable_Photos();
        $photo = $photos->getPhoto($vid);
		
        if(!$photo) return;
        
        $up = false;
        $down = false;
        if ($do == "vote_up") {
        	$photo->votes_up++;
            $photos->voteUp($vid, $photo->votes_up);
        } elseif ($do == "vote_down") {
        	$photo->votes_down++;
            $photos->voteDown($vid, $photo->votes_down);
        }
        
        echo $photo->votes_up-$photo->votes_down;
    }
}

