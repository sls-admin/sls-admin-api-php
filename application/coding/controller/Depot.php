<?php
/**
 * Created by PhpStorm.
 * User: sailengsi
 * Date: 2017/5/22
 * Time: 上午12:36
 */

namespace app\coding\controller;


class Depot {
    public function test(){
        echo '<pre>';
//        exec('cp -r /home/www/test/a.txt /home/www/test/b.txt && sed -i "s/a.b.com/b.a.com/g" /home/www/test/b.txt && sed -i "s/\/data\/ab/\/data\/ba/g" /home/www/test/b.txt',$res,$status);
        exec('cat /home/www/test/a.txt',$res,$status);
        echo $status;
        echo '<br />';
        var_dump($res);

        echo '</pre>';
    }
}