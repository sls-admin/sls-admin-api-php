<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/2/1
 * Time: 下午12:25
 */

namespace app\sls_admin\validate;

use think\Validate;

class Password extends Validate {
    protected $rule = [
        [
            'old_password',
            'require',
            '旧密码不能为空',
        ],
        [
            'password',
            'require|length:6,26|confirm',//length:6,26
            '新密码不能为空|新密码长度必须在6-26位之间|两次密码不一致',
        ],
        [
            'password_confirm',
            'require|length:6,26',
            '确认密码不能为空|确认密码长度必须在6',
        ],
    ];
}