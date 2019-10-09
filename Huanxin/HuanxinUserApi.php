<?php
/**
 * 环信用户操作相关api
 * 所有接口用户可以自己控制授权模式或开放模式
 * @author xwzj
 */

namespace Huanxin;


use Huanxin\Exception\HuanxinException;

class HuanxinUserApi extends HuanxinDataBase
{
    //授权token
    protected $token;
    //设置授权token
    public function setToken($token)
    {
        $this->token = $token;
        $this->curl_header[] = 'Authorization:Bearer '.$token;
    }

    //判断是否授权
    public function isTokenSet()
    {
        if(empty($this->token)){
            throw new HuanxinException('请授权获取token');
        }
        return $this->token;
    }

    /**
     * 注册单个用户（授权或开放）用户可以自己控制模式
     * @param $username 环信 ID ;也就是 IM 用户的唯一登录账号
     * @param $password 登录密码
     * @param string $nickname 昵称（可选），在 iOS Apns 推送时会使用的昵称，没有设置返则不会返回
     * @return mixed
     * @throws HuanxinException
     */
    public function insertUser($username,$password,$nickname='')
    {
        $url = $this->getBaseUrl().'/users';
        $post = ['username'=>$username,'password'=>$password,'nickname'=>$nickname];
        return $this->request($url,$post);
    }

    /**
     * 批量注册用户（授权或开放）用户可以自己控制模式
     * @param $post 格式：[{"username":"user1","password":"123","nickname":"testuser1"},{"username":"user2","password":"456","nickname":"testuser2"}]
     * @return mixed
     * @throws HuanxinException
     */
    public function insertUsers($post)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users';
        return $this->request($url,$post);
    }

    /**
     * 获取单个用户
     * @param $IM_id 环信 ID ;也就是 IM 用户的唯一登录账号
     * @return mixed
     * @throws HuanxinException
     */
    public function getUserInfo($IM_id)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users/'.$IM_id;
        $data = $this->request($url);
        return $data;
    }

    /**
     * 批量获取用户
     * @param $limit 获取条数或者是每一页的条数
     * @param $cursor 当前游标，分页时必填
     * @return mixed
     * @throws HuanxinException
     */
    public function getUserList($limit=null,$cursor=null)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users';
        if($limit){
            $url = $url.'?limit='.$limit;
        }
        if($cursor){
            $url = $url.'&cursor='.$cursor;
        }
        $data = $this->request($url);
        return $data;
    }

    /**
     * 删除单个用户
     * @param $IM_id 要删除用户的环信id
     * @return mixed
     * @throws HuanxinException
     */
    public function deleteUser($IM_id)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users/'.$IM_id;
        $data = $this->request_del($url);
        return $data;
    }

    /**
     * 批量删除用户
     * @param $limit 删除的条数
     * @return mixed
     * @throws HuanxinException
     */
    public function deleteUserList($limit)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users?limit='.$limit;
        $data = $this->request_del($url);
        return $data;
    }

    /**
     * 修改用户密码
     * @param $limit 删除的条数
     * @return mixed
     * @throws HuanxinException
     */
    public function modifyPassword($username,$password)
    {
        $this->isTokenSet();
        $url = $this->getBaseUrl().'/users/'.$username.'/password';
        $data = $this->request($url,['newpassword'=>$password]);
        return $data;
    }
}