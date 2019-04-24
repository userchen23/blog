<?php
namespace app\admin\controller;

use \think\Controller;
use app\admin\model\Goods as GoodsModel;
use app\admin\model\Banner;
use app\admin\model\Tag;
use \think\Validate;
/**
 * 
 */
class Goods extends Controller
{
    public function add(){
        $tagobj = new Tag;
        $data = $tagobj->getLists();
        $this->assign('tlists',$data);
        return $this->fetch('add');
    }
    public function save(){
        if (request()->isPost()) {
            $data=input('post.');
            if ($data) {
                $time = time();
                //$content = htmlspecialchars($data['content'], ENT_QUOTES);
                $end=[
                    'name'=>$data['name'],
                    'pro'=>$data['pro'],
                    'price'=>$data['price'],
                    'tag'=>$data['tag'],
                    'content'=>$data['content'],
                    'create_time'=>$time,
                    'update_time'=>$time,
                ];
                if ($img=\tool\FileHandle::upload()) {
                    $end['img']=$img['saveName'];
                }

                $goodobj = new GoodsModel;
                $result = $goodobj->add($end);

                if ($result) {
                    $this->success('添加成功');
                    die();
                }else{
                    $this->error('添加失败');
                    die();
                }

            }else{
                $this->error('未获取到数据');
            }
        }


    }

    
}