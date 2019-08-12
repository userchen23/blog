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
  public function formalUser($data){
    $result = [];
    $tmp    = '';
    foreach ($data as $key => $value) {
        switch ($value['status']) {
            case 1:
                $tmp = '普通员工';
                break;
            case 2:
                $tmp = '管理员';
                break;
            case 3:
                $tmp = 'BOSS';
                break;
            default:
                $tmp = '已不存在';
                break;
        }
        $result[] = [
            'user_id' => $value['id'],
            'user_name'     => $value['username'],
            'phone'         => $value['phone'],
            'status'        => $value['status'],
            'identity'      => $tmp,
        ];

    }
    return $result;
  }

  public function findByPhone($phone){//
      
    $info=$this->where('phone',$phone)->find();
    return $info;
      
  }

  public function register($data){
    $result = $this->insert($data);
    return $result;
  }
}
    
