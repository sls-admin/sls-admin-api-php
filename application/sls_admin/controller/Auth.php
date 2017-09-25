<?php
namespace app\sls_admin\controller;

use think\Controller;
use think\Request;

class Auth extends Controller {
    protected $beforeActionList = [
        'auth'
    ];

    public function auth() {
        $request = request();
        if ($request->action() !== 'login' && $request->action() !== 'register') {
            $token = $request->header('token');
            if (empty($token)) {
                echo json_encode([
                    'status' => 404,
                    'msg'    => '没有登录！'
                ]);
                die;
            } else {
                $token_info = db('user')
                    ->where([
                        'token' => $token
                    ])
                    ->field(['token'])
                    ->find();

                if (!$token_info) {
                    echo json_encode([
                        'status' => 404,
                        'msg'    => 'token无效！'
                    ]);
                    die;
                }
            }
        }
    }
}