<?php

class Application_Model_DbTable_Categories extends Zend_Db_Table_Abstract
{
	protected $_primary = 'id';
	protected $_name = 'albums_categories';
	
	
	public function getCategoriesByIdAlbum($id)
	{
		$select = $this->select();
		$select->where('id_album = ?', $id);

		return $this->fetchAll($select);
	}
}