<?php

class Model_DbTable_Photos extends Zend_Db_Table_Abstract
{
	protected $_name = 'photos';
	protected $_primary = 'id';
	
	public function getPhoto($id)
	{
		return $this->find($id)->current();
	}
	
    public function voteUp($id, $votes_up)
    {
        $data = array(
            'votes_up' => $votes_up,
        );
        $this->update($data, $this->getAdapter()->quoteInto('id = ?', $id));
    }

    public function voteDown($id, $votes_down)
    {
        $data = array(
            'votes_down' => $votes_down,
        );
        $this->update($data, $this->getAdapter()->quoteInto('id = ?', $id));
    }
}