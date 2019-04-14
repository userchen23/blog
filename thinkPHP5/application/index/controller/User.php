<?php
namespace app\index\controller;

use \app\common\controller\Base;
use \think\Db;
use \app\index\model\User as UserModel;


class User extends Base
{
    public function maying() {
        // $res = Db::execute('insert into user (name,phone) values (?, ?)',['maying','15662176002']);
        // $res = Db::execute("insert into user (name,phone) values ('xiaoming', '15662176003')");
        // var_dump($res);
        // 
        // $res = Db::query('select * from user');
        // 
        // 
        // $res = Db::table('user')->where('id',1)->select();
        // dump($res);



        // Db::table('think_user')->where('id', 1)->update(['name' => 'thinkphp']);
        // 

        //$user = new \app\index\model\User();
        $user = new UserModel();
        
        // $list = $user->getInfoById(3);
        // 查询单个数据
        $list = $user->where('id', '3')->select();
        $list = $user->where(['id'=>3])->select();
        dump($list);

        // dump($list->id);
        // dump($list['id']);
        // $user->data([
        //     'name'  =>  'thinkphp',
        //     'phone' =>  '15662176002'
        // ]);
        // $user->save();
        // 
        // $res = $user->where(['id'=>3])->update(['name' => 'thinkphp']);
        // dump($res);

    }
}

// sql注入
// sql预处理 mysqli pdo    
