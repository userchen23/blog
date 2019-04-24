<?php
namespace app\index\controller;
use app\index\model\User as Usermodel;
use think\Controller;
use think\Db;
use app\index\model\Redis as Redismodel;
use app\index\model\Token as UserToken;
/**
 * 
 */
class User extends Controller
{
    
    public function loginCheck(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (request()->isPost()) {
            $token = input('post.token');
            if (empty($token)) {
                $error = 2;
                $msg = 'tonken为空';
            }else{
                $tokenobj = new UserToken;
                $result = $tokenobj->tokenChecked($token);
                if ($result===0) {
                    $error = 3;
                    $msg = 'token不存在或过期';
                }
            }   
        }else{
            $error=1;
            $msg = '未接受到POST请求';
        }

        $result = response($error,$msg,$data);
        return json_encode($result);
    }

    public function getUserMsg($token){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (request()->isPost()) {
            $token = input('post.token');
            if (empty($token)) {
                $error = 1;
                $msg = 'tonken为空';
            }else{
                $tokenobj = new UserToken;
                $result = $tokenobj->tokenChecked($token,1);
                if ($result===0) {
                    $error = 2;
                    $msg = 'token不存在或过期';
                }else{
                    $data = $result;
                }
            }
        }else{
            $error=1;
            $msg = '未接受到POST请求';
        }


        $result = response($error,$msg,$data);

        return json_encode($result);
    }

    public function login(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if(request()->isPost()){
            $data = input('post.');
            $obj = new Usermodel;
            $info = $obj->findByPhone($data['phone']);

            if(empty($info)) {
                $error = 2;
                $msg = "用户不存在";
            }else{
                //密码匹配
                if ($info['password'] == $data['password']) {
                    $data = [
                        "name"=>$info['username'],
                        "id"=>$info['id'],
                    ];
                    //todo//存token
                    //1:调用getToken函数,token接
                    $tokenobj= new UserToken;
                    $token =$tokenobj-> getToken($data);
                    if ($token === 0) {
                        $error=4;
                        $msg = "token存入失败";
                    }
                    //2:token存入data
                    $data = [];
                    $data['token'] = $token;
                }else{
                    $error = 3;
                    $msg = "密码错误";
                }           
            }          
        }else{
                $error = 1;
                $msg = "未接受到POST请求";
        }

        $result=response($error,$msg,$data);
        return json_encode($result);
    }

    public function loginout(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (request()->isPost()) {
            $token = input('post.token');
            if (empty($token)) {
                $error = 2;
                $msg = 'tonken为空';
            }else{
                $tokenobj = new UserToken;
                $result = $tokenobj->tokenClear($token);
                if ($result===0) {
                    $error = 3;
                    $msg = '失败';
                }
            }  
        }else{
            $error=1;
            $msg = '未接受到POST请求';
        }


        $result = response($error,$msg,$data);
        return json_encode($result);
    }

    public function loginv2(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if(request()->isPost()){
            $data = input('post.');
            $obj = new Usermodel;
            $info = $obj->findByPhone($data['phone']);

            if(empty($info)) {
                $error = 2;
                $msg = "用户不存在";
            }else{
                //密码匹配
                if ($info['password'] == $data['password']) {
                    $data = [
                        "name"=>$info['username'],
                        "id"=>$info['id'],
                    ];
                    //todo//存token
                    //1:调用getToken函数,token接
                    $tokenobj= new Redismodel;
                    $token =$tokenobj-> getToken($data);
                    if ($token === 0) {
                        $error=4;
                        $msg = "token存入失败";
                    }
                    //2:token存入data
                    $data = [];
                    $data['token'] = $token;
                }else{
                    $error = 3;
                    $msg = "密码错误";
                }           
            }          
        }else{
                $error = 1;
                $msg = "未接受到POST请求";
        }

        $result=response($error,$msg,$data);
        return json_encode($result);
    }


    public function register(){

        return $this->fetch('User/register');
    }
    public function doReg(){
        if(request()->isPost()){
            $data = input('post.');

            $obj = new Usermodel;
            $info = $obj->findByPhone($data['phone']);
                        
            if ($info['phone'] == $data['phone']) {
 
                $this->error('该手机号已存在', 'User/register');
                die();
            }

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