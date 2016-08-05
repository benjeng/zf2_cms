<?php

namespace Cms_core\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class CMSArticleTable extends AbstractTableGateway {

    protected $table = 'cms_article';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function getRecord($id=1){
        $row = $this->select(array('id' => (int) $id))->current();
        if (!$row) return false;
        $record = new Entity\CMSArticle((array)$row);
        return $record;
    }
    
    public function getAllRecord(){
        $rows = $this->select(function (Select $select){
            $select->order('id asc');
        });
        if (!$rows) return false;
        $records = array();
        foreach($rows as $_row){
            $records[] = new Entity\CMSArticle((array)$_row);
        }
        return $records;
    }
    
    //Get record by single field
    public function getByField($fieldName, $value, $valid_mark = null){
        $where = new Where();
        $where->equalTo($fieldName, $value);
        if($valid_mark){
            $where->equalTo("is_enabled", "1");
            $where->equalTo("is_deleted", "0");
            $where->nest
                    ->lessThanOrEqualTo("publish_from", date("Y-m-d"))
                    ->OR
                    ->isNull("publish_from")
                    ->unnest
                ->AND
                    ->nest
                    ->greaterThanOrEqualTo("publish_to", date("Y-m-d"))
                    ->OR
                    ->isNull("publish_to")
                    ->unnest;
//            $where->greaterThanOrEqualTo("publish_to", date("Y-m-d"));
        }

        $row = $this->select($where)->current();
        if (!$row) return false;
        $record = new Entity\CMSArticle((array)$row);
        return $record;
    }
    
    //Save one record
    public function save(Entity\CMSArticle $record) {
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