Huanxin SDK
======

这是一个环信即时通讯SDK

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
$ composer require xwzj/huanxin 'dev-master'
```

## Basic usage

```php
<?php
/**
 * 以tp5为例
 */

namespace app\common\huanxin;


use Huanxin\Token;

class HuanxinServer
{
    //获取token
    public function getToken()
    {
        $appname = '唯一租户标识';
        $Orgname = 'app唯一标识';
        $huanxin = new Token($Orgname,$appname);
        return $huanxin->getToken('App的client_id','client_secret');
    }
    //添加用户
    public static function addUser($username,$password,$nickname='')
    {
        $config = config('huanxin');
        $huanxin = new UserApi($config['ClientID'],$config['ClientSecret']);
        return $huanxin->insertUser($username,$password,$nickname);
    }
}
```