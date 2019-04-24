<?php
namespace app\index\controller;

use \think\Controller;
use app\index\model\Goods as GoodsModel;
use app\index\model\Banner;
/**
 * 
 */
class Goods extends Controller
{

    public function index(){
        $error = 0;
        $msg = '成功';
        $data = [];

        $goodsobj = new GoodsModel;
        $goodslists=$goodsobj->getLists();
        $endgoods =$goodsobj->changelist($goodslists);
        $endgoods = $goodsobj->formatGoods($endgoods);
        $data['goods']=$endgoods;

        $bannerobj = new Banner;
        $bannerlist = $bannerobj->getLists();
        $endbanner = $bannerobj->formatBanner($bannerlist);
        $data['banner']=$endbanner;


        $result=response($error,$msg,$data);     
        return json_encode($result);
    }

    public function detail($id=1){
        $data = [];
        $error = 0;
        $msg = '成功';
        if (empty($id)) {
            $error = 1;
            $msg = "未传递参数ID";
            
        }else{
            $goodobj = new GoodsModel;
            $goodinfo =$goodobj->getinfo($id);
            $goodinfo =$goodobj->changeinfo($goodinfo);
            if (empty($goodinfo)) {
                $error = 2;
                $msg = "未查找到相关物品";
            }else{
                $endgoods = $goodobj->formatGood($goodinfo,"detail");
                $data['info']=$endgoods;
            }
            
        }
        
        $result=response($error,$msg,$data);

        echo json_encode($result);die();
    }
}