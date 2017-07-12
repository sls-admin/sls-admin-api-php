<?php

namespace app\sls_admin\controller;

use think\Request;

class System extends Data {
    protected $beforeActionList = [
        'checkAccess',
    ];

    /**
     * 系统设置需要管理员才能操作，所以设置一个before钩子检测是不是管理员
     * @return [type] [description]
     */
    public function checkAccess() {
        $userinfo = $this->getUserInfo();
        if ($userinfo['pid'] != 0) {
            echo json_encode([
                'status' => 1,
                'msg'    => '只有管理员才有权限操作',
            ]);
            die;
        }
    }

    /**
     * 获取系统设置信息
     * @return \think\Response
     */
    public function getSetting() {
        $data                         = ['status' => 200];
        $setting_info                 = $this->getOptions();
        $list                         = $this->getUserList([
            'pid' => [
                'neq',
                0
            ],
        ], [
            'id',
            'username'
        ]);
        $setting_info['select_users'] = $list;

        $data['data']['setting_info'] = $setting_info;

        return $data;
    }

    /**
     * 保存更新的资源
     *
     * @param  \think\Request $request
     * @param  int            $id
     *
     * @return \think\Response
     */
    public function updateSetting() {
        $data    = ['status' => 200];
        $request = request();
        if ($request->isPost()) {
            if ($request->post('id')) {
                $Setting = db('setting');
                $find    = $Setting->where(['id' => $request->post('id')])
                                   ->find();
                if ($find) {
                    $params['id']                   = $request->post('id');
                    $params['login_style']          = $request->post('login_style');
                    $params['disabled_update_pass'] = $request->post('disabled_update_pass');

                    $res                  = $Setting->where(['id' => $request->post('id')])
                                                    ->update($params);
                    $data['data']['data'] = '设置成功';

                } else {
                    $data['status'] = 1;
                    $data['msg']    = 'ID错误';
                }
            } else {
                $data['status'] = 1;
                $data['msg']    = '缺少参数ID';
            }
        } else {
            $data['status'] = 1;
            $data['msg']    = '只允许POST请求';
        }

        return $data;
    }


    public function getApiRouters(){
        $data=['status'=>200];
        $data['data']['my-key-list']=['/Login/login'=>'登录','/User/selectUser'=>'查看用户列表','/User/saveUser'=>'添加/修改用户','/User/deleteUser'=>'删除用户'];

        return $data;
    }
}
