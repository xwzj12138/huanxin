<?php
/**
 * 获取token数据
 */

namespace Huanxin;


class HuanxinToken extends HuanxinDataBase
{
    /**
     * 获取token值
     * @return mixed
     */
    public function getToken($client_id,$client_secret)
    {
        $url = $this->getBaseUrl().'/token';
        $post = ['grant_type'=>'client_credentials','client_id'=>$client_id,'client_secret'=>$client_secret];
        return $this->request($url,$post);
    }
}