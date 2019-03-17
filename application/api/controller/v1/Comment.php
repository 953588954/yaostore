<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\lib\exception\ParamertersException;
use app\api\model\Comment as CommentModal;
use app\api\model\OrderProduct;
use app\api\service\UserToken;
use app\api\validate\ProductId;
class Comment extends BaseController{
    
    /*
     *  小程序图片上传
     * POST
     * @param string description 评论文字
     * @param int product_id    商品id
     * @param int ord_id 订单id
     * @return int com_id 评论id
     */
    public function wordAndImgComment(){
        $description = input("post.description");
        $pro_id = input("post.product_id");
        $ord_id = input('post.ord_id');
        if (!is_numeric($pro_id) || ($pro_id+0)<0 || !is_int($pro_id+0)){
            throw new ParamertersException(['msg'=>'商品id参数错误']);
        }
        if (!is_numeric($ord_id) || ($ord_id+0)<0 || !is_int($ord_id+0)){
            throw new ParamertersException(['msg'=>'订单id参数错误']);
        }
        if (!$description){
            throw new ParamertersException(['msg'=>'商品评论不能为空']);
        }
        $comModal = new CommentModal();
        $comModal->com_time = time();
        $comModal->com_description = $description;
        $comModal->product_id = $pro_id;
        $comModal->user_id = UserToken::getTokenValue();
        $comModal->save();
        $comment_id = $comModal->com_id;
        //改变商品订单表  的评论状态
        $ordProModal = new OrderProduct();
        $ordProModal->where('order_id',$ord_id)->where('product_id',$pro_id)->update(['is_comment'=>1]);
        
        return json(['com_id'=>$comment_id]);
    }
    /*
     * 根据评论id上传图片
     * POST
     * @param string image 上传的图片name
     * @param int com_id 评论的id
     */
    public function uploadImg(){
        $com_id = input('post.com_id');
        if (!is_numeric($com_id) || ($com_id+0)<0 || !is_int($com_id+0)){
            throw new ParamertersException(['msg'=>'评论id参数错误']);
        }
        $comModal = new CommentModal();
        $rst = $comModal->upload($com_id);
        return json($rst);
    }
    
    /*
     * 语音文件上传
     * POST
     * @param file voiceTemp    语音文件
     * @param int second    语音时长
     * @param int product_id 商品id
     * @param int ord_id 订单id
     */
    public function yuyinComment(){
        $second = input('post.second');
        $pro_id = input('post.product_id');
        $ord_id = input('post.ord_id');
        if (!is_numeric($second) || $second>100){
            throw new ParamertersException(['msg'=>'语音时长参数错误']);
        }
        if (!is_numeric($pro_id) || ($pro_id+0)<0 || !is_int($pro_id+0)){
            throw new ParamertersException(['msg'=>'商品id参数错误']);
        }
        if (!is_numeric($ord_id) || ($ord_id+0)<0 || !is_int($ord_id+0)){
            throw new ParamertersException(['msg'=>'订单id参数错误']);
        }
        $second = ceil($second);
        $file = request()->file('voiceTemp');
        if ($file){
            $info = $file->move(ROOT_PATH.'public'.DS.'voicefiles');
            if ($info){
                $voiceUrl = $info->getSaveName();
                $comModal = new CommentModal();
                $comModal->data([
                    'com_time' => time(),
                    'product_id' => $pro_id,
                    'user_id' => UserToken::getTokenValue(),
                    'yuyin_url' => $voiceUrl,
                    'yuyin_second' => $second
                ]);
                $comModal->save();
                //语音上传完之后，修改订单 商品表  为已评论
                $ordProModal = new OrderProduct();
                $ordProModal->where('order_id',$ord_id)->where('product_id',$pro_id)->update(['is_comment'=>1]);
                return json([
                    'error' => 0,
                    'msg' => '上传语音文件成功'
                ]);
            }else {
                return json([
                    'error' => 1,
                    'msg' => '上传语音文件失败：'.$file->getError()
                ]);
            }
        }else {
            return json([
                'error' => 1,
                'msg' => '上传语音文件不存在'
            ]);
        }
    }
    
    /**
     * 根据商品id 获取评论
     * GET
     * @param int id 商品id
     * @param int page
     */
    public function getCommentsById(){
        (new ProductId())->goCheck();
        $proId = input('get.id');
        $page = input('get.page');
        if (!is_numeric($page) || ($page+0)<0 || !is_int($page+0)){
            throw new ParamertersException(['msg'=>'page参数须是正整数']);
        }
        
        $commentModal = new CommentModal();
        $rst = $commentModal->getComments($proId, $page);
        return json($rst);
    }
    
    
    
    
    
    
}