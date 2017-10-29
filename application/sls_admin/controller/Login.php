<?php
namespace app\sls_admin\controller;

use think\Controller;
use think\Db;

/**
 * @api {post} Login/login 登录
 */
class Login extends Controller {

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

    public function login() {
        //定义返回信息
        $data = ['status' => 200];

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
                        'path',
                        'username',
                        'email',
                        'status',
                        'token'
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
                            'path',
                            'username',
                            'email',
                            'status',
                            'token'
                        ])
                        ->find();
                }

                //如果查询成功，就更新token，并把最新的token赋值到用户信息返回
                if (!$find) {
                    $data['status'] = 1;
                    $data['msg']    = '用户名或者密码不正确!';
                } else {
                    if ($find['status'] != 1) {
                        $data['status'] = 1;
                        $data['msg']    = '该用户已被禁用!';
                    }else{
                        $data['data']['userinfo']=$find;
                    }
                }
            } else {
                $data['status'] = 1;
                $data['msg']    = '用户名和密码必须填写!';
            }

        } else {
            $data['status'] = 1;
            $data['msg']    = '请求方式必须是post!';
        }

        return $data;
    }
}
