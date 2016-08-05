<?php

namespace Cms_core\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\AbstractTableGateway;
use Zend\Db\Sql\Select;

class SEOTable extends AbstractTableGateway {

    protected $table = 'seo';

    public function __construct(Adapter $adapter) {
        $this->adapter = $adapter;
    }
    
    public function getRecord($id=1, $object='article'){
        $row = $this->select(array('obj_id' => (int) $id, 'object' => $object))->current();
        if (!$row){//Not exist, auto create one
            $record = new Entity\SEO(array(
                "object" => $object,
                "obj_id" => $id,
                "btime" => date("Y-m-d H:i:s"),
            ));
            $this->insert($record->getTableFields());
        }else
            $record = new Entity\SEO((array)$row);
        return $record;
    }
    
    //Save one record
    public function save(Entity\SEO $record) {
        $data = $record->getTableFields();
        $obj_id = (int)$record->obj_id;
        
        if (!$obj_id) {
            throw new \Exception('SEO does not exist');
        } else {
            $this->update($data, array('obj_id' => $obj_id, 'object' => $record->object));
        }
        return (true);
    }
    
    //Delete record relatve to the parent object
    public function deleteRelative($obj_id)
    {
        $this->delete(array('obj_id' => (int)$obj_id));
    }
}