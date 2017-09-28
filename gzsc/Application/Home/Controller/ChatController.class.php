<?php
namespace Home\Controller;
use Think\Controller;
class ChatController extends Controller {

    private $app_key = '1169170828115245#demo';
    private $client_id = 'YXA6oTgJkIvCEeeTKOdTDiXjkw';
    private $client_secret = 'YXA6p4cEPPVh6dmtA7g2nx5gl9KJWgE';
    /*
    or_name : 1169170828115245
    app_name : demo
    org_admin : 13781174201@139.com
     */
    
    private $url = "https://a1.easemob.com/1169170828115245/demo";

    /*
     * 获取APP管理员Token
     */
    public function __construct(){
        parent::__construct();
        $url = $this->url . "/token";
        $data = array(
            'grant_type' => 'client_credentials',
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        );
        $rs = json_decode($this->curl($url, $data), true);
        $this->token = $rs['access_token'];
    }

    /*
        curl
     */
    private function curl($url, $data, $header = false, $method = "POST"){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if ($header) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        if ($data) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $ret = curl_exec($ch);
        return $ret;
    }

    //二维码
    public function random(){
        //实例化
        $chat_user = D('chat_user');
        $random  = $where['random']= mt_rand(00000000,99999999);
        $info = $chat_user->where($where)->find();
        if($info){
            self::random();
        }else{
            return $random;
        }
    }

    // 注册的用户     (用户名  密码  昵称)
    public function register(){
        //实例化
        $user      = M('user');
        $chat_user = M('chat_user');
        //接收值
        $where['user_id'] = $id = I('get.id','','strip_tags');
        $username = I('get.username','','strip_tags');
        $password = I('get.password','','strip_tags');
        $nickname = I('get.nickname','','strip_tags');
        //判断用户是否已经注册
        $userinfo = $chat_user->where($where)->find();
        if($userinfo){
            $res['code'] = -1;
            $res['msg']  = "该用户已经注册";
        }else{
            //添加到环信服务器
            $url = $this->url . "/users";
            $data = array(
                'username' => $username,
                'password' => $password,
                'nickname' => $nickname
            );
            $header = array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->token
            );
            $res = $this->curl($url, $data, $header, "POST");
            $res = (json_decode($res,true));
            //如果环信修改好了  添加到数据库
            if($res['entities']){
                $date['user_id']  = $map['id'] = $id;
                $date['username'] = $username;
                $date['password'] = $password;
                $date['nickname'] = $nickname;
                $date['addtime']  = date('Y-m_d H:i:s');
                $date['random']   = $random = $this->random();
                //手机号
                $user_tel = $user->where($map)->field('user_phone')->find();
                $date['tel'] = $user_tel['user_phone'];
                $info = $chat_user->add($date);
            }            
        }

        $this->ajaxreturn($res,'JSON');
    }

    //修改昵称
    public function editnickname(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $id       = I('get.id','','strip_tags');
        $username = I('get.username','','strip_tags');
        $nickname = I('get.nickname','','strip_tags');
        //修改环信昵称
        $url = $this->url . "/users/${username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $data['nickname'] = $nickname;
        $res =  $this->curl($url, $data, $header, "PUT");
        $res = json_decode($res,true);
        //如果环信修改好了 修改本服务器
        if($res['entities']){
            $where['user_id'] = $date['user_id']  = $id;
            $date['username'] = $username;
            $date['nickname'] = $nickname;
            $info = $chat_user->where($where)->save($date);
        }        
        $this->ajaxreturn($res,'JSON');
    }

    //修改密码
    public function editpwd(){
        //实例化
        $chat_user = M('chat_user');
        //接收数据
        $username    = I('get.username','','strip_tags');
        $newpassword = I('get.newpassword','','strip_tags');
        //修改环信昵称
        $url = $this->url . "/users/${username}/password";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $data['newpassword'] = $newpassword;
        $res = $this->curl($url, $data, $header, "PUT");
        $res = json_decode($res,true);
        //如果环信修改好了 修改本服务器
        if($res['action'] == 'set user password'){
            $where['username']   = $username;
            $date['password'] = $newpassword;
            $info = $chat_user->where($where)->save($date);
        }        
        $this->ajaxreturn($res,'JSON');
    }

    //添加好友
    public function addfriends(){
        //实例化
        $chat_friends = M('chat_friends');
        $chat_user    = M('chat_user');
        //接收数据
        $json = I('get.json','','strip_tags');
        $jsoninfo = json_decode($json,true);
        $owner_username  = $jsoninfo['owner_username'];
        $friend_username = $jsoninfo['friend_username'];
        $friend_name     = $jsoninfo['friend_name'];
        $friend_groups   = $jsoninfo['friend_groups'];

        //添加好友
        $url = $this->url . "/users/${owner_username}/contacts/users/${friend_username}";
        $header = array(
            'Authorization: Bearer ' . $this->token
        );
        $res = $this->curl($url, "", $header, "POST");
        $res = json_decode($res,true);
        
        //如果环信修改好了 修改本服务器
        if($res['entities']){
            $where1['username'] = $owner_username;
            $where2['username'] = $friend_username;
            $own_id = $chat_user->where($where1)->field('id')->find();
            $fri_id = $chat_user->where($where2)->field('id')->find();
            $data['user_id'] = $own_id['id'];
            $data['friend_id'] = $fri_id['id'];
            $data['friend_name'] = $friend_name;
            $data['friend_groups'] = $friend_groups;
            $info = $chat_friends->add($data);
        }        
        $this->ajaxreturn($res,'JSON');       
    }


}