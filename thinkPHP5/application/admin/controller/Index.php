<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    
    public function index()
    {
        $arr = [
            ['a'=>1,'b'=>2,],
            ['a'=>1,'b'=>2,],

        ];
        
    return $this->fetch('index');
    

    

    }
}