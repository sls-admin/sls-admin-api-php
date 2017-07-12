<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:36
 */

namespace app\coding\controller;

use app\open\controller\Qcloud;
use think\cache;


class QcloudDomain {

    public function getDomainList(){
        $qc=new Qcloud();
        return $qc->getDomainList();
    }


    public function getRecordsList(){
        $request = request();
        $domain=$request->post('domain');
        $recordType=$request->post('recordType');
        if($domain){
            $qc=new Qcloud();
            return $qc->getRecordsList($domain,$recordType);
        }else{
            return json([
                'code'=>1,
                'msg'=>'缺少domain参数！'
            ]);
        }
    }
    
}