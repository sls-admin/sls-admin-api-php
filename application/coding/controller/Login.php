<?php

namespace app\coding\controller;

use think\Cache;
use think\Session;
use app\coding\controller\User;

class Login {
    /**
     * @return mixed获取系统信息
     */
    public function getOptions() {
        $Set  = db('setting');
        $sets = $Set->select();
        if (count($sets) == 0) {
            $setting_info['login_style']          = 1;
            $setting_info['disabled_update_pass'] = '';
            $id                                   = $Set->insertGetId($setting_info);
            $setting_info['id']                   = $id;
        } else {
            $setting_info = $sets[0];
        }

        return $setting_info;
    }


    /**
     * 登录内部系统
     */
    public function login() {
        //定义返回信息
        $data = ['code' => 0];

        //接收参数
        $request = request();

        //强制POST请求
        if ($request->isPost()) {
            //只获取POST过来的用户名和密码，并执行检测
            $userinfo = $request->only([
                'username',
                'password',
                'token'
            ], 'post');
            if (!empty($userinfo['username']) && (!empty($userinfo['password']) || !empty($userinfo['token']))) {

                $userinfo['password'] = md5($userinfo['password']);

                $where = [
                    'username' => $userinfo['username'],
                ];

                if (!empty($userinfo['token'])) {
                    $where['token'] = $userinfo['token'];
                } else {
                    $where['token'] = '';
                }

                if (!empty($userinfo['password'])) {
                    $where['password'] = $userinfo['password'];
                } else {
                    $where['password'] = '';
                }

                //查询检测
                $find = db('user')
                    ->where([
                        'username' => $where['username'],
                        'token'    => $where['token'],
                    ])
                    ->field([
                        'id',
                        'pid',
                        'username',
                        'email',
                        'sex',
                        'status',
                        'create_time',
                        'birthday',
                        'address',
                        'token',
                        'access_status',
                        'web_routers',
                        'api_routers',
                        'default_web_routers'
                    ])
                    ->find();

                if (!$find) {
                    $find = db('user')
                        ->where([
                            'username' => $where['username'],
                            'password' => $where['password'],
                        ])
                        ->field([
                            'id',
                            'pid',
                            'username',
                            'email',
                            'sex',
                            'status',
                            'create_time',
                            'birthday',
                            'address',
                            'token',
                            'access_status',
                            'web_routers',
                            'api_routers',
                            'default_web_routers'
                        ])
                        ->find();
                }

                //如果查询成功，就更新token，并把最新的token赋值到用户信息返回
                if (!$find) {
                    $data['code'] = 1;
                    $data['msg']    = '用户名或者密码不正确!';
                } else {
                    if ($find['status'] == 1) {

                        $setting_info = $this->getOptions();

                        if ($find['pid'] == 0) {
                            $find['is_update_pass'] = 1;
                        } else {
                            if ($setting_info && $setting_info['disabled_update_pass'] && strpos($setting_info['disabled_update_pass'], $find['id'].'') === false) {
                                $find['is_update_pass'] = 1;
                            }
                        }

                        //如果是设置的单点登录，则每次登录，都会更新token，之前登录的信息就会失效
                        if ($setting_info && $setting_info['login_style'] == 1) {
                            $token        = md5(md5($userinfo['username'].time()));
                            $update_token = db('user')
                                ->where($userinfo)
                                ->update(['token' => $token]);

                            if ($update_token) {
                                $find['token'] = $token;
                            }
                        }
                        $data['data']['userinfo'] = $find;
                    } else {
                        $data['code'] = 1;
                        $data['msg']    = '该用户已被禁用!';
                    }
                }
            } else {
                $data['code'] = 1;
                $data['msg']    = '用户名和密码必须填写!';
            }

        } else {
            $data['code'] = 1;
            $data['msg']    = '请求方式必须是post!';
        }

        return json($data);
    }


    /**
     * 登录coding
     */
    public function loginCoding() {
        if(Cache::get('access_token')){
            $User=new User();
            $userinfo=$User->getUserInfo(true);
            if($userinfo['code']!==403){
                return $userinfo;
            }else{
                //这里应该把需要跳转的地方保存起来，然后在回调完成之后跳到到源地址
                header('Location:'.config('api_host').'oauth_authorize.html?client_id='.config('client_id').'&redirect_uri='.config('callback').'&response_type=code&scope=project,user,notification,social');
                die;
            }
        }else{
            //这里应该把需要跳转的地方保存起来，然后在回调完成之后跳到到源地址
            header('Location:'.config('api_host').'oauth_authorize.html?client_id='.config('client_id').'&redirect_uri='.config('callback').'&response_type=code&scope=project,user,notification,social');
            die;
        }
    }


    public function logout(){
        Cache::rm('access_token');
        Cache::rm('access_userinfo');

        return json([
            'code'=>0,
            'data'=>[]
        ]);
    }

}

?>
