<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/9/2
 * Time: 上午1:56
 */

namespace app\sls_admin\controller;

use app\sls_admin\model\WebRouter as Model;
use app\sls_admin\validate\WebRouter as Validate;
use think\Request;

class WebRouter extends Data {

    protected $Model;
    protected $Validate;

    public function __construct(Request $request) {
        parent::__construct($request);
        $this->Model    = new Model();
        $this->Validate = new Validate();
    }

    public function saveRoute() {
        $data = $this->request->only([
            'id',
            'pid',
            'name',
            'web_path',
            'component_name',
            'component_path',
            'redirect',
            'alias',
            'icon_class',
            'desc',
            'sort',
            'extra'
        ], 'post');

        if (empty($data['id'])) {
            if (!$this->Validate->scene('add')
                                ->check($data)) {
                return [
                    'status' => 1,
                    'msg'    => $this->Validate->getError()
                ];
            }

            if (!$this->Validate->scene('cn')
                                ->check($data) && !$this->Validate->scene('cp')
                                                                  ->check($data)) {
                return [
                    'status' => 1,
                    'msg'    => '组件名称和组件路径必须填一个'
                ];
            }
        }

        return [
            'status' => 1,
            'msg'    => 'ok'
        ];
    }

}