<?php
namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\UserToken;
use app\admin\model\Chat as chatModel;
use app\api\service\Chat as chatService;

class Chat extends BaseController
{
    /**
     * 获取未读客服消息数量
     */
    public function noreadNum()
    {
        $openid = UserToken::getTokenValue('openid');
        $noreadnum = chatModel::where('openid', $openid)->where('type', 1)->where('isread', 0)->count();
        return json([
            'noreadnum' => $noreadnum
        ]);
    }

    /**
     * 将未读消息变为已读
     * 此方法供小程序端、pc端调用。
     * @param string type  1:用户传，将客服消息变为已读 2:客服传，将用户消息变为已读
     */
    public function statusToRead()
    {
        $openid = input('openid', '');
        $type = input('type');
        if (!in_array($type, ['1', '2'])) {
            return json(['error'=>1, 'msg'=>'type参数有误']);
        }
        if (empty($openid)) {
            $openid = UserToken::getTokenValue('openid');
        }
        chatModel::where('openid', $openid)->where('type', $type)->where('isread', 0)->update(['isread' => 1]);
        return json(['error'=>0, 'msg'=>'更新成功']);
    }

    /**
     * 分页获取对话列表数据
     */
    public function getChatList()
    {
        $openid = input('openid', '');
        $page = input('page', 1);
        if (empty($openid)) {
            $openid = UserToken::getTokenValue('openid');
        }
        $chat = new chatService();
        $rst = $chat->getTenChatListByOpenid($openid, $page);
        return json($rst);
    }
}