<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    array(
        "field_name" => "page_title",
        "type" => "text",
        "label" => "Title",
        "description" => "Webpage title",
        "required" => false,
        "placeholder" => "hello",
//        "default" => "",
    ),
    array(
        "field_name" => "logo",
        "type" => "filemanager",
        "label" => "Image",
        "description" => "Pick up an image",
        "required" => false,
        "dimension" => "20x5",
    ),
);
?>
