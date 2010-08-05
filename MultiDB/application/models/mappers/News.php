<?php

class Application_Model_Mapper_News extends My_Model_Mapper_Db_Multi
{
	protected $_classname = 'Application_Model_DbTable_News';
	
	/**
	 * @return Zend_Db_Table_Rowset
	 */
	public function listItems()
	{
		return $this->getDbTable()->fetchAll();
	}
	
	public function addItem(Application_Model_News $news)
	{
		$this->getDbTable()->insert($this->toArray($news));
	}
	
	public function editItem(Application_Model_News $news, $where)
	{
		/* ... */
	}
	
	public function removeItem($where)
	{
		/* ... */
	}
}