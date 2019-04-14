<?php
namespace app\admin\model;

use think\Model;
use think\Cache;
/**
 * 
 */
class Redis extends Model
{
    public function setRedis($key,$value){
        if (Cache::get($key)) {
            Cache::clear($key,NULL);
        }
        $value=serialize($value);
        $result=Cache::set($key,$value,20); 
        return $result;
    }

    public function getRedis($key){
        $value=Cache::get($key);
        if ($value) {
            $result=unserialize($value);
        }else{
            $result=null;
        }
        
        return $result;
    }
}