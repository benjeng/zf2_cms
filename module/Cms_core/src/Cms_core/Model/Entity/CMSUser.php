<?php

namespace Cms_core\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class CMSUser extends coreEntity {
    
    protected $_json_field = "json";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "login",
        "username",
        "password",
        "roles",
        "is_enabled",
        "is_deleted",
        "is_locked",
        "json",
        "btime",
        "ctime",
    );
    
}