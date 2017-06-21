<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:29
 */

namespace app\coding\controller;

use think\Session;

class Webhook {
    /**
     * 获取指定项目下所有的webhooks
     *
     * @param string $project_name   项目名称
     *
     * @return array 项目设置的所有webhooks
     */
    public function getWebhooks($project_name){
        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/hooks", [
            'access_token' => Session::get('access_token'),
        ], 'get');
        return $resource;
    }


    /**
     * 给指定项目创建webhook
     *
     * @param string $project_name   项目名称
     *
     * @return array 项目设置的所有webhooks
     */
    public function createWebhook($project_name){
        $request = Request::instance();
        if($request->method()==='POST'){
            $data=$request->only(['hook_url','token','type_push','type_mr_pr','type_topic','type_member','type_comment','type_document','type_watch','type_star','type_task']);
            if($data['hook_url'] && $data['token']){
                $data['access_token']=Session::get('access_token');
                $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/hook", $data, 'post');
                return $resource;
            }else{
                return [
                    'status'=>1,
                    'msg'=>'hook_url和token必填。'
                ];
            }
        }else{
            return [
                'status'=>1,
                'msg'=>'请求方式必须是post。'
            ];
        }
    }


    /**
     * 获取指定项目下的某个webhook详情
     *
     * @param string $project_name  项目名称
     * @param int   $hook_id    webhook的ID
     *
     * @return array 项目设置的所有webhooks
     */
    public function getWebhook($project_name,$hook_id){
        $data=[
            'access_token'=>Session::get('access_token')
        ];
        $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/hook/".$hook_id, $data, 'get');
        return $resource;
    }


    /**
     * 修改指定项目下的某个webhook
     *
     * @param string $project_name  项目名称
     * @param int   $hook_id    webhook的ID
     *
     * @return array 项目设置的所有webhooks
     */
    public function updateWebhook($project_name,$hook_id){
        $request = Request::instance();
        if($request->method()==='POST'){
            $data=$request->only(['id','hook_url','token','type_push','type_mr_pr','type_topic','type_member','type_comment','type_document','type_watch','type_star','type_task']);
            if($data['id'] && $data['hook_url'] && $data['token']){
                $data['access_token']=Session::get('access_token');
                $resource = http(config('api_root')."user/".Session::get("global_key")."/project/".$project_name."/git/hook/".$hook_id, $data, 'put');
                return $resource;
            }else{
                return [
                    'status'=>1,
                    'msg'=>'id,hook_url和token必填。'
                ];
            }
        }else{
            return [
                'status'=>1,
                'msg'=>'请求方式必须是post。'
            ];
        }
    }
}