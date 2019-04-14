<?php
namespace app\index\controller;

use \app\common\controller\Base;
use \think\Db;
use \app\index\model\User as UserModel;
// use \think\Cache;
use \cache\Cache;
use cache\Cachev1 as MyCachev1;



class Test extends Base
{
    public function maying() {
       // MyCachev1::app()->cacheFet('name');
        $userModel = new UserModel();
        $info = $userModel->getInfoByIdv4(1);
        var_dump($info);
        MyCachev1::app()->cacheSet('name','cachev1');

        // $a = MyCachev1::app()->cacheGet('name');
        // var_dump($a);

        // $c = new Cache();
        // $c->cacheSet(1,2);
        // $redis = Cache::store()->handler();

        // $redis = new \Redis();
        // $redis->connect('127.0.0.1', '6379');

        // $redis->sadd('myset', 'a');
        // $redis->sadd('myset', 'b');
        // $redis->sadd('myset', 'c');
        // $info = $redis->sismember('myset', 'd');
        // var_dump($info);

        // $redis = new \Redis();
        // $redis->connect('192.168.199.249', '6379');
       
        // $redis->set('name','maying');

        // $name =  $redis->get('name');
        // var_dump($name);
       
    }

    public function forTest(){
        
    }
}

// sql注入
// sql预处理 mysqli pdo    
