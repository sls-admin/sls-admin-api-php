<?php

namespace app\sls_admin\controller;

use org\util\Categories;
use Qiniu\Auth;
use think\Db;

class Index {
    public function index() {
        return [];
    }

    public function testGetQiniuToken() {
        $arr = [];
        require_once APP_PATH.'/../extend/org/qiniu/autoload.php';
        $auth         = new Auth(config('ACCESSKEY'), config('SECRETKEY'));
        $bucket       = 'sailengsi';
        $arr['token'] = $auth->uploadToken($bucket);
        $arr['key']   = mt_rand(33, 126);

        $isQiniuCallback = $auth->verifyCallback('application/x-www-form-urlencoded', '', 'http://slsadmin.api.sailengsi.com/Index/testQiniuCallback', file_get_contents('php://input'));

        return $arr;
    }

    public function testQiniuCallback() {
        $data                = [];
        $data['create_time'] = date('Y-m-d H:i:s', time());
        $data['update_time'] = date('Y-m-d H:i:s', time());
        $data['path']        = 'test';
        db('qiniu')->insertGetId($data);

        return ['test' => 'callback'];
    }

    public function select() {
        $user_list = Db::name('user')
                       ->select();

        //return json($user_list);

        $cate = new Categories();

        $cate->test();
    }
}
