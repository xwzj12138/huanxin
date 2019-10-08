<?php
/**
 * 环信基础数据请求类
 * @author xwzj
 */

namespace Huanxin;


use Huanxin\Exception\HuanxinException;

class HuanxinDataBase
{
    //基础url
    private $base_url = 'http://a1.easemob.com';
    //唯一租户标识
    protected $org_name;
    //app名称
    protected $app_name;
    //header头
    public $curl_header = ["Content-type: application/json;charset=UTF-8","Accept: application/json"];

    public function __construct($org_name,$app_name)
    {
        $this->org_name = $org_name;
        $this->app_name = $app_name;
    }

    //获取请求url
    public function getBaseUrl()
    {
        return $this->base_url.'/'.$this->org_name.'/'.$this->app_name;
    }

    //设置唯一租户标识
    public function setOrgName($value)
    {
        $this->org_name = $value;
    }
    //设置app名称
    public function setAppName($value)
    {
        $this->app_name = $value;
    }
    /**
     * @param string $url  url
     * @param int $second   url执行超时时间，默认30s
     * @param array $post  需要post的数据
     */
    protected function request($url, $post=null, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //设置header
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->curl_header );
        //设置请求链接
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        if($post) {
            //post提交方式
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        }
        //运行curl
        $data = curl_exec($ch);
        return $this->returnData($ch,$data);
    }

    /**
     * @param string $url  url
     * @param int $second   url执行超时时间，默认30s
     * @param array $post  需要post的数据
     */
    protected function request_del($url, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        //设置header
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $this->curl_header );
        //设置请求链接
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        return $this->returnData($ch,$data);
    }

    /**
     * 设置返回的结果
     */
    public function returnData($ch,$data)
    {
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
            return json_decode($data,true);
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new HuanxinException("curl出错，错误码:$error");
        }
    }
}