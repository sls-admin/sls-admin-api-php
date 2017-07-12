<?php
//配置文件
$config = [

    'api_root' => 'https://coding.net/api/',
    'api_host' => 'https://coding.net/',

    'host'          => 'https://coding.api.sailengsi.com',
    'client_id'     => '33273cfdf87909434b6ba638b33bbe1b',
    'client_secret' => 'e56b525761ddab9db96555f20260d9bd846f428c',
    'callback'      => 'https://coding.api.sailengsi.com/Callback/index',

    'local'   => [
        'host'          => 'http://coding.api.sls.com',
        'client_id'     => 'd08e24970b025cf68c58883c7ea4824f',
        'client_secret' => '7e9270bdd9bcc3f422354b2567a87af838f492ea',
        'callback'      => 'http://coding.api.sls.com/Callback/index'
    ],
    'release' => [
        'host'          => 'https://coding.api.sailengsi.com',
        'client_id'     => '33273cfdf87909434b6ba638b33bbe1b',
        'client_secret' => 'e56b525761ddab9db96555f20260d9bd846f428c',
        'callback'      => 'https://coding.api.sailengsi.com/Callback/index'
    ],

    'session'            => [
        'prefix'     => 'coding',
        'auto_start' => true,
    ],

    // 默认控制器名
    'default_controller' => 'Login',

    // 默认操作名
    'default_action' => 'login'

];

if ($_SERVER['HTTP_HOST'] === 'coding.api.sls.com') {
    $config['host']          = 'http://coding.api.sls.com';
    $config['client_id']     = 'd08e24970b025cf68c58883c7ea4824f';
    $config['client_secret'] = '7e9270bdd9bcc3f422354b2567a87af838f492ea';
    $config['callback']      = 'http://coding.api.sls.com/Callback/index';
}

return $config;