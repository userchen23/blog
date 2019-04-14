<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\Base;
class Index extends Controller
{
    
    public function index()
    {
        // $arr = [
        //     ['a'=>1,'b'=>2,],
        //     ['a'=>1,'b'=>2,],

        // ];

        // $Baseobj=new Base;
        // $result = $Baseobj->setRedis("crj",$arr);
        // if ($result) {
        //     $result=$Baseobj->getRedis("crj");
        //     var_dump($result);

        // }else{
        //     echo "no";die();
        // }
        // die();
        return $this->fetch('index');
    

    

    }
}