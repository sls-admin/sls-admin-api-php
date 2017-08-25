<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/2/1
 * Time: 下午12:25
 */

namespace app\sls_admin\validate;

use think\Validate;

class Article extends Validate {
    protected $rule = [
        [
            'title',
            'require|unique:article|length:1,226',
            '标题不能为空|标题已存在|标题长度必须在1-226位之间',
        ],
        [
            'content',
            'require',//length:6,26
            '内容不能为空',
        ],
        [
            'cate',
            'require|max:8',
            '分类不能为空|分类名称长度不能超过8位',
        ],
        [
            'tabs',
            'require|array',
            '标签不能为空|标签必须为数组',
        ],
    ];
}