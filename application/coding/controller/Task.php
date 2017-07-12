<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/6/25
 * Time: 下午10:33
 */

namespace app\coding\controller;


use think\Db;

class Task {

    /**
     * 获取任务列表
     *
     * @return \think\response\Json
     */
    public function getList() {
        $res = [
            'code' => 0
        ];

        //接收请求参数
        $request   = request();
        $page_size = $request->get('page_size')
            ? $request->get('page_size')
            : 3;


        //$Task=db('task');
        //$res['data']['list']=$Task->select();

        $res['data'] = db('task')->paginate($page_size);

        return json($res);
    }


    /**
     * 创建人物
     *
     * @return \think\response\Json
     */
    public function saveTask() {
        $res     = [
            'code' => 0
        ];
        $request = request();
        if ($request->isPost()) {
            $data               = $request->only([
                'namespace',
                'project',
                'domain',
                'branch',
                'is_auto_update',
                'path'
            ]);
            $sub_domain         = $request->only('sub_domain');
            $data['sub_domain'] = implode('_', $sub_domain['sub_domain']);
            $data['token']      = md5($data['domain'].$data['project'].time().mt_rand(0, 10000));
            $Task               = db('task');
            $find               = $Task->where([
                'branch'  => $data['branch'],
                'project' => $data['project']
            ])
                                       ->find();
            if ($find) {
                $res['code'] = 1;
                $res['msg']  = '此分支已部署过任务！';
            } else {
                for ($i = 0; $i < count($sub_domain['sub_domain']); $i++) {
                    if (db('TaskDomain')
                        ->where([
                            'domain'     => $data['domain'],
                            'sub_domain' => $sub_domain['sub_domain'][$i],
                            //                        'project'=>$data['project']
                        ])
                        ->find()
                    ) {
                        $res['code'] = 1;
                        $res['msg']  = $sub_domain['sub_domain'][$i].' 这个子域名已部署过任务！';
                        break;
                    }
                }
            }
            if ($res['code'] === 0) {
                $id         = $Task->insertGetId($data);
                $batch_data = [];
                for ($i = 0; $i < count($sub_domain['sub_domain']); $i++) {
                    $sub_domain_data = [
                        'namespace'  => $data['namespace'],
                        'project'    => $data['project'],
                        'domain'     => $data['domain'],
                        'sub_domain' => $sub_domain['sub_domain'][$i],
                        'task_id'    => $id
                    ];
                    $batch_data[]    = $sub_domain_data;
                }
                $TaskSubDomain = db('TaskDomain');
                $TaskSubDomain->insertAll($batch_data);
                $data['id']  = $id;
                $res['data'] = $data;
            }
        } else {
            $res['code'] = 1;
            $res['msg']  = '请求方式必须是post！';
        }

        return json($res);
    }

}