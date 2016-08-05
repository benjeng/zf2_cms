<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    "template_name" => "Slide",
    array(
        "field_name" => "node_field1",
        "type" => "text",
        "label" => "Message",
        "description" => "Some message",
        "required" => false,
        "placeholder" => "hello",
//        "default" => "",
    ),
    array(
        "field_name" => "node_field2",
        "type" => "filemanager",
        "label" => "Slide image",
        "description" => "Pick up an image",
        "required" => false,
        "dimension" => "20x5",
    ),
);
?>
