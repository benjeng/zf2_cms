<?php
// Core Entity, super class of general entity

namespace Cms_core\Model\Entity;

class coreEntity {
    
    private $_tableFields;//array
    protected $_json_field;//default json field
    protected $_nativeFields;//array of field name

    public function __construct(array $options = null, $defaultOnNative=false) {
        if (is_array($options)) {
            $this->setDatas($options, $defaultOnNative);
        }
        if(trim($this->_json_field)) $this->jsonToFields();
    }

    public function __set($name, $value) {
        $method = 'set' . $name;
        if (method_exists($this, $method)) $this->$method($value);
        else {
            $this->_tableFields[$name] = $value;
        }
        return $this;
    }

    public function __get($name) {
        $method = 'get' . $name;
        if(method_exists($this, $method)) return $this->$method();
        else if(array_key_exists($name, $this->_tableFields)) return $this->_tableFields[$name];
        else {
            throw new \Exception("Invalid Method in coreEntity __get({$name})");
        }
    }

    public function setDatas(array $options, $defaultOnNative=false) {
        if($defaultOnNative)
            foreach($this->_nativeFields as $key) $this->__set($key, null);
        foreach ($options as $key => $value) {
            $this->__set($key, $value);
        }
        return $this;
    }
    
    public function getLogicFields() {
        return $this->_tableFields;
    }
    public function getTableFields() {
        $this->fieldsToJson();
        $_tmp = array();
        foreach($this->_tableFields as $_field => $_value){
            if(in_array($_field, $this->_nativeFields)) $_tmp[$_field] = $_value;
        }
        return $_tmp;
    }
    
    public function jsonToFields() {
        $jsonContent = $this->_tableFields[$this->_json_field];
        $arrJsonFields = json_decode($jsonContent, TRUE);
        if(is_array($arrJsonFields) && count($arrJsonFields)){
            $this->setDatas($arrJsonFields);
        }
        return true;
    }
    
    public function fieldsToJson() {
        $_tmp = array();
        foreach($this->_tableFields as $_field => $_value){
            if(!in_array($_field, $this->_nativeFields)) $_tmp[$_field] = $_value;
        }
        $jsonContent = json_encode($_tmp);
        $this->_tableFields[$this->_json_field] = $jsonContent;
        return true;
    }
}
?>
