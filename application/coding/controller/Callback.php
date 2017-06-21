<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:37
 */

namespace app\coding\controller;

use \think\Session;

class Callback extends User{
    public function index(){

        dump($_GET);
        die;

        $request       = request();
        $url = config('api_root')."oauth/access_token";
        //定义传递的参数数组；
        $data['client_id']=config('client_id');
        $data['client_secret']=config('client_secret');
        $data['grant_type']='authorization_code';
        $data['code']=$request->get('code');
        //定义返回值接收变量；
        $res = http($url, $data, 'POST');
        $res_arr=json_decode($res,true);

        // var_dump($res_arr);
        // var_dump(empty($res_arr['code']));
        // exit;

        if ($res_arr && empty($res_arr['code'])) {
            Session::set('access_token',$res_arr['access_token']);
            return $this->getUserInfo();
        }else{
            return $res;
        }
    }
}