<?php
namespace app\common\controller;

use think\Controller;

class Uploads extends Controller {
    public function upload($field = 'file', $path = 'temp/') {
        $data = [];

        // 获取表单上传文件
        $request = request();

        // 获取表单上传文件
        $file = $request->file($field);
        // 上传文件验证
        $result = $this->validate(['file' => $file], ['file' => 'require|image|fileExt:jpg,png,jpeg,gif'], [
                'file.require' => '请选择上传文件',
                'file.image'   => '非法图像文件',
                'file.fileExt' => '只允许上传后缀为jpg,png,jpeg,gif的图片',
                //'file.fileSize'=>'图片大小不能超过1M'
            ]);
        if (true !== $result) {
            $data['error'] = $result;
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH.'public'.DS.'uploads/'.$path);
        if ($info) {
            $data['fileinfo']['getExtension'] = $info->getExtension();
            $data['fileinfo']['getSaveName']  = '//'.$request->server('HTTP_HOST').'/uploads/'.$path.$info->getSaveName();
            $data['fileinfo']['getFilename']  = $info->getFilename();
        } else {
            // 上传失败获取错误信息
            $data['error'] = $file->getError();
        }

        return $data;
    }
}