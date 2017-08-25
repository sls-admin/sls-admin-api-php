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
            'email',
            'require|email|unique:user|length:5,26',
            '邮箱不能为空|邮箱格式不正确|邮箱已存在|邮箱长度必须在5-26位之间',
        ],
        [
            'username',
            'require|unique:user',//length:6,26
            '用户名不能为空|用户名已存在',
        ],
        [
            'birthday',
            'require|date|before:2006-01-01|after:1930-01-01',
            '生日不能为空|生日格式不正确|生日不能大于2006年|生日不能小于1930年',
        ],
        [
            'address',
            'require',
            '地址不能为空',
        ],
    ];
}