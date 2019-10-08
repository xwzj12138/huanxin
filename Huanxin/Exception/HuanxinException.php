<?php
/**
 * 环信异常处理类
 * @author xwzj
 */

namespace Huanxin\Exception;

class HuanxinException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}