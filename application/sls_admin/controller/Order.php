<?php

namespace app\sls_admin\controller;

use org\util\Categories;

class Order extends Data {

    public function statisOrder() {
        $data                   = ['status' => 200];
        $data['data']['statis'] = db('order')
            ->group('status')
            ->column([
                'status',
                'count(status) count'
            ]);

        return $data;
    }

    public function selectOrder() {
        $data = ['status' => 200];

        //接收请求参数
        $request       = request();
        $search_params = $request->except([
            'page',
            'page_size',
            'password',
            'token'
        ]);
        $page_size     = $request->get('page_size')
            ? $request->get('page_size')
            : 3;
        $uids          = [];
        $where         = [];

        foreach ($search_params as $key => $value) {
            $where[$key] = [
                'like',
                '%'.$value.'%'
            ];
        }

        //获取当前用户信息和用户列表
        $userinfo = $this->getUserInfo();
        $list     = $this->getUserList();

        //通过无线分类，获取到当前用户的子数据
        $categories = new Categories();
        $uids       = $categories->getChildsId($list, $userinfo['id']);
        $uids[]     = $userinfo['id'];

        // $where['uid'] = ['in', implode(',', $uids)];
        $list = db('order')
            ->where($where)
            ->field([
                'id',
                'name',
                'status',
                'create_time'
            ])
            ->paginate($page_size);

        $data['data']['list'] = $list;

        return $data;
    }

    public function saveOrder() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);

        //验证文章信息
        $result = $this->validate($data, 'Order');
        if (true !== $result) {
            $return_data['status'] = 1;
            $return_data['msg']    = $result;
        } else {

            //填充默认信息
            $data['create_time'] = date('Y-m-d H:i:s', time());
            $data['update_time'] = date('Y-m-d H:i:s', time());

            //获取当前登录的用户信息ID，给新数据的pid用
            $userinfo    = $this->getUserInfo();
            $data['uid'] = $userinfo['id'];

            //返回插入成功后ID
            $res = db('order')->insertGetId($data);
            if (!$res) {
                $return_data['msg']    = '添加失败';
                $return_data['status'] = 1;
            } else {
                $data['id']                  = $res;
                $return_data['data']['data'] = $data;
            }
        }

        return $return_data;
    }

}
