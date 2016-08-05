<?php

namespace Cms_product\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class CMSCategory extends coreEntity {
    
    protected $_json_field = "json";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "type",
        "title",
        "parent_id",
        "json",
        "sortorder",
        "is_enabled",
        "is_deleted",
        "is_locked",
        "btime",
        "ctime",
    );
    
}