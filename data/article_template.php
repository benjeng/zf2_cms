<?php

return array(
    "default" => array(
        "name" => "Default",
        "chains" => array(
            "Banner" => array(
                "type" => "test",
                "template" => "banner"
            ),
            "Image" => array(
                "type" => "article",
                "template" => "image"
            ),
        ),
    ),
    "general" => array(
        "name" => "Generic",
        ),
    "home_product" => array(
        "name" => "Slide+Product",
        "chains" => array(
            "Slide" => array(
                "type" => "home_slide",
                "template" => "home_slide"
                ),
            "Product" => array(
                "type" => "home_product",
                "template" => "home_product"
            ),
        ),
    ),
);