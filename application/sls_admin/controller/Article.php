<?php
namespace app\sls_admin\controller;

use app\common\controller\Uploads;
use org\util\Categories;
use think\Request;

class Article extends Data {

    public function selectArticle() {
        $data = ['status' => 200];

        //接收请求参数
        $request       = request();
        $search_params = $request->except([
            'page',
            'page_size',
            'password',
            'token',
            'current_page'
        ]);
        $page_size     = $request->get('page_size')
            ? $request->get('page_size')
            : 20;
        $uids          = [];
        $where         = [];

        foreach ($search_params as $key => $value) {
            $where[$key] = [
                'like',
                '%'.$value.'%'
            ];
        }

        //获取当前用户信息和用户列表
        $userinfo = $this->getUserInfo();
        $list     = $this->getUserList();

        //通过无线分类，获取到当前用户的子数据
        $categories = new Categories();
        $uids       = $categories->getChildsId($list, $userinfo['id']);
        $uids[]     = $userinfo['id'];

        $where['uid'] = [
            'in',
            implode(',', $uids)
        ];
        $list         = db('article')
            ->where($where)
            ->field([
                'id',
                'title',
                'content',
                'create_time',
                'status',
                'uid'
            ])
            ->paginate($page_size);

        /*$list = json_decode(json_encode($list), true);
            if (is_array($list['data'])) {
                foreach ($list['data'] as $k => $v) {
                    $list['data'][$k]['content'] = htmlspecialchars_decode($v['content']);
                }
        */

        $data['data']['list'] = $list;

        //$data['data']['uids'] = $uids;

        return $data;
    }

    public function findArticle($id = null) {
        $data         = ['status' => 200];
        $article_info = $this->getArticleInfo(['id' => $id]);

        if ($article_info) {
            if ($this->checkIsChild($article_info['uid']) === false) {
                $data['status'] = 1;
                $data['msg']    = '只能查看自己以及自己的子用户添加的数据！';
            } else {
                $data['data']['article_info'] = $article_info;
            }
        } else {
            $data['status'] = 1;
            $data['msg']    = '您要查看的文章不存在！';
        }

        return $data;
    }

    public function saveArticle() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);

        //验证文章信息
        $result = $this->validate($data, 'Article');
        if (true !== $result) {
            $return_data['status'] = 1;
            $return_data['msg']    = $result;
        } else {
            if (count($data['tabs']) > 5) {
                $return_data['status'] = 1;
                $return_data['msg']    = '标签不能超过5个';
            } else {
                $data['tabs'] = implode(',', $data['tabs']);

                //如果有ID，代表是修改，否则为添加
                if (!empty($data['id'])) {

                    $article_info = $this->getArticleInfo(['id' => $data['id']]);

                    if ($article_info) {
                        $self_article_info = $this->getArticleInfo(['id' => $data['id']], true);
                        $check_is_childs   = $this->checkIsChild($self_article_info['uid']);
                        if ($self_article_info || $check_is_childs) {
                            $res = db('article')
                                ->where('id', $data['id'])
                                ->update($data);
                            if (!$res) {
                                $return_data['msg']    = '修改失败';
                                $return_data['status'] = 1;
                            } else {
                                $return_data['data']['data'] = $data;
                            }
                        } else {
                            $return_data['msg']    = '只能修改自己以及自己的子用户添加的文章';
                            $return_data['status'] = 1;
                        }
                    } else {
                        $return_data['msg']    = '您要修改的文章已不存在';
                        $return_data['status'] = 1;
                    }
                } else {
                    //填充默认信息
                    $data['create_time'] = date('Y-m-d H:i:s', time());
                    $data['update_time'] = date('Y-m-d H:i:s', time());

                    //$data['content'] = htmlspecialchars($data['content']);

                    //获取当前登录的用户信息ID，给新数据的pid用
                    $userinfo    = $this->getUserInfo();
                    $data['uid'] = $userinfo['id'];

                    //返回插入成功后ID
                    $res = db('article')->insertGetId($data);
                    if (!$res) {
                        $return_data['msg']    = '添加失败';
                        $return_data['status'] = 1;
                    } else {
                        $data['id']                  = $res;
                        $return_data['data']['data'] = $data;
                    }
                }
            }
        }

        return $return_data;
    }

    /**
     * 删除文章
     * @return json 删除成功的文章ID
     */
    public function deleteArticle() {
        $return_data = ['status' => 200];

        //接收参数
        $request = request();
        $data    = $request->except(['token']);
        if ($data && $data['id']) {
            //把用户字符串分割成数组
            $idArr = explode(',', $data['id']);

            //定义不合法用户数组和当前登录用户没有权限操作的数组
            $notIds     = [];
            $notSelfIds = [];
            //判断当前用户是否存在
            for ($i = 0; $i < count($idArr); $i++) {
                if ($this->getArticleInfo(['id' => $idArr[$i]]) === false) {
                    $notIds[] = $idArr[$i];
                } else {
                    if ($this->getArticleInfo(['id' => $idArr[$i]], true) === false) {
                        $notSelfIds[] = $idArr[$i];
                    }
                }
            }

            //判断是否有不存在文章信息
            if (count($notIds) === 0) {
                if (count($notSelfIds) === 0) {
                    //删除
                    $res = db('article')
                        ->whereIn('id', $idArr)
                        ->delete();
                    if ($res) {
                        $return_data['data']['data'] = $data;
                    } else {
                        $return_data['status'] = 1;
                        $return_data['msg']    = '删除失败';
                    }
                } else {
                    $return_data['status'] = 1;
                    $return_data['msg']    = '删除失败,ID=('.implode(',', $notSelfIds).')的这些文章不属于您！';
                }
            } else {
                $return_data['status'] = 1;
                $return_data['msg']    = '删除失败，因为ID=('.implode(',', $notIds).')的这些文章不存在！';
            }

        } else {
            $return_data['status'] = 1;
            $return_data['msg']    = '缺少参数ID';
        }

        return $return_data;
    }

    public function checkIsSelfArticle($id = null) {
        if ($id == null) {
            return false;
        }
        $article_info = db('article')
            ->where([
                'id'    => $id,
                'token' => Request::instance()
                                  ->header('token'),
            ])
            ->find();

        return $article_info
            ? $article_info
            : false;
    }

    public function getArticleInfo($where = [], $self = false) {
        if (!is_array($where)) {
            return false;
        }

        if ($self === true) {
            $user_info    = $this->getUserInfo();
            $where['uid'] = $user_info['id'];
        }

        $article_info = db('article')
            ->where($where)
            ->find();

        return $article_info
            ? $article_info
            : false;
    }

    public function editUpload() {
        $data = ['status' => 200];

        $Up  = new Uploads();
        $res = $Up->upload('article', 'temp/'.Request::instance()
                                                     ->request('username').'/');

        if (!empty($res['error'])) {
            $data['status'] = 1;
            $data['msg']    = $res['error'];
        } else {
            $data['data'] = $res;
        }

        return $data;
    }

}