<?php
namespace app\admin\model;

use think\Db;
use think\Model;
use think\Collection;
use app\admin\model\Redis;
use think\File;
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
        $info = $info->toArray();
        return $info;
    }

    public function getLists(){


        $lists = $this->select();
        if (!$lists) {
            return [];
        }
        $result =lists_to_array($lists);
        return $result;

        // $table_Lists="crj_".$this->table."_Lists";
        // $redis_obj= new Redis;
        // $value=$redis_obj->getRedis($table_Lists);
        // if (empty($value)) {
        //     $lists = $this->select();
        //     $result =lists_to_array($lists);
        //     $redis_obj->setRedis($table_Lists,$result);
        // }else{
        //     $result=$value;
        // }
        
        // return $result;
    }
    public function selectInfo($field,$value,$offset=0,$limit=10){
        $info =$this->where($field,'<',$value)->limit($offset,$limit)->select();
        if ($info) {
            $info = lists_to_array($info);
        }
        return $info;
    }
    public function changeLists(){
        $result=self::getLists();
        $umsg=get_key_value($result,'id');
        return $umsg;
      }
    
    public function doupdate($id,$data){
        $result = $this->where('id', $id)->update($data);
        return $result;
    }

    public function dodelete($id){
        $result = $this->where('id',$id)->delete();
        //$result = $this->where('id',1)->setField('status', 0);
        return $result;
    }

    public function doInc($where,$value,$field,$num){

        $result = $this->where($where, $value)->setInc($field,$num);
        return $result;
    }
    public function doDec($where,$value,$field,$num){

        $result = $this->where($where, $value)->setDec($field,$num);
        return $result;
    }


}