<?php
namespace app\admin\model;

use app\admin\model\Base;
use think\Db;

/**
 * 
 */
class Classify extends Base
{
    public $table='classify';
 

    public function arrChange($DATA,$PID=0,$END_DEEP=2,$NOW_DEEP=1){
        $TREE = [];

        foreach ($DATA as $key => $value) {
            if ($value['pid']==$PID) {
                if ($END_DEEP>$NOW_DEEP) {
                        $TMP_DEEP=$NOW_DEEP+1;
                        
                        $value['child']=$this->arrChange($DATA,$value['id'],$END_DEEP,$TMP_DEEP);
                }
                $TREE[]=$value;
            }
        }
        
        return $TREE;
    }
    

}