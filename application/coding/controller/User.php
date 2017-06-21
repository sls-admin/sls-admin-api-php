<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:36
 */

namespace app\coding\controller;

use \think\Session;

use app\coding\controller\Project;
use app\coding\controller\Key;
use app\coding\controller\Webhook;
use app\coding\controller\Branch;


class User {
    /**
     * 登录
     */
    public function login() {
        header('Location:'.config('api_host').'oauth_authorize.html?client_id='.config('client_id').'&redirect_uri='.config('callback').'&response_type=code&scope=project,user,notification,social');
        die;
    }

    /*
    * 获取用户信息接口
    * 可以在这个接口中测试任何一个API
    */
    public function getUserInfo() {
        if (Session::has('access_token')) {
            if (!Session::has('userinfo')) {
                $resource     = http(config('api_root')."current_user", ['access_token' => Session::get('access_token')], 'get');
                $resource_arr = json_decode($resource, true);
                if ($resource_arr['code'] === 0) {
                    Session::set('userinfo', $resource_arr['data']);
                    Session::set('global_key', $resource_arr['data']['global_key']);
                } else {
                    return $resource;
                }
            }


            //             return Key::getMyKeys();
            //            return Project::getMyProjectList();
            //             return Webhook::getMyWebhooksList();
            //            return Branch::getMyBranchesList();
        } else {
            return '没有access_token';
        }
    }
}