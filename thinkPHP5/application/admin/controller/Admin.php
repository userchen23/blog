<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\User as UserModel;
use app\admin\model\Jurisdiction as JrdModel;
/**
 * 
 */
class Admin extends Controller
{
    public function ulists(){
        if (session('status') < 2) {
            $this->error('权限不足','Index/index');           
        }       
        $objForUser = new UserModel;
        $umsg = $objForUser->getLists();
        $data = $objForUser->formalUser($umsg);
        
        $this->assign('ulist',$data);
        return $this->fetch('ulists');
    }

    public function add(){
        $user_status= session('status');
        if ($user_status < 2) {
            $this->error('权限不足','Index/index');die();           
        }

        $Jrdobj     = new JrdModel;
        $Jrd_lists  = $Jrdobj->selectInfo('status',$user_status);

        $this->assign('Jrd_lists',$Jrd_lists);
        return $this->fetch('add');
    }


    public function save(){
        if (!session('status')) { //没登录
             
                $this->error('请登录', 'User/login');
                die();
            }

        if (!request()->isPost()) {
                $this->error('未接受到信息', 'Index/index');
                die();
        }

        $data=input('post.');

        $code=$data['captcha'];
        if(!captcha_check($data['captcha'])){
                $this->error('验证码错误','Admin/add');die();
        };
        $user_data  = [
            'username'  => $data['user_name'],
            'password'  => $data['password'],
            'phone'     => $data['phone'],
            'status'    => $data['status'],
        ];
        $objForUser = new UserModel;
        $info = $objForUser->findByPhone($data['phone']);
                    
        if ($info['phone'] == $data['phone']) {

            $this->error('该手机号已存在', 'admin/add');
            die();
        }

        $result     = $objForUser->add($user_data);

        if ($result) {
            $this->success('添加成功', 'Admin/ulists');
            die();
        }else{
            $this->error('添加失败', 'Admin/add');
            die();
        }
    }
    
    public function changeStatus(){
        $aim_msg = input('get.');
        if (empty($aim_msg['aim_id'])||empty($aim_msg['aim_status'])||empty($aim_msg['change'])) {
            $this->error('参数有误', 'Admin/ulists');
        }
        $aim_status     = $aim_msg['aim_status'];
        $aim_id         = $aim_msg['aim_id'];
        if (!session('status')||session('status')<= $aim_status) {
            $this->error('权限不足', 'Admin/ulists');die();
        }
        $aim_status=intval($aim_status) + 1;
        $result    = false;
        $objForUser = new UserModel;
        if ($aim_msg['change']> 0) {
            if (session('status')<= $aim_status) {
                $this->error('权限不足', 'Admin/ulists');die();
            }
            $result     = $objForUser->doInc('id',$aim_id,'status',1);
        }
        if ($aim_msg['change'] < 0) {
            $result     = $objForUser->doDec('id',$aim_id,'status',1);
        }

        if ($result) {
            $this->success('修改成功', 'Admin/ulists');
            die();
        }else{
            $this->error('修改失败', 'Admin/ulists');
            die();
        }
    }

    public function delete(){
        $aim_msg = input('get.');
        if (empty($aim_msg['aim_id'])||empty($aim_msg['aim_status'])) {
            $this->error('参数有误', 'Admin/ulists');
        }
        $aim_status     = $aim_msg['aim_status'];
        $aim_id         = $aim_msg['aim_id'];

        if (!session('status')||session('status')<= $aim_status) {
            $this->error('权限不足', 'Admin/ulists');die();
        }
        $obj = new UserModel;
        $result = $obj->dodelete($aim_id);

        if ($result) {
            $this->success('删除成功', 'Admin/ulists');
            die();
        }else{
            $this->error('删除失败', 'Admin/ulists');
            die();
        }

    }
}