<?php
namespace app\index\controller;

use \think\Controller;
use app\index\model\Goods as GoodsModel;
use app\index\model\Banner;
use app\index\model\Token as TokenModel;
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

    public function detail($id){
        $data = [];
        $error = 0;
        $msg = '成功';
        if (empty($id)) {
            $error = 1;
            $msg = "未传递参数ID";
            
        }else{
            $goodobj = new GoodsModel;
            $goodinfo =$goodobj->getinfo('id',$id);
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

        return json_encode($result);
    }
    public function addCart(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (request()->isPost()) {
            $data = input('post.');
            if (empty($data)) {
                $error = 2;
                $msg = 'data为空';
            }else{
                if (empty($data['id'])||empty($data['token'])||empty($data['count'])) {
                    $error = 3;
                    $msg = "缺少必要参数";
                }else{
                    $token = $data['token'];
                    $tokenobj = new TokenModel;
                    $result = $tokenobj->tokenChecked($token);
                    if ($result===0) {
                        $error = 4;
                        $msg = 'token不存在或过期';
                    }else{
                        $goodsid = $data['id'];
                        $goodobj = new GoodsModel;
                        $info = $goodobj->getInfo('id',$goodsid);
                        if ($info) {
                            $price = $info['price']/100;
                            
                        }else{
                            $error = 5;
                            $msg = "未找到商品";
                        }

                    }


                }
            }   
        }else{
            $error=1;
            $msg = '未接受到POST请求';
        }

        $result = response($error,$msg,$data);
        return json_encode($result);  
    }
}