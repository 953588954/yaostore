<?php
namespace app\api\model;

use think\Model;
class Comment extends Model{
    //关联image表
    public function img(){
        return $this->hasMany('Image','comment_id','com_id');
    }
    //关联user表
    public function user(){
        return $this->belongsTo('User','user_id','use_id');
    }
    
    /**
     * 关联img图片 查询评论
     */
    public function getComments($proId,$page,$count=5){
        $rst = self::with(['img','user'])->where('product_id',$proId)->order('com_time desc')->limit(($page-1)*$count,$count)->select();
        //循环改变评论时间戳为 2014-02-05 00:00:00
        //改变  语音路径
        foreach ($rst as &$val){
            $val['com_time'] = date("Y-m-d H:i:s",$val['com_time']);
            if(!empty($val['yuyin_url'])){
                $val['yuyin_url'] = config('queue.basic_url')."voicefiles/".str_replace('\\', '/', $val['yuyin_url']);
                
                //$val = str_replace('\\', '/', $value);
                //return config('queue.basic_url').'uploads/'.$val;
            }
        }
        //获取总评论数量
        $totalCounts = self::where('product_id',$proId)->count();
        return [
            'comments' => $rst,
            'totalCounts' => $totalCounts
        ];
    }
    
    
    
    /*
     * 上传评论图片
     */
    public function upload($com_id){
        $file = request()->file('image');
        
        if($file){
            $info = $file->validate(['size'=>3*1024*1024,'ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
            if($info){
                $url = $info->getSaveName();
                $imgModal = new Image();
                $imgModal->data([
                    'ima_url' => $url,
                    'comment_id' => $com_id
                ]);
                $imgModal->save();
                return ['error'=>0,'msg'=>'上传成功'];
            }else{
                return ['error'=>1,'msg'=>'上传失败：'.$file->getError()];
            }
        }else{
            return ['error'=>1,'msg'=>'上传失败'];
        }
    }
}