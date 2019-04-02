<?php
namespace app\admin\model;

use think\Db;
use think\Model;



/**
 * 
 */
class Base extends Model
{
    

    public function add($data){
        $result = $this->insert($data);

        return $result;
    }

    public function getInfo($id){
        $info = $this->where('id',$id)->find();
        return $info;
    }

    public function getLists(){
        $lists = $this->select();
        return $lists;
    }

    public function changeLists(){
        $result= $this->select();
        
        $umsg=get_key_value($result,'id');
        return $umsg;
      }
    
    public function doupdate($id,$data){

        $result = $this->where('id', $id)->update($data);
        return $result;
    }

    public function dodelete($id){
        $result = $this->where('id',$id)->delete();
        return $result;
    }
}