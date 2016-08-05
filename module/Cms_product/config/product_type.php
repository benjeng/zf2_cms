<?php
// Fields definition in ./tempalate/*.php
return array(
    "product" => array(
        "name" => "Product",
        ),
    "combine" => array(
        "name" => "Combine Produt",
        "chains" => array(
            "Banner" => array(
                "type" => "test",
                "template" => "banner"
                ),
            ),
        ),
    "product-var" => array(
        "name" => "Product with variation",
        "chains" => array(
            "Product" => array(
                "type" => "test",
                "template" => "banner"
                ),
            ),
        ),
    );