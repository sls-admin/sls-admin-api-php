<?php
namespace app\open\controller;

use think\Log;
use QcloudApi;

require_once APP_PATH.'../extend/org/QcloudApi/QcloudApi.php';

/**
 * 腾讯云API常用操作
 */
class Qcloud {

    var $config=[];
    var $package=[];

    public function __construct() {
        $this->config['SecretId']='AKIDPsFQPDdFT2QdjgT2RfeZMxLXpzxjQg0A';
        $this->config['SecretKey']='A9zf9QVN2Vmtpa9Vf4NVRFvd9UefVewI';
        $this->config['RequestMethod']='GET';
        $this->config['DefaultRegion']='sh';

        $this->package['offset']=0;
        $this->package['SignatureMethod']='HmacSHA256';
    }


    /**
     * 组装错误信息并返回
     *
     * @param $cvm  实例化qcloud
     *
     * @return \think\response\Json
     */
    public function returnError($cvm){
        $error = $cvm->getError();
        return json([
            'code'=>$error->getCode(),
            'message'=>$error->getMessage(),
            'ext'=>$error->getExt()
        ]);
    }


    /**
     * 组装成功信息并返回
     *
     * @param $res  qcloud返回的原始成功信息
     *
     * @return \think\response\Json
     */
    public function returnData($res){
        return json([
            'code'=>0,
            'data'=>$res
        ]);
    }


    /**
     * 获取服务器列表
     * @return array
     */
    public function getServerList(){
        $cvm = QcloudApi::load(QcloudApi::MODULE_CVM, $this->config);
        $res = $cvm->DescribeInstances($this->package);
        if ($res !== false) {
            return $this->returnData($res);
        } else {
            return $this->returnError($cvm);
        }
    }


    /**
     * 获取域名列表
     * @return array
     */
    public function getDomainList(){
        $cvm = QcloudApi::load(QcloudApi::MODULE_CNS, $this->config);
        $package=$this->package;
//        $param['offset']=1;
        $package['length']=20;
        $res = $cvm->DomainList($package);
        if ($res !== false) {
            return $this->returnData($res);
        } else {
            return $this->returnError($cvm);
        }
    }


    /**
     * 获取指定域名的解析列表
     * @return array
     */
    public function getRecordsList($domain,$recordType=''){
        $cvm = QcloudApi::load(QcloudApi::MODULE_CNS, $this->config);
        $package=$this->package;
        $package['domain']=$domain;
        $package['recordType']=$recordType;
        $res = $cvm->RecordList($package);
        if ($res !== false) {
            return $this->returnData($res);
        } else {
            return $this->returnError($cvm);
        }
    }

}
