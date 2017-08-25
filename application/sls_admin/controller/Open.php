<?php
namespace app\sls_admin\controller;

use app\open\controller\Qiniu;
use Qiniu\Auth;
use think\Request;

class Open extends Data {
    /**
     * @var Qiniu   七牛实例
     */
    var $qiniu;

    /**
     * @var array   七牛配置信息
     */
    var $qiniu_config = [];


    /**
     * Open constructor.    构造函数
     */
    public function __construct() {
        $this->qiniu = new Qiniu([
            'bucket' => 'slsadmin',
        ]);

        $this->qiniu_config['root_path'] = 'test';
    }


    /**
     * 获取七牛上传图片token
     * @return array
     */
    public function getQiniuToken() {
        return [
            'status' => 200,
            'data'   => [
                'qiniu' => $this->qiniu->getToken($this->qiniu_config['root_path'].'/'.date('Y-m-d-h').'/'.md5(date('Ymdhis').rand(1000000, 9999999)))
            ]
        ];
    }


    /**
     * 获取七牛指定空间列表
     * @return array
     */
    public function getQiniuFileList() {
        $res            = $this->qiniu->getFileList();
        $data['status'] = 200;
        if ($res[2] !== null) {
            $data['status'] = 1;
            $data['msg']    = $res[2];
        } else {
            $data['data']['list']            = $res[0];
            $data['data']['other']['marker'] = $res[1];
        }

        return $data;
    }


    /**
     * 删除七牛图片
     * @return array
     */
    public function deleteQiniuFile() {
        $request        = request();
        $data['status'] = 200;
        if (($res = $this->qiniu->deleteFile($request->post('key'))) !== null) {
            $data['status'] = 1;
            $data['msg']    = $res;
        } else {
            $data['data'] = [];
        }

        return $data;
    }


    /**
     * 获取七牛详情
     * @return array
     */
    public function getQiniuFileView() {
        $request        = request();
        $res            = $this->qiniu->getFileView($request->post('key'));
        $data['status'] = 200;
        $data['res']    = $res;

        /*if (res[1]!==null){
            $data['status']=1;
            $data['msg']=$res[1];
        }else{
            $data['data']['file_info']=$res[0];
        }*/

        return $data;
    }

}