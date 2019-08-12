<?php
namespace app\admin\controller;
use app\admin\model\User as usermodel;
use think\Controller;
use think\Db;
/**
 * 
 */
class User extends Controller
{
    
    public function login(){
        return $this->fetch('login');
    }
    public function dologin(){


        // if (empty($phone) || empty($password)) {
        //     die('fail');
        // }

        //判断是否是表单提交
        if(request()->isPost()){
            $data = input('post.');
            if(!captcha_check($data['captcha'])){
                $this->error('验证码错误','User/login');die();
            };

            $obj = new usermodel;
            $info = $obj->findByPhone($data['phone']);

            if(empty($info)) {
                $this->error('用户不存在', 'User/login');

                die();
            }
            if ($info['password'] == $data['password']) {
                if ($info['status'] < 1||$info['status'] > 3) {
                    $info['status'] = 1;
                }
                \think\Session::set('name',$info['username']);
                \think\Session::set('id',$info['id']);
                \think\Session::set('status',$info['status']);
                $this->success('登录成功', 'Index/index');
                die();
            } else {
                $this->error('密码错误', 'User/login');
                die();
            }          
        }
        
    }

    public function loginout(){
        session(null);
        return $this->fetch('Index/index');
    }

    public function register(){

        return $this->fetch('User/register');
    }
    public function doReg(){
        if(request()->isPost()){
            $data = input('post.');
            if(!captcha_check($data['captcha'])){
                $this->error('验证码错误','User/login');die();
            };
            $obj = new usermodel;
            $info = $obj->findByPhone($data['phone']);
                        
            if ($info['phone'] == $data['phone']) {
 
                $this->error('该手机号已存在', 'User/register');
                die();
            }
            $data['status'] = 1 ;

            $result=$obj->register($data);

            if($result) {
                $this->success('注册成功', 'User/login');

                die();
            } else{
                $this->error('注册失败', 'User/register');
                die();
            }
        }
    }
}