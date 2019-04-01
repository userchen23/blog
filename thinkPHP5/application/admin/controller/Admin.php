<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\Message as msg;
use think\Cache;
/**
 * 
 */
class Admin extends Controller
{
   public function crj(){
    // $redis = new \Redis();
    // $redis->connect("192.168.199.249","6379");

    // $redis->set("crj_name","crj");
    // $result = $redis->get("crj_name");
    // $obj = new msg();
    // $result=$obj->getLists();
    $result=Cache::clear();
    //$result=Cache::set('name1','value1',10);

    var_dump($result);die();
   }
}