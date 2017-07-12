<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:30
 */

namespace app\coding\controller;

use think\Cache;

class Project {
    /**
     * 分页获取我的所有项目列表
     *
     * @param array $data
     * @param   string  $data.type
     * @param   string  $data.sort
     * @param   int     $data.page
     * @param   int     $data.pageSize
     *
     * @return array
     */
    public function getMyList($data=[
        'type'=>'all',
        'sort'=>'',
        'page'=>1,
        'pageSize'=>10
    ]) {
        $request = request();
        if($request->get('page')){
            $data['page']=$request->get('page');
        }
        if($request->get('pageSize')){
            $data['pageSize']=$request->get('pageSize');
        }
        $data['access_token']=Cache::get('access_token');
        $resource = http(config('api_root')."user/projects", $data, 'get');
        return $resource;
    }


    /**
     * 分页获取我的所有私有项目列表
     *
     * @param array $data
     * @param   string  $data.type
     * @param   int     $data.page
     * @param   int     $data.pageSize
     *
     * @return array
     */
    public function getMyPrivateList($data=[
        'type'=>'joined',
        'page'=>1,
        'pageSize'=>10
    ]){
        $request = request();
        if($request->get('page')){
            $data['page']=$request->get('page');
        }
        if($request->get('pageSize')){
            $data['pageSize']=$request->get('pageSize');
        }

        $data['access_token']=Cache::get('access_token');
        $resource = http(config('api_root')."user/projects/private", $data, 'get');
        return $resource;
    }


    /**
     * 分页获取我的所有公有项目列表
     *
     * @param array $data
     * @param   string  $data.type
     * @param   int     $data.page
     * @param   int     $data.pageSize
     *
     * @return array
     */
    public function getMyPublicList($data=[
        'type'=>'joined',
        'page'=>1,
        'pageSize'=>10
    ]){
        $request = request();
        if($request->get('page')){
            $data['page']=$request->get('page');
        }
        if($request->get('pageSize')){
            $data['pageSize']=$request->get('pageSize');
        }
        $data['access_token']=Cache::get('access_token');
        $resource = http(config('api_root')."user/".Cache::get("global_key")."/projects/public", $data, 'get');
        return $resource;
    }
}