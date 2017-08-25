<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/1/30
 * Time: 下午10:14
 */

return [
    'user_system'     => [
        '__file__'   => ['common.php'],
        '__dir__'    => ['controller', 'model', 'view'],
        'controller' => ['Index', 'UserInfo', 'UserRole','UserInfoRole','UserRouter'],
        'model'      => ['UserInfo', 'UserRole','UserInfoRole','UserRouter'],
        'view'       => ['index/index'],
    ],
];