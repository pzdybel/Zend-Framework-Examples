<?php

class IndexController extends Zend_Controller_Action
{
	/**
	 * @var Zend_Application_Resource_Multidb
	 */
	protected $multidb;
	
	/**
	 * @var Zend_Application_Bootstrap_Bootstrap
	 */
	protected $bootstrap;	
	
	public function init()
	{
		$this->bootstrap = $this->getInvokeArg('bootstrap');
		$this->multidb = $this->bootstrap->getResource('multidb');
	}
		
	public function indexAction()
	{
		$this->view->headTitle()->append("Lista newsów");
		
		$db = $this->multidb->getDb('db1');
		$newsMapper = new Application_Model_Mapper_News($db);
		$result = $newsMapper->listItems();
		$this->view->db1 = $result;
		
		$db2 = $this->multidb->getDb('db2');
		$newsMapper2 = new Application_Model_Mapper_News($db2);
		$result2 = $newsMapper2->listItems();	
		$this->view->db2 = $result2;	
	}
	
	public function addAction()
	{
		$db = $this->multidb->getDb('db1');
		$newsMapper = new Application_Model_Mapper_News($db);
		$db2 = $this->multidb->getDb('db2');
		$newsMapper2 = new Application_Model_Mapper_News($db2);
		
		$news = new Application_Model_News(null, 'topic', 'text');
		$newsMapper->addItem($news);
		$newsMapper2->addItem($news);
	}
}