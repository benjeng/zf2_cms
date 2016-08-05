<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    array(
        "field_name" => "rrp",
        "type" => "text",
        "label" => "RRP$",
        "description" => "Retail Price",
        "required" => false,
        "placeholder" => "",
        "default" => "",
    ),
    array(
        "field_name" => "capacity",
        "type" => "text",
        "label" => "Capacity",
        "description" => "(ml/g)",
        "required" => false,
        "placeholder" => "",
        "default" => "",
    ),
    array(
        "field_name" => "pic1",
        "type" => "filemanager",
        "label" => "Picture-1",
        "required" => false,
        "placeholder" => "",
        "default" => "",
    ),
    array(
        "field_name" => "note",
        "type" => "textarea",
        "label" => "Notes",
        "description" => "",
        "required" => false,
        "placeholder" => "",
    ),
);
?>
