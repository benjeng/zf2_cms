<?php

namespace Cms_core\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class CMSNode extends coreEntity {
    
    protected $_json_field = "json";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "type",
        "obj_id",
        "obj_table",
        "root_id",
        "cms_template",
        "is_enabled",
        "sortorder",
        "json",
        "btime",
        "ctime",
    );
    
}