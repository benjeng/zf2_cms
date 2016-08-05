<?php

namespace Cms_core\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class SEO extends coreEntity {
    
    protected $_json_field = "";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "object",
        "obj_id",
        "seo_title",
        "seo_description",
        "seo_keywords",
        "btime",
        "ctime",
    );
    
}