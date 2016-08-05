<?php

namespace Cms_core\Model\Entity;

use Cms_core\Model\Entity\coreEntity;

class CMSArticle extends coreEntity {
    
    protected $_json_field = "json";//fields name to store json data, empty if no json require
    protected $_nativeFields = array(
        "id",
        "type",
        "cms_title",
        "cms_template",
        "cms_url",
        "cms_slug",
        "cms_module",
        "cms_controller",
        "publish_from",
        "publish_to",
        "is_enabled",
        "is_deleted",
        "is_locked",
        "json",
        "btime",
        "ctime",
    );
    
}