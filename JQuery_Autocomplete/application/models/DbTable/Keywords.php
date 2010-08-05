<?php

class Application_Model_DbTable_Keywords extends Zend_Db_Table_Abstract
{
	protected $_name = 'keywords';
	protected $_primary = 'id';
	
	public function getKeywords($keyword = '')
	{
		if(empty($keyword)) return;
		if(mb_strlen($keyword) < 3) return;
		
		$select = $this->select();
		$keyword = '%' . $keyword . '%';
		$select->where('keyword LIKE ?', $keyword);
		
		return $this->fetchAll($select);
	}
}