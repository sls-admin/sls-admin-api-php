<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:36
 */

namespace app\coding\controller;

use \think\cache;


class User {
    public function register() {
        $return_data = ['status' => 200];

        $request = request();
        $data    = $request->except(['token']);

        if ($data) {
            if ($data['username']) {
                if ($data['password']) {
                    if ($data['repassword']) {
                        if ($data['password'] === $data['repassword']) {
                            //查询检测
                            $find = db('user')
                                ->where([
                                    'username' => $data['username']
                                ])
                                ->find();
                            if ($find) {
                                $return_data['msg']    = '该用户名已存在';
                                $return_data['status'] = 1;
                            } else {
                                $user_data = [
                                    'username'            => $data['username'],
                                    'password'            => md5($data['password']),
                                    'token'               => md5(md5($data['username'].time())),
                                    'create_time'         => date('Y-m-d H:i:s', time()),
                                    'update_time'         => date('Y-m-d H:i:s', time()),
                                    'pid'                 => 78,
                                    'sex'                 => 3,
                                    'email'               => '',
                                    'birthday'            => '1992-11-05',
                                    'address'             => '',
                                    'status'              => 1,
                                    'access_status'       => 2,
                                    'web_routers'         => '',
                                    'api_routers'         => '',
                                    'default_web_routers' => ''
                                ];
                                $res       = db('user')->insertGetId($user_data);
                                if ($res) {
                                    unset($user_data['password']);
                                    $user_data['id'] = $res;
                                    //                                    $return_data['data']['userinfo']=$user_data;
                                } else {
                                    $return_data['msg']    = '注册失败';
                                    $return_data['status'] = 1;
                                }
                            }
                        } else {
                            $return_data['msg']    = '两次输入密码不一致';
                            $return_data['status'] = 1;
                        }
                    } else {
                        $return_data['msg']    = '确认密码不能为空';
                        $return_data['status'] = 1;
                    }
                } else {
                    $return_data['msg']    = '密码不能为空';
                    $return_data['status'] = 1;
                }
            } else {
                $return_data['msg']    = '用户名不能为空';
                $return_data['status'] = 1;
            }
        } else {
            $return_data['msg']    = '没有提交数据';
            $return_data['status'] = 1;
        }

        return json($return_data);
    }


    /*
    * 获取用户信息接口
    * 可以在这个接口中测试任何一个API
    */
    public function getUserInfo($type=false) {
        if (Cache::get('access_token')) {
            if (!Cache::get('userinfo')) {
                $resource     = http(config('api_root')."current_user", ['access_token' => Cache::get('access_token')], 'get');
                $resource_arr = json_decode($resource, true);
                if ($resource_arr['code'] === 0) {
                    Cache::set('userinfo', $resource_arr['data']);
                    Cache::set('global_key', $resource_arr['data']['global_key']);
                }
            }
            if($type===false){
                return json([
                    'code'=>0,
                    'data'=>Cache::get('userinfo')
                ]);
            }else{
                return [
                    'code'=>0,
                    'data'=>Cache::get('userinfo')
                ];
            }

        } else {
//            $resource     = http(config('api_root')."current_user", ['access_token' => Cache::get('access_token')], 'get');
//            $resource_arr = json_decode($resource, true);
//            if ($resource_arr['code'] === 0) {
//                Cache::set('userinfo', $resource_arr['data']);
//                Cache::set('global_key', $resource_arr['data']['global_key']);
//            }
//            return json([
//                'code'=>0,
//                'data'=>Cache::get('userinfo')
//            ]);


            if($type===false){
                return json(['code'=>403,'msg'=>['login'=>'没有登录']]);
            }else{
                return ['code'=>403,'msg'=>['login'=>'没有登录']];
            }

        }
    }
}