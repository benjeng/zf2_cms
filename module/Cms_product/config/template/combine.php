<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    array(
        "field_name" => "test2",
        "type" => "text",
        "label" => "Hello",
        "description" => "Put description here",
        "required" => false,
        "placeholder" => "hello",
//        "default" => "",
    ),
    array(
        "field_name" => "test44",
        "type" => "filemanager",
        "label" => "Image",
        "description" => "Pick up an image",
        "required" => false,
        "dimension" => "20x5",
    ),
);
?>
