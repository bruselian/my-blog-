<?php

namespace app\admin\controller;
use think\Db;
use think\Request;

class Blog
{
    public function index(){

    }

    /**
     * 添加博客数据
     * @param Request $request
     * @return array
     */
    public function addBlog(Request $request){
        if ($request->isPost()){
            $data = $request->param();
            if (is_array($data['categories'])){
                $data['categories'] = implode(',', $data['categories']);
            }
            $data['time'] = time();
            if (model('blog')->allowField(true)->save($data)){
                $result = ['status' => 1, 'msg' => '添加成功'];
            }else{
                $result = ['status' => 0, 'msg' => '添加失败'];
            }

            return json($result);
        }

    }

    /**
     * 获取所有内容
     * @return \think\response\Json
     */
    public function showBlogs(){
        $blogs = Db::name('blog')->select();

        return json($blogs);
    }

    /**
     * 获取博客
     * @param Request $request
     * @return \think\response\Json
     */
    public function getBlog(Request $request){
        $id = $request->get('id');
        $blog = Db::name('blog')->where(['id' => $id])->find();

        return json($blog);
    }

    /**
     * 删除博客
     * @param Request $request
     * @return \think\response\Json
     */
    public function delete(Request $request){
        $id = $request->get('id');
        if (Db::name('blog')->where(['id' => $id])->delete()){
            $res = ['status' => 1, 'msg' => '删除成功'];
        }else{
            $res = ['status' => 0, 'msg' => '删除失败'];
        }

        return json($res);
    }

    /**
     * 编辑博客
     * @param Request $request
     * @return bool|\think\response\Json
     */
    public function editBlog(Request $request){
        if ($request->isPut()){
            $data = $request->param();
            if (is_array($data['categories'])){
                $data['categories'] = implode(',', $data['categories']);
            }
            $data['time'] = time();
            if (model('blog')->allowField(true)->save($data,['id' => $data['id']])){
                $result = ['status' => 1, 'msg' => '更新成功'];
            }else{
                $result = ['status' => 0, 'msg' => '更新失败'];
            }

            return json($result);
        }

        return false;
    }

}
