<?php
namespace app\sls_admin\controller;

use org\util\Categories;
use think\Db;
use think\Request;

class User {

    /**
     * 查询用户列表信息
     * @return [json] [用户列表]
     */
    public function selectUser() {
        $data = ['status' => 200];

        /*//接收请求参数
        $request = request();
        $params  = $request->get();

        //获取当前用户信息和用户列表
        $User     = db('user');
        $userinfo = $this->getUserInfo();

        //搜索查询
        $where = [];
        if (!empty($request->get('username'))) {
            $where['username'] = [
                'like',
                '%'.$request->get('username').'%'
            ];
        }
        if (!empty($request->get('email'))) {
            $where['email'] = [
                'like',
                '%'.$request->get('email').'%'
            ];
        }

        $list = $this->getUserList($where);

        //通过无线分类，获取到当前用户的子数据
        $categories = new Categories();
        $list       = $categories->unlimitedForLevel($list, $userinfo['id']);*/

        $data['data'] = [];

        return $data;
    }

    /**
     * 修改用户
     * @return josn 需要修改的用户信息
     */
    public function findUser() {
        $data = [
            'status' => 200,
        ];

        //接收参数
        $params = request();
        if ($params->param('id')) {
            //检测当前登录用户是否有权限修改这个人的信息
            if ($this->checkIsChild($params->param('id'))) {
                $data['data']['userinfo'] = $this->getUserInfo($params->param('id'));
            } else {
                $data['msg']    = '只能修改自己以及自己的子数据';
                $data['status'] = 1;
            }
        } else {
            $data['status'] = 1;
            $data['msg']    = '缺少参数ID';
        }

        return $data;
    }

    /**
     * 添加和修改用户公用操作
     * @return json 添加或修改后的信息
     */
    public function saveUser() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);

        //验证用户信息
        $result = $this->validate($data, 'User');
        if (true !== $result) {
            $return_data['status'] = 1;
            $return_data['msg']    = $result;
        } else {

            $data['status'] = $data['status'] === true
                ? 1
                : 2;

            //如果有ID，代表是修改，否则为添加
            if (!empty($data['id'])) {
                //检测当前登录用户是否有权限修改这个用户信息
                if ($this->checkIsChild($data['id'])) {

                    $setInfos = $this->getOptions();
                    $userinfo = $this->getUserInfo($data['id']);
                    if (stripos($setInfos['disabled_update_pass'], $data['id'].'') !== false) {
                        if ($data['username'] && $userinfo['username'] !== $data['username']) {
                            $return_data['msg']    = '测试用户不允许修改用户名';
                            $return_data['status'] = 1;
                        } else {
                            if ($userinfo['status'] !== $data['status']) {
                                $return_data['msg']    = '测试用户不允许修改状态';
                                $return_data['status'] = 1;
                            }
                        }
                    }

                    if ($return_data['status'] != 1) {
                        $res = db('user')
                            ->where('id', $data['id'])
                            ->update($data);
                        if (!$res) {
                            $return_data['msg']    = '修改失败';
                            $return_data['status'] = 1;
                        } else {
                            $return_data['data']['data'] = $data;
                        }
                    }
                } else {
                    $return_data['msg']    = '只能修改自己以及自己的子数据';
                    $return_data['status'] = 1;
                }
            } else {
                //填充默认信息
                $data['create_time'] = date('Y-m-d H:i:s', time());
                $data['password']    = md5('123456');
                $data['token']       = md5(md5($data['username'].time()));

                //获取当前登录的用户信息ID，给新数据的pid用
                $id_info     = db('user')
                    ->field('id')
                    ->where('token', Request::instance()
                                            ->header('token'))
                    ->find();
                $data['pid'] = $id_info['id'];

                //返回插入成功后ID
                $res = db('user')->insertGetId($data);
                if (!$res) {
                    $return_data['msg']    = '添加失败';
                    $return_data['status'] = 1;
                } else {
                    $data['id']                  = $res;
                    $return_data['data']['data'] = $data;
                }
            }
        }

        return $return_data;
    }


    public function register() {
        $return_data = ['status' => 200];

        $request = request();
        $data    = $request->except(['token']);

        if($data){
            if($data['username']){
                if($data['password']){
                    if($data['repassword']){
                        if($data['password']===$data['repassword']){
                            //查询检测
                            $find = db('user')
                                ->where([
                                    'username' => $data['username']
                                ])->find();
                            if($find){
                                $return_data['msg']    = '该用户名已存在';
                                $return_data['status'] = 1;
                            }else{
                                $user_data=[
                                    'username'=>$data['username'],
                                    'password'=>md5($data['password']),
                                    'token'   => md5(md5($data['username'].time())),
                                    'create_time'=>date('Y-m-d H:i:s', time()),
                                    'update_time'=>date('Y-m-d H:i:s', time()),
                                    'pid'=>78,
                                    'sex'=>3,
                                    'email'=>'',
                                    'birthday'=>'1992-11-05',
                                    'address'=>'',
                                    'status'=>1,
                                    'access_status'=>2,
                                    'web_routers'=>'',
                                    'api_routers'=>'',
                                    'default_web_routers'=>''
                                ];
                                $res = db('user')->insertGetId($user_data);
                                if($res){
                                    unset($user_data['password']);
                                    $user_data['id']=$res;
//                                    $return_data['data']['userinfo']=$user_data;
                                }else{
                                    $return_data['msg']    = '注册失败';
                                    $return_data['status'] = 1;
                                }
                            }
                        }else{
                            $return_data['msg']    = '两次输入密码不一致';
                            $return_data['status'] = 1;
                        }
                    }else{
                        $return_data['msg']    = '确认密码不能为空';
                        $return_data['status'] = 1;
                    }
                }else{
                    $return_data['msg']    = '密码不能为空';
                    $return_data['status'] = 1;
                }
            }else{
                $return_data['msg']    = '用户名不能为空';
                $return_data['status'] = 1;
            }
        }else{
            $return_data['msg']    = '没有提交数据';
            $return_data['status'] = 1;
        }

        return $return_data;
    }


    /**
     * 删除用户
     * @return json 删除成功的用户ID
     */
    public function deleteUser() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);
        if ($data && $data['id']) {
            //把用户字符串分割成数组
            $idArr = explode(',', $data['id']);

            //定义不合法用户数组和当前登录用户没有权限操作的数组
            $notIds      = [];
            $notChildIds = [];
            //检测需要删除的用户信息
            //判断当前用户是否存在，并检测是否有操作权限
            for ($i = 0; $i < count($idArr); $i++) {
                if ($this->getUserInfo($idArr[$i]) === false) {
                    $notIds[] = $idArr[$i];
                }
                if ($this->checkIsChild($idArr[$i]) === false) {
                    $notChildIds[] = $idArr[$i];
                }
            }

            //判断是否有不存在用户信息和是否有无权限操作信息
            if (count($notIds) === 0) {
                if (count($notChildIds) === 0) {
                    //删除
                    $res = db('user')
                        ->whereIn('id', $idArr)
                        ->delete();
                    if ($res) {
                        $return_data['data']['data'] = $data;
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '删除失败';
                    }
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '没有权限修改ID=('.implode(',', $notChildIds).')的这些用户信息！';
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '没有找到ID=('.implode(',', $notIds).')的这些用户信息！';
            }

        } else {
            $return_data['status'] = 1;
            $return_data['msg']    = '缺少参数ID';
        }

        return $return_data;
    }

    /**
     * 给用户设置某些页面访问权限
     * @return json
     */
    public function setAccessUser() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);
        if ($data && $data['user_id']) {
            //把用户字符串分割成数组
            $idArr = explode(',', $data['user_id']);

            //定义不合法用户数组和当前登录用户没有权限操作的数组
            $notIds      = [];
            $notChildIds = [];
            //检测需要删除的用户信息
            //判断当前用户是否存在，并检测是否有操作权限
            for ($i = 0; $i < count($idArr); $i++) {
                if ($this->getUserInfo($idArr[$i]) === false) {
                    $notIds[] = $idArr[$i];
                }
                if ($this->checkIsChild($idArr[$i]) === false) {
                    $notChildIds[] = $idArr[$i];
                }
            }

            //判断是否有不存在用户信息和是否有无权限操作信息
            if (count($notIds) === 0) {
                if (count($notChildIds) === 0) {
                    //设置权限
                    $res = db('user')
                        ->whereIn('id', $idArr)
                        ->update(['accesss' => $data['user_accesss']]);
                    if ($res !== false) {
                        $return_data['data']['data'] = [];
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '设置权限失败';
                    }
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '没有权限修改ID=('.implode(',', $notChildIds).')的这些用户信息！';
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '没有找到ID=('.implode(',', $notIds).')的这些用户信息！';
            }

        } else {
            $return_data['status'] = 1;
            $return_data['msg']    = '缺少参数ID';
        }

        return $return_data;
    }


    public function updateUserAccess() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except([
            'token',
        ]);

        if (!$data['id']) {
            $return_data['status'] = 1;
            $return_data['msg']    = '缺少用户ID';
        } else {
            //检测当前登录用户是否有权限修改这个用户信息
            if ($this->checkIsChild($data['id'])) {
                $info=[
                    'id'=>$data['id'],
                    'web_routers'         => $data['web_routers'],
                    'api_routers'         => $data['api_routers'],
                    'default_web_routers' => $data['default_web_routers'],
                    'access_status'       => $data['access_status']
                ];
                //设置权限
                $res = db('user')
                    ->where(['id' => $data['id']])
                    ->update([
                        'web_routers'         => $data['web_routers'],
                        'api_routers'         => $data['api_routers'],
                        'default_web_routers' => $data['default_web_routers'],
                        'access_status'       => $data['access_status']
                    ]);

                $return_data['data']['access'] =$info;

            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '您只能操作自己的子数据，不要瞎搞。';
            }
        }

        return $return_data;
    }


    /**
     * 修改密码
     * @return json 空数组
     */
    public function updatePass() {
        $return_data = [
            'status' => 200,
        ];

        //接收参数并验证
        $request = request();
        $data    = $request->except(['token']);
        $result  = $this->validate($data, 'Password');

        if (true !== $result) {
            $return_data['status'] = 1;
            $return_data['msg']    = $result;
        } else {

            $userinfo = $this->getUserInfo();

            $setInfos = $this->getOptions();

            if (stripos($setInfos['disabled_update_pass'], $userinfo['id'].'') === false) {
                //检测输入的旧密码是否正确
                $User = db('user');
                $find = $User->where([
                    'token'    => Request::instance()
                                         ->header('token'),
                    'password' => md5($data['old_password']),
                ])
                             ->find();

                //如果正确就修改密码
                if ($find) {
                    $res = $User->where([
                        'token'    => Request::instance()
                                             ->header('token'),
                        'password' => md5($data['old_password']),
                    ])
                                ->update([
                                    'password' => md5($data['password']),
                                ]);

                    if ($res) {
                        $data['data'] = [];
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '修改密码失败';
                    }
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '旧密码不正确';
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '测试用户不允许修改密码';
            }

        }

        return $return_data;
    }

    public function updateUserStatus() {
        $return_data = ['status' => 200];

        //接收参数并验证
        $request = request();
        if ($request->isPost()) {
            if ($request->post('id')) {
                $uid=$request->post('id');
                $userinfo = $this->getUserInfo();
                if ($this->checkIsChild($uid)) {
                    $status_info = $this->getUserInfo($uid);
                    $res         = db('user')
                        ->where([
                            'id' => $status_info['id'],
                        ])
                        ->update([
                            'status' => $status_info['status'] == 1
                                ? 2
                                : 1,
                        ]);
                    if ($res) {
                        $data['data']['id'] = $uid;
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '修改失败';
                    }
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '对不起，您没有权限操作不属于您的子用户。';
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '缺少用户ID';
            }
        } else {
            $return_data['status'] = 1;
            $return_data['msg']    = '请求方式必须是post';
        }

        return $return_data;
    }
}