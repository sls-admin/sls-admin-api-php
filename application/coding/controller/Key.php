<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:33
 */

namespace app\coding\controller;

use think\Session;

class Key {
    /*
     * 获取我的key列表
     */
    public function getMyKeys() {
        $resource = http(config('api_root')."user/".Session::get("global_key")."/keys", [
            'access_token' => Session::get('access_token')
        ], 'get');

        return $resource;
    }


    /**
     * 获取指定项目部署公钥列表
     *
     * @param $project_name 项目名称
     *
     * @return array
     */
    public function getDeployKeys($project_name) {
        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/deploy_keys", [
            'access_token' => Session::get('access_token')
        ], 'get');

        return $resource;
    }


    /**
     * 创建项目部署公钥
     *
     * @param $project_name 项目名称
     *
     * fields
     *      title       string
     *      content     string
     *      allowWrite  boolean
     *      expiration  string
     */
    public function createDeployKey($project_name){
        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/deploy_key", [
            'access_token' => Session::get('access_token')
        ], 'post');
        return $resource;
    }


    /**
     * 解绑/删除 指定项目的某个部署公钥
     *
     * @param $project_name     项目名称
     * @param $deploy_key_id    部署公钥ID
     */
    public function deleteDeployKey($project_name,$deploy_key_id){
        //  /api/user/{global_key}/project/*/git/unbind_deploy_key/{id}

        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/unbind_deploy_key/".$deploy_key_id, [
            'access_token' => Session::get('access_token')
        ], 'post');
        return $resource;
    }
}