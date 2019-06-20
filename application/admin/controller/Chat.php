<?php
/**
 * 客服消息
 */
namespace app\admin\controller;

use think\Db;
use app\admin\model\Chat as chatModel;

class Chat extends BaseController
{
    public function index()
    {
        $this->assign('navigation1','顾客管理');
        $this->assign('navigation2','客服消息');
        $this->assign('token', config('queue.websocket_kefu'));
        return view();
    }
    
    /**
     * ajax获取近30天用户聊天信息/某个用户的信息
     * 微信名、微信头像、最后一次聊天日期、是否未读、性别
     */
    public function getTheMouthChatCustom()
    {
        $openid = input('openid', '');
        if (empty($openid)) {
            $sql = "select c.*,u.use_nickname,u.use_sex,u.use_head_img from `chat` c inner join `user` u on c.openid=u.use_openid where id in (select max(id) from `chat` group by openid) and creat_time > '".date('Y-m-d H:i:s', time()-30*24*3600)."' order by creat_time desc";
            $chatlist = Db::query($sql);
        } else {
            $sql = "select c.*,u.use_nickname,u.use_sex,u.use_head_img from `chat` c inner join `user` u on c.openid=u.use_openid where id=(select max(id) from `chat` where openid='{$openid}') order by creat_time desc";
            $chatlist = Db::query($sql);
        }
        return json($chatlist);
    }


}
