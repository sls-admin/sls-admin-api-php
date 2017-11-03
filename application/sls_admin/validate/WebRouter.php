<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/11/4
 * Time: 上午1:51
 */

namespace app\sls_admin\validate;


use think\Validate;

class WebRouter extends Validate {

    protected $rule = [
        [
            'id',
            'require',
            '缺少主键ID',
        ],
        [
            'pid',
            'require',
            '缺少父级ID',
        ],
        [
            'name',
            'require',
            '路由名称不能为空',
        ],
        [
            'web_path',
            'require',
            '路由路径不能为空',
        ],
        [
            'component_name',
            'require',
            '组件名称不能为空',
        ],
        [
            'component_path',
            'require',
            '组件路径不能为空',
        ],
        [
            'redirect',
            'require',
            '默认子路由不能为空',
        ]
    ];

    protected $scene = [
        'add'             => [
            'pid',
            'name',
            'web_path',
            'redirect'
        ],
        'update_password' => [
            'id'
        ],
        'cn'              => [
            'component_name'
        ],
        'cp'              => [
            'component_path'
        ]
    ];

}