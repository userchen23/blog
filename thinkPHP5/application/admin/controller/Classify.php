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


}