<?php

namespace Cms_product\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class CMSProduct extends coreEntity {
    
    protected $_json_field = "json";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "name",
        "type",
        "sub_type",
        "url",
        "rrp",
        "is_enabled",
        "is_deleted",
        "is_locked",
        "json",
        "btime",
        "ctime",
    );
    
}