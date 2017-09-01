<?php

namespace app\sls_admin\controller;

use org\util\Categories;
use think\Request;

class Data extends Auth {
    /**
     * 获取用户列表
     * @return array 用户列表
     */
    public function getUserList($where = [], $field = [
        'id',
        'pid',
        'username',
        'email',
        'status',
        'sex',
        'address',
        'birthday',
        'create_time',
        'update_time',
    ]) {
        return db('user')
            ->where($where)
            ->field($field)
            ->paginate(20);
    }

    /**
     * 获取用户信息，通过ID或者当前登录用户
     *
     * @param  number $id 用户ID
     *
     * @return arary     用户信息
     */
    public function getUserInfo($id = null) {
        $where = [];
        if ($id !== null) {
            $where['id'] = $id;
        } else {
            $where['token'] = Request::instance()
                                     ->header('token');
        }

        return db('user')
            ->where($where)
            ->field([
                'id',
                'pid',
                'username',
                'email',
                'status',
                'sex',
                'address',
                'birthday',
                'create_time',
                'update_time',
                'access_status',
                'web_routers',
                'api_routers',
                'default_web_routers'
            ])
            ->find();
    }

    /**
     * 检测当前登录用户是否有权限操作
     *
     * @param  number $id 待操作的用户ID
     *
     * @return boolean     是：true;不是：false
     */
    public function checkIsChild($id) {
        if (!$id) {
            return false;
        }

        //当前登录的用户ID
        $id_info = db('user')
            ->field('id')
            ->where('token', Request::instance()
                                    ->header('token'))
            ->find();

        //需要操作的用户信息
        $target_userinfo = $this->getUserInfo($id);

        $self_userinfo = $this->getUserInfo();


        //目标用户的pid大于当前用户的ID，才成立。
        return $target_userinfo['pid'] >= $self_userinfo['id'];
    }

    /**
     * 检测当前登录用户操作的是不是自己的数据
     *
     * @param  number $uid 待检测的用户ID
     *
     * @return boolean     是：true;不是：false
     */
    public function checkIsSelf($uid) {
        if (!$uid) {
            return false;
        }
        //当前登录的用户ID
        $id_info = db('user')
            ->field('id')
            ->where([
                'token' => Request::instance()
                                  ->header('token'),
                'id'    => $uid,
            ])
            ->find();

        if (!$id_info) {
            return false;
        }

        return true;

    }

    public function checkIsParents($id) {

    }

    public function getOptions() {
        $Set  = db('setting');
        $sets = $Set->select();
        if (count($sets) == 0) {
            $setting_info['login_style']          = 1;
            $setting_info['disabled_update_pass'] = '';
            $id                                   = $Set->insertGetId($setting_info);
            $setting_info['id']                   = $id;
        } else {
            $setting_info = $sets[0];
        }

        return $setting_info;
    }
}
