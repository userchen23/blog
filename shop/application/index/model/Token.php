<?php
namespace app\index\model;

use app\index\model\Base;
use app\index\model\User as UserModel;
/**
 * 
 */
class Token extends Base
{
    public $table = "token";

    public function getToken($data){
        $value = serialize($data);
        $token =self::setToken($data);
        $time = time()+86400*30;

        $end = [
            'token'=>$token,
            'value'=>$value,
            'time'=>$time,
        ];
        $result = $this->insert($end);
        if ($result) {
            return $token;
        }else{
            return 0;
        }
    }

    public function setToken($data=[]){
        $time =  md5(time().rand(1,100000));
        $user = md5(serialize($data));
        return 'user_token_'.md5($time. $user);
    }

    public function tokenChecked($token,$param = null){

        $info = self::getinfo('token',$token);

        if($info){
            if ($param) {
                $result = unserialize($info['value']);
                $userobj=new UserModel;
                $result = $userobj->getinfo('id',$result['id']);
            }else{
                $now_time =time();
                if ($now_time < $info['time']) {
                    $result = 1;
                }else{
                    $result =0;
                }
            }
        }else{
            $result = 0;
        }
        return $result;
    }
    public function tokenClear($token){
        $result = self::doDelete('token',$token);
        return $result;
    }
}