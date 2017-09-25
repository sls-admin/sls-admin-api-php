<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/9/2
 * Time: 上午1:56
 */

namespace app\sls_admin\controller;

use think\Db;

class WebRouter extends Data {

    public function selectRouter() {
        $return_dasta = [
            'status' => 200
        ];

        $list = Db::query('select * from demo_web_router order by concat(p_path,id)');

        $return_dasta['data']['list'] = $list;

        return $return_dasta;
    }


    public function findRouter() {
        if (!$this->request->isGet()) {
            return [
                'status' => 1,
                'msg'    => '请求方式必须是get！'
            ];
        }

        if (!$this->request->get('id')) {
            return [
                'status' => 1,
                'msg'    => '缺少参数ID！'
            ];
        }

        if ($find = db('web_router')
            ->where(['id' => $this->request->get('id')])
            ->find()) {
            if ($find['pid'] > 0) {
                $parent = db('web_router')
                    ->where(['id' => $find['pid']])
                    ->field(['name'])
                    ->find();
            } else {
                $parent = [];
            }


            return [
                'status' => 200,
                'data'   => [
                    'router_info'        => $find,
                    'parent_router_info' => $parent
                ]
            ];
        } else {
            return [
                'status' => 1,
                'msg'    => '没有找到对应的数据！'
            ];
        }
    }


    public function saveRouter() {
        if (!$this->request->isPost()) {
            return [
                'status' => 1,
                'msg'    => '请求方式必须是post！'
            ];
        }

        $return_data = [
            'status' => 200
        ];


        $data = $this->request->only([
            'id',
            'pid',
            'level',
            'name',
            'path',
            'component',
            'redirect',
            'sort',
            'status',
            'meta',
            'alias',
            'p_path',
            'icon_class'
        ]);

        if (empty($data['id'])) {
            try {
                if ($id = db('web_router')->insertGetId($data)) {
                    $data['id']                        = $id;
                    $return_data['data']['route_info'] = $data;
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '添加路由失败。';
                }

            } catch (\Exception $e) {
                $return_data['status'] = 1;
                $return_data['msg']    = '添加路由错误。'.$e->getCode().':'.$e->getMessage().'!';
            }

        } else {
            try {
                if (db('web_router')
                    ->where([
                        'id' => $data['id']
                    ])
                    ->update($data)) {
                    $return_data['data']['route_info'] = $data;
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '修改路由失败。';
                }

            } catch (\Exception $e) {
                $return_data['status'] = 1;
                $return_data['msg']    = '修改路由错误。'.$e->getCode().':'.$e->getMessage().'!';
            }

        }


        return $return_data;
    }


    public function deleteRouter() {
        $return_data = [
            'status' => 200
        ];

        if (!$this->request->isPost()) {
            $return_data['status'] = 1;
            $return_data['msg']    = '请求方式必须是post。';

            return $return_data;
        }

        if ($return_data['status'] === 200) {
            $id   = $this->request->post('id');
            $find = db('web_router')
                ->where([
                    'id' => $id
                ])
                ->find();
            if ($find) {
                if (db('web_router')
                    ->where([
                        'pid' => $find['id']
                    ])
                    ->find()) {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '不能删除含有子路由的数据';
                } else {
                    if (db('web_router')
                        ->where(['id' => $id])
                        ->delete()) {
                        $return_data['data'] = [];
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '删除失败。';
                    }
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '您要删除的数据不存在';
            }
        }

        return $return_data;
    }

}