<?php

namespace app\sls_admin\controller;

use app\sls_admin\model\User as Model;
use app\sls_admin\validate\User as Validate;
use think\Request;


class User extends Data {

    protected $Model;
    protected $Validate;

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->Model    = new Model();
        $this->Validate = new Validate();
    }


    public function selectUser() {
        //公用查询参数
        $params = $this->request->only([
            'page',
            'page_size',
            'pid'
        ], 'get');


        if (empty($params['pid'])) {
            $params['pid'] = 0;
        } else {
            $params['pid'] = (int)$params['pid'];
        }

        if (empty($params['page'])) {
            $params['page'] = 1;
        } else {
            $params['page'] = (int)$params['page'];
        }
        if (empty($params['page_size'])) {
            $params['page_size'] = 3;
        } else {
            $params['page_size'] = (int)$params['page_size'];
        }


        $userinfo = $this->getUserInfo();

        //查询数据
        $list = $this->Model->page($params['page'], $params['page_size'])
                            ->where([
                                'pid' => $userinfo['id']
                            ])
                            ->field([
                                'id',
                                'username',
                                'pid',
                                'path'
                            ])
                            ->select();

        $new_list = [];
        foreach ($list as $value) {
            $new_list[] = $value->toArray();
            $like_path  = $value['path'].$value['id'];
            $child_list = $this->Model->where([
                'path' => [
                    'like',
                    $like_path."%"
                ],
                'pid'  => [
                    '>=',
                    (int)$value['id']
                ]
            ])
                                      ->order('concat(path,id)')
                                      ->select();
            if (count($child_list) > 0) {
                $new_list = array_merge($new_list, $child_list);
            }
        }

        //获取总数
        //        $total = (int)$this->Model->where([
        //                'pid' => $params['pid']
        //            ])
        //                                  ->count();

        //        $all_total = (int)$this->Model->count();


        return [
            'data'   => [
                'list' => $new_list
            ],
            'status' => 200
        ];
    }


    /**
     * 添加用户
     *
     * @return array
     */
    public function saveUser() {
        $data = $this->request->only(['username'], 'post');
        if (!$this->Validate->scene('create')
                            ->check($data)) {
            return [
                'status' => 1,
                'msg'    => $this->Validate->getError()
            ];
        }

        $userinfo = $this->getUserInfo();

        $data['password'] = md5('123456');
        $data['token']    = md5('123456'.time().$data['username']);
        $data['pid']      = $userinfo['id'];
        $data['path']     = $userinfo['path'].$data['pid'].',';

        if (!$this->Model->save($data)) {
            return [
                'status' => 1,
                'msg'    => '添加失败'
            ];
        }

        unset($data['password']);
        unset($data['token']);

        return [
            'status' => 200,
            'data'   => [
                'info' => $data
            ]
        ];
    }


    /**
     * 用户注册
     *
     * @return array
     */
    public function register() {
        $data = $this->request->only([
            'username',
            'password',
            'repassword'
        ], 'post');


        if (!$this->Validate->scene('add')
                            ->check($data)) {
            return [
                'status' => 1,
                'msg'    => $this->Validate->getError()
            ];
        }


        $data['pid']      = 1;
        $data['path']     = '0,1,';
        $data['status']   = 1;
        $data['password'] = md5($data['password']);
        $data['token']    = md5($data['password'].$data['username'].time());

        unset($data['repassword']);

        $this->Model->save($data);
        $data['id'] = $this->Model->id;

        unset($data['password']);
        unset($data['token']);

        return [
            'status' => 200,
            'data'   => [
                'info' => $data
            ]
        ];
    }


    /**
     * 修改密码
     *
     * @return array
     */
    public function updatePass() {
        $data = $this->request->only([
            'old_password',
            'password',
            'repassword'
        ], 'post');

        if (!$this->Validate->scene('update_password')
                            ->check($data)) {
            return [
                'status' => 1,
                'msg'    => $this->Validate->getError()
            ];
        }

        if (!$this->Model->where([
            'password' => md5($data['old_password']),
            'token'    => $this->request->header('token')
        ])
                         ->find()) {
            return [
                'status' => 1,
                'msg'    => '旧密码不正确'
            ];
        }


        if ($data['old_password'] === $data['password']) {
            return [
                'status' => 1,
                'msg'    => '新密码不能和旧的密码相同'
            ];
        }

        if (!$this->Model->isUpdate(true)
                         ->save([
                             'password' => md5($data['password'])
                         ], [
                             'token' => $this->request->header('token')
                         ])) {
            return [
                'status' => 1,
                'msg'    => '修改失败'
            ];
        }

        return [
            'status' => 200,
            'data'   => []
        ];
    }

}