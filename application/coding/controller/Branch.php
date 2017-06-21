<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:34
 */

namespace app\coding\controller;

use think\Session;

class Branch {
    /**
     * 获取指定项目的分支列表
     *
     * @param string $project_name   项目名称
     *
     * @return array    分页显示分支列表
     */
    public function getList($project_name) {
        $userinfo = Session::get("userinfo");
        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/branches", [
            'access_token' => Session::get('access_token'),
        ], 'get');
        return $resource;
    }
}