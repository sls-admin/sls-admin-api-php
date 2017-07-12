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


class QcloudServer {

    public function getServerList(){
        $qc=new Qcloud();
        return $qc->getServerList();
    }

}