<?php
namespace app\index\controller;

use \think\Controller;
use app\index\model\Goods as GoodsModel;
use app\index\model\Banner;
use app\index\model\Token as TokenModel;
use app\index\model\Attr  as AttrModel;
use app\index\model\Cart  as CartModel;
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
        return json_encode($result);die();
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
            //设置attr
            $attrobj = new AttrModel;
            $attrlists = $attrobj->selectInfo('goodsid',$id);
            if ($attrlists) {
                $endattr = $attrobj->formatAttr($attrlists);
            }else{
                $endattr = [];
            }
            $goodinfo['attr'] = $endattr;

            if (empty($goodinfo)) {
                $error = 2;
                $msg = "未查找到相关物品";
            }else{
                $endgoods = $goodobj->formatGood($goodinfo,"detail");
                $data['info']=$endgoods;
            }
            
        }
        
        $result=response($error,$msg,$data);

        return json_encode($result);die();
    }


    public function cart(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (!request()->isPost()) {
            $error=1;
            $msg = '未接受到POST请求';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        $postdata = input('post.');
        if (empty($postdata)) {
            $error = 2;
            $msg = 'data为空';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        if (empty($postdata['goods_id'])||empty($postdata['token'])||empty($postdata['count'])) {
            $error = 3;
            $msg = "缺少必要参数";
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }

        //获取userid
        $token = $postdata['token'];
        $tokenobj = new TokenModel;
        $result = $tokenobj->tokenChecked($token);
        if (!$result) {
            $error = 4;
            $msg = 'token不存在或过期';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        $userid = $result['id'];

        //获取goodsid
        $goodsid = $postdata['goods_id'];
        $goodobj = new GoodsModel;
        $info = $goodobj->getInfo('id',$goodsid);
        if (!$info) {
            $error = 5;
            $msg = "未找到商品";
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        //获取price
        $price = $info['price']/100;
        //获取count
        $count = $postdata['count'];
        //获取color,size,attrid
        $color = !empty($postdata['color'])?$postdata['color']:'';
        $size  = !empty($postdata['size'])?$postdata['size']:'';
        $attrid= !empty($postdata['attrid'])?$postdata['attrid']:'';
        //判断是否重复
        $cartobj = new CartModel;
        $cartlists = $cartobj->selectInfo('goodsid',$goodsid);
        if($cartlists){
            foreach ($cartlists as $key => $value) {
                if ($value['attrid']==$attrid) {
                    $count = $value['count'] +$count;
                    $result = $cartobj->updateField('id',$value['id'],'count',$count);
                }
                if (!$count) {
                    $error = 7;
                    $msg ='增加失败';
                    $result = response($error,$msg,$data);
                    return json_encode($result); die(); 
                }
            }
        }
        $endcart=[
            'goodsid'=> $goodsid,
            'userid' => $userid,
            'price'  => $price,
            'count'  => $count,
            'color'  => $color,
            'size'   => $size,
            'attrid' => $attrid,
        ];
        $cartobj = new CartModel;
        $result = $cartobj->add($endcart);
        if (!$result) {
            $error = 6;
            $msg ='添加失败';
            $result = response($error,$msg,$data);
            return json_encode($result);
        }
        $result = response($error,$msg,$data);
        return json_encode($result);  
    }

    public function cartInfo(){
        $error = 0;
        $msg = '成功';
        $data = [];
        if (!request()->isPost()) {
            $error=1;
            $msg = '未接受到POST请求';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        $token =input('post.token');
        if (empty($token)) {
            $error = 2;
            $msg = 'token为空';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        //判断token
        $tokenobj = new TokenModel;
        $result = $tokenobj->tokenChecked($token);
        if (!$result) {
            $error = 4;
            $msg = 'token不存在或过期';
            $result = response($error,$msg,$data);
            return json_encode($result); 
        }
        $userid = $result['id'];
//获取列表，返回数据
        $cartobj = new CartModel;
        $usercart = $cartobj->selectInfo('userid',$userid);
        $cart = [];
        $goodobj = new GoodsModel;
        $attrobj = new AttrModel;

        foreach ($usercart as $key => $value) {
            $goodsinfo = $goodobj-> getInfo('id',$value['goodsid']);
            $goodsname = $goodsinfo['name'];
            $attrinfo  = $attrobj-> getInfo('id',$value['attrid']);
            $cart[]=[
                'name' => $goodsname,
                'color'=> $attrinfo['attr_name'],
                'price'=> $goodsinfo['price']/100,
                'count'=> $value['count'],
            ];
        }
        $data['cart'] =$cart;

        $result = response($error,$msg,$data);
        return json_encode($result); 
    }
}