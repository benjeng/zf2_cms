<?php

namespace Cms_core\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class CMSNodeTable extends AbstractTableGateway {

    protected $table = 'cms_node';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function getRecord($id=1){
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row) return false;
        $record = new Entity\CMSNode((array)$row);
        return $record;
    }
    
    public function getChildren($root_id, $node_type){
        $select = new Select();
        $select->from('cms_node')
               ->where(array('root_id' => $root_id, 'type' => $node_type))
               ->order('sortorder asc');
        $rows = $this->selectWith($select);
        if (!$rows) return false;
        $records = array();
        foreach($rows as $_row){
            $records[] = new Entity\CMSNode((array)$_row);
        }
        return $records;
    }
    
    public function getRootId($obj_id, $obj_table){
        $row = $this->select(array('obj_id' => (int) $obj_id, 'obj_table' => $obj_table, 'root_id' => 0))->current();
        if (!$row) return -1;
        return $row->id;
    }
    
    //Save one record
    public function save(Entity\CMSNode $record) {
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
    
    public function deleteRelative($obj_id)
    {
        $this->delete(array('obj_id' => (int)$obj_id));
    }
    
    public function newSeed($obj_id, $object_table, $type)
    {
        $row = $this->select(array(
            'obj_id' => (int) $obj_id,
            'obj_table' => $object_table,
            'root_id' => 0,
            ))->current();
        if(!$row){
            $data = array(
                'obj_id' => (int) $obj_id,
                'obj_table' => $object_table,
                'btime' => date("Y-m-d H:i:s"),
                'is_enabled' => 1,
                'root_id' => 0,
            );
            $this->insert($data);
            return $this->getLastInsertValue();
        }else
            return $row->id;
    }
    
    public function reorder($arrIDs)
    {
        foreach($arrIDs as $ind => $_id) {
            $data = array(
                'sortorder' => $ind+1,
            );
            $this->update($data, array('id' => $_id));
        }
    }
}