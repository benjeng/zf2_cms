<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea
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
        "field_name" => "content",
        "type" => "htmleditor",
        "label" => "Hello",
        "description" => "Content",
        "required" => false,
        "placeholder" => "",
        "default" => "",
    ),
    array(
        "field_name" => "publish_from",
        "type" => "date",
        "class" => "datepicker",
        "label" => "Publish From",
        "description" => "",
        "required" => false,
        "placeholder" => "",
        "default" => date("Y-m-d"),
    ),
);
?>
