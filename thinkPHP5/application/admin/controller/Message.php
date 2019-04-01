<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Message as MsgModel;
use app\admin\model\User as UserModel;
use app\admin\model\Classify as ClsfModel;
/**
 * 
 */
class Message extends Controller
{

    public function mlists(){

        $objForMsg = new MsgModel;
        $msgLists = $objForMsg->getLists();
        
        $objForUser = new UserModel;
        $umsg = $objForUser->getUser();
        
        
        foreach ($msgLists as $key => $value) {
            $msgLists[$key]['username']=$umsg[$value['userid']]['username'];
        }
        $data = $msgLists;
        
        $this->assign('mlist',$data);
        return $this->fetch('mlists');
    }

    public function add(){
        if (!session('name')) { //没登录
             
                $this->error('请登录', 'User/login');
                die();
            }
            $obj = new ClsfModel;
            $data = $obj->getLists();
            $result = $obj->arrChange($data,0,3);
            
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
            
            
            $userid = session('id');
            
            $end=[
                'userid'=>$userid,
                'cid'=>$data['cid'],
                'content'=>$data['content'],];
            

            $obj = new MsgModel;
            $result = $obj->add($end);

            if ($result) {
                $this->success('添加成功', 'Message/mlists');
                die();
            }else{
                $this->error('添加失败', 'Message/mlists');
                die();
            }

        }

    }

    public function update(){
        if (!session('name')) { //没登录
            $this->error('请登录', 'User/login');
            die();
        }
        
        
        if (request()->isGet()) {
            $data=input('get.');

            if (session('id')!=$data['userid']) {
                $this->error('亲，不能修改别人的信息哦', 'Message/mlists');
                die();
            }
            
            $objForClassify = new ClsfModel;
            $clists = $objForClassify->getLists();
            $result = $objForClassify->arrChange($clists,0,3);
            $this->assign('clists',$result);

            
            $objForMsg = new MsgModel;
            $msg=$objForMsg->getInfo($data['id']);
            $this->assign('msg',$msg['content']);

            return $this->fetch('update');
        }
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
                
                'cid'=>$data['cid'],
                'content'=>$data['content'],];
            

            $obj = new MsgModel;
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
            

            $obj = new MsgModel;
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