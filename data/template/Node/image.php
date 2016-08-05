<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    "template_name" => "IMAGE",
    array(
        "field_name" => "image_desc",
        "type" => "text",
        "label" => "Description",
        "description" => "Description of the image",
        "required" => false,
        "placeholder" => "",
//        "default" => "",
    ),
    array(
        "field_name" => "image",
        "type" => "filemanager",
        "label" => "Image",
        "description" => "Pick up an image, recommend size is AAA x BBB",
        "required" => false,
    ),
);
?>
