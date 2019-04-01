<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Classify as ClsfModel ;

/**
 * 
 */
class Classify extends Controller
{

    public function clists(){

        $objForClassify = new ClsfModel;
        $data = $objForClassify->getLists();

        $next = [];
        $next=get_key_value($data,'id');
        
        $this->assign('clists',$data);
        return $this->fetch('clists');
    }

    public function add(){
        if (!session('name')) { //没登录
            $this->error('请登录', 'User/login');
            die();
        }

        $objForClassify = new ClsfModel;
        $clists = $objForClassify->getLists();
        $result = $objForClassify->arrChange($clists,0,3);
        $this->assign('clists',$result);
        return $this->fetch('add');
    }
    
    public function save(){
        if (!session('name')) { //没登录 
            $this->error('请登录', 'User/login');
            die();
        }



        if (request()->isPost()) {
            $data=input('post.');
            

            $obj = new ClsfModel;
            $result = $obj->add($data);

            if ($result) {
                $this->success('添加成功', 'Classify/clists');
                die();
            }else{
                $this->error('添加失败', 'Classify/clists');
                die();
            }

        }


    }

    public function update(){

        return $this->fetch('update');
    }

    public function doUpdate(){

        if (!session('name')) { //没登录
             
                $this->error('请登录', 'User/login');
                die();
            }
        
        
        if (request()->isPost()) {
            $data=input('post.');
            if (session('id')!=$data['userid']) {
                $this->error('亲，不能修改别人的信息哦', 'Message/mlists');
                die();
            }
            
        
            $msgid = $data['msgid'];
            $data=[
                
                
                'content'=>$data['content'],];
            

            $obj = new ClsfModel;
            $result = $obj->doupdate($msgid,$data);

            if ($result) {
                $this->success('更改成功', 'Message/mlists');
                die();
            }else{
                $this->error('更改失败', 'Message/mlists');
                die();
            }

        }
    }

    public function delete(){
        if (!session('name')) { //没登录
             
                $this->error('请登录', 'User/login');
                die();
            }
        
        
        if (request()->isGET()) {
            $data=input('get.');
            // if (session('id')!=$data['userid']) {
            //     $this->error('亲，不能修改别人的信息哦', 'Message/mlists');
            //     die();
            // }
            
            $msgid = $data['msgid'];
            

            $obj = new ClsfModel;
            $result = $obj->dodelete($msgid);

            if ($result) {
                $this->success('删除成功', 'Message/mlists');
                die();
            }else{
                $this->error('删除失败', 'Message/mlists');
                die();
            }

        }
    }
}