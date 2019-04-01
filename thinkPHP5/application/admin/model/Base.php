<?php
namespace app\admin\model;

use think\Db;
use think\Model;


/**
 * 
 */
class Base extends Model
{
    public $table  ='message';

    public function add($data){
        return $result = Db::table($this->table)->insert($data);
    }

    public function getInfo($id){
        $info = Db::table($this->table)->where('id',$id)->find();
        return $info;
    }

    public function getLists(){
        return Db::table($this->table)->select();
    }
    
    public function doupdate($id,$data){
        return $result = Db::table($this->table)->where('id', $id)->update($data);
    }

    public function dodelete($id){
        return $result = Db::table($this->table)->where('id',$id)->delete();
    }
}