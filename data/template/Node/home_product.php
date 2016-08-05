<?php
//$sm = $this->getServiceLocator();

//text,select,radio,checkbox,textarea,filemanager
return $customizeFields = array(
    "template_name" => "Product",
    array(
        "field_name" => "node_field1",
        "type" => "text",
        "label" => "Product Name",
        "description" => "Name on webpage",
        "required" => true,
        "placeholder" => "soap",
//        "default" => "",
    ),
    array(
        "field_name" => "node_field3",
        "type" => "text",
        "label" => "Price",
        "description" => "Price on page",
        "required" => false,
        "placeholder" => "4.99",
//        "default" => "",
    ),
    array(
        "field_name" => "node_field2",
        "type" => "filemanager",
        "label" => "Slide image",
        "description" => "Pick up an image",
        "required" => false,
        "dimension" => "suggested size 200x230",
    ),
    array(
        "field_name" => "category",
        "type" => "select",
        "label" => "Category",
        "description" => "Select product category",
        "required" => true,
        "options" => array(
            "dailybarsoap" => "Daily Bar Soap",
            "artisticluxurysoap" => "Artistic Luxurysoap",
            "yourgiftbox" => "Your Giftbox",
        ),
    ),
    array(
        "field_name" => "ref_product",
        "type" => "select_by_ref",
        "label" => "Link Products",
        "description" => "Select products",
        "required" => true,
        "options_ref" => 'cms_product:id:name',//table_name, ref_key, display_data
    ),
);
?>
