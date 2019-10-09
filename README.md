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


use Huanxin\HuanxinToken;
use Huanxin\HuanxinUserApi;

class HuanxinServer
{
    //获取token
    public function getToken()
    {
        $appname = '唯一租户标识';
        $Orgname = 'app唯一标识';
        $huanxin = new HuanxinToken($Orgname,$appname);
        return $huanxin->getToken('App的client_id','client_secret');
    }
    /**
     * 添加用户
     * @param $username 环信id即环信账号
     * @param $password 登录环信的密码
     * @param string $nickname 昵称（可选），在 iOS Apns 推送时会使用的昵称
     * @return mixed
     * @throws \Huanxin\Exception\HuanxinException
     */
    public static function addUser($username,$password,$nickname='')
    {
        $config = config('huanxin');
        $huanxin = new HuanxinUserApi($config['ClientID'],$config['ClientSecret']);
        return $huanxin->insertUser($username,$password,$nickname);
    }
}
```