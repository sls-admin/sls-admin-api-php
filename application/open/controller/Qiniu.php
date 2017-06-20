<?php
namespace app\open\controller;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;
use think\Log;

require_once APP_PATH.'/../extend/org/qiniu/autoload.php';

/**
 * 七牛常用操作
 */
class Qiniu {

    /**
     * [$auth 实例化七牛认证类]
     * @var [object]
     */
    var $auth;

    /**
     * [$config 七牛配置信息]
     * @var array
     */
    var $config = [];


    /**
     * 构造函数
     *
     * @param array  $config 七牛配置信息，常用配置如下
     * @param string $arr    .bucket 七牛空间名称
     * @param string $arr    .accesskey 七牛秘钥
     * @param string $arr    .secretkey 七牛私钥
     */
    public function __construct($config = []) {

        //默认配置
        $this->config['bucket']    = 'sailengsi';
        $this->config['accesskey'] = config('qiniu.accesskey');
        $this->config['secretkey'] = config('qiniu.secretkey');

        //把传入的参数覆盖默认参数
        if (is_array($config)) {
            foreach ($config as $key => $value) {
                $this->config[$key] = $value;
            }
        }

        //实例化认证类
        $this->auth = new Auth($this->config['accesskey'], $this->config['secretkey']);
    }

    public function index() {
        return 'qiniu index';
    }


    /**
     * 获取前端上传需要的token
     * @return array token和上传需要的key
     */
    public function getToken($key = '') {
        $arr          = [];
        $arr['token'] = $this->auth->uploadToken($this->config['bucket']);
        $arr['key']   = $key;

        return $arr;
    }


    /**
     * 获取指定空间下的资源
     * @return array 从七牛获取到的资源
     */
    public function getFileList() {
        $request   = request();
        $bucketMgr = new BucketManager($this->auth);
        $prefix    = !empty($request->get('prefix'))
            ? $request->get('prefix')
            : '';
        $marker    = !empty($request->get('marker'))
            ? $request->get('marker')
            : '';
        $limit     = !empty($request->get('limit'))
            ? $request->get('limit')
            : 20;
        $res       = $bucketMgr->listFiles($this->config['bucket'], $prefix, $marker, $limit);

        return $res;
        // return $this->config;
    }

    /**
     * 根据key删除七牛上的图片
     *
     * @param $key  图片名
     *
     * @return $err null：删除成功；否则为失败
     */
    public function deleteFile($key) {
        $res       = [];
        $bucketMgr = new BucketManager($this->auth);
        if (!is_array($key)) {
            $res[$key] = $bucketMgr->delete($this->config['bucket'], $key);
        } else {

            for ($i = 0; $i < count($key); $i++) {
                $res[$key[$i]] = $bucketMgr->delete($this->config['bucket'], $key[$i]);
            }
        }

        return $res[$key];
    }

    public function getFileView($key) {
        $bucketMgr = new BucketManager($this->auth);
        //获取文件的状态信息
        $res = $bucketMgr->stat($this->config['bucket'], $key);

        return $res;
    }
}
