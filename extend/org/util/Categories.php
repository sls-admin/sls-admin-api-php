<?php
/**
 * Created by PhpStorm.
 * User: mamanman
 * Date: 2017/2/1
 * Time: 上午8:42
 */

namespace org\util;


/*
 * 处理无线分类数据
 */
class Categories{

    /**
     * 无线分类:组合一维数组
     * @param  [array]  $cate  [无限分类数据]
     * @param  string  $html  [用来做缩进的字符串]
     * @param  integer $pid   [当前数据的父级id]
     * @param  integer $level [等级]
     * @return [array]         [组装好的一维数组]
     */
    public function unlimitedForLevel($cate,  $pid = 0,$html = "&nbsp;&nbsp;&nbsp;&nbsp;", $level = 0) {
        $arr = array();
        foreach ($cate as $value) {
            if ($value["pid"] == $pid) {
                $value["level"] = $level + 1;
                $value["html"] = str_repeat($html, $level);
                $arr[] = $value;
                $arr = array_merge($arr, $this->unlimitedForLevel($cate,  $value["id"], $html,$level + 1));
            }
        }

        return $arr;
    }

    public function test(){
        echo 'extends categories test method';
    }

    /**
     * 无线分类:组合多维数组
     * @param  [array]  $cate  [无限分类数据]
     * @param  string  $cateName  [用来存储子数据的key]
     * @param  integer $pid   [当前数据的父级id]
     * @param  string $pidName [当前数据的父级id的key]
     * @param  string $idName [当前数据的id的key]
     * @return [array]         [组装好的多维数组]
     */
    public function unlimitedForLayer($cate, $cateName = "child", $pid = 0, $pidName = "pid", $idName = "id") {
        $arr = array();
        foreach ($cate as $value) {
            if ($value[$pidName] == $pid) {
                $value[$cateName] = $this->unlimitedForLayer($cate, $cateName, $value[$idName], $pidName, $idName);
                $arr[] = $value;
            }
        }

        return $arr;
    }

    /**
     * 无线分类:通过一个子级id查询所有父级
     * @param  [array]  $cate           [总数据]
     * @param  [int]    $id            [需要查询的子ID]
     * @return [array]  $arr            [返回查到的所有父级数据]
     */
    public function getParents($cate, $id) {
        $arr = array();
        foreach ($cate as $value) {
            if ($value["id"] == $id) {
                $arr[] = $value;
                $arr = array_merge($this->getParents($cate, $value["pid"]), $arr);
            }
        }

        return $arr;
    }

    /**
     * 无线分类:通过一个父级id，查询所有子级ID
     * @param  [array]  $cate           [总数据]
     * @param  [int]    $pid            [需要查询的父ID]
     * @return [array]  $arr            [返回查到的所有子ID]
     */
    public function getChildsId($cate, $pid) {
        $arr = array();
        foreach ($cate as $value) {
            if ($value["pid"] == $pid) {
                $arr[] = $value["id"];
                // $arr[]=$value;
                $arr = array_merge($arr, $this->getChildsId($cate, $value["id"]));
            }
        }

        return $arr;
    }

    /**
     * 无线分类:通过一个父级id，查询所有子级数据
     * @param  [array]  $cate           [总数据]
     * @param  [int]    $pid            [需要查询的父ID]
     * @return [array]  $arr            [返回查到的所有子数据]
     */
    public function getChildsData($cate, $pid) {
        $arr = array();
        foreach ($cate as $value) {
            if ($value["pid"] == $pid) {
                $arr[] = $value;
                $arr = array_merge($arr, $this->getChildsData($cate, $value["id"]));
            }
        }
        return $arr;
    }

    /**
     * 无线分类:通过一个id，查询自身名称
     * @param  [array] $cate        [总数据]
     * @param  [int]   $id          [需要查询的ID]
     * @return [array] $arr         [返回查到的数据]
     */
    public function getSelfData($cate, $id) {
        $arr = array();
        foreach ($cate as $value) {
            if ($value["id"] == $id) {
                $arr[] = $value["name"];
            }
        }
        return $arr;
    }

}