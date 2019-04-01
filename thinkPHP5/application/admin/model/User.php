<?php
namespace app\admin\model;

use app\admin\model\Base;
use think\Db;
/**
 * 
 */
class User extends Base
{
  public $table ='user';

  public function getUser(){
    $result=Db::table('user')->select();
    $umsg = [];
    $umsg=get_key_value($result,'id');
    
    return $umsg;
  }



  public function findByPhone($phone){//
      
    $info=Db::table('user')->where('phone',$phone)->find();
    return $info;
      
  }

  public function register($data){
    $result = Db::table('user')->insert($data);
    return $result;
  }
}
    
