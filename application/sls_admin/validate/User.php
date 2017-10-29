<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/2/1
 * Time: 下午12:25
 */

namespace app\sls_admin\validate;

use think\Validate;

class User extends Validate {
    protected $rule = [
        [
            'username',
            'require|unique:user|length:6,32',
            '用户名不能为空|用户名已存在|用户名长度必须在6-32位之间',
        ],
        [
            'password',
            'require|length:6,32',
            '密码不能为空|密码长度必须在6-32位之间',
        ],
        [
            'repassword',
            'confirm:password',
            '两次密码不一致',
        ],
        [
            'old_password',
            'require',
            '密码不能为空',
        ]
    ];

    protected $scene = [
        'add'             => [
            'username',
            'password',
            'repassword'
        ],
        'create'          => [
            'username'
        ],
        'update_password' => [
            'old_password',
            'password',
            'repassword'
        ]
    ];
}