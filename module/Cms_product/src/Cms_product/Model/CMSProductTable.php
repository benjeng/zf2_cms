<?php

namespace Cms_product\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class CMSProductTable extends AbstractTableGateway {

    protected $table = 'cms_product';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function getRecord($id=1){
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row) return false;
        $record = new Entity\CMSProduct((array)$row);
        return $record;
    }
    
    public function getAllRecord(){
        $rows = $this->select(function (Select $select){
            $select->order('name asc');
        });
        if (!$rows) return false;
        $records = array();
        foreach($rows as $_row){
            $records[] = new Entity\CMSProduct((array)$_row);
        }
        return $records;
    }
    
    //Save one record
    public function save(Entity\CMSProduct $record) {
        $data = $record->getTableFields();

        $id = (int)$record->id;
        if ($id == 0) {
            $this->insert($data);
            $id = $this->getLastInsertValue();
        } else {
            if ($this->getRecord($id)) {
                $this->update($data, array('id' => $id));
            } else {
                throw new \Exception('id does not exist');
            }
        }
        return ($id);
    }
    
    public function softdelete($id)
    {
        $data = array("is_deleted"=>1, "ctime"=>date("Y-m-d H:i:s"));
        $this->update($data, array('id' => $id));
    }
    public function softrestore($id)
    {
        $data = array("is_deleted"=>0, "ctime"=>date("Y-m-d H:i:s"));
        $this->update($data, array('id' => $id));
    }
    
    public function switchEnable($id)
    {
        $row = $this->select(array('id' => (int) $id))->current();
        $data = array("is_enabled"=>($row->is_enabled?0:1), "ctime"=>date("Y-m-d H:i:s"));
        $this->update($data, array('id' => $id));
    }
    
    public function deleteOne($id)
    {
        $this->delete(array('id' => (int)$id));
    }
}