<?php
namespace Cms_core\View\Helper;
 
use Zend\Http\Request;
use Zend\View\Helper\AbstractHelper;
 
class systeminfoHelper extends AbstractHelper
{
    protected $request;
 
    public function __construct()
    {
    }
 
    public function __invoke()
    {
        return $this;
    }
    
    public function byteToSize($intSize)
    {
        if($intSize > 1024*1024*1024) $result = number_format($intSize/1024/1024/1024,2)." GB";
        elseif($intSize > 1024*1024) $result = number_format($intSize/1024/1024,2)." MB";
        elseif($intSize > 1024) $result = number_format($intSize/1024,2)." KB";
        else $result = $intSize." Bytes";
        return($result);
    }
}