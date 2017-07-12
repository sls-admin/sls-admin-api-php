<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:34
 */

namespace app\coding\controller;

use think\Cache;
use think\Session;

class Branch {
    /**
     * 获取指定项目的分支列表
     *
     * @return array    分页显示分支列表
     */
    public function getList() {
        $request = request();
        $namespace=$request->post('namespace') ? $request->post('namespace') : Cache::get("global_key");
        $project_name=$request->post('project_name');
        if($project_name){
            $resource = http(config('api_root')."user/".$namespace."/project/".$project_name."/git/branches", [
                'access_token' => Cache::get('access_token'),
            ], 'get');

            /*return [
                'code'=>1,
                'msg'=>[
                    'namespace'=>$namespace,
                    'project_name'=>$project_name
                ]
            ];*/

            return $resource;
        }else{
            return json([
                'code'=>1,
                'msg'=>'项目名称不存在',
            ]);
        }
    }
}