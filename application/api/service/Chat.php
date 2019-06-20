<?php
namespace app\api\service;

use app\admin\model\Chat as chatModel;

class Chat
{
	/**
	 * 根据openid获取十条此用户相关聊天记录
	 */
	public function getTenChatListByOpenid($openid, $page=1, $limit=10)
	{
		$count = chatModel::where('openid', $openid)->count();
		$list = chatModel::where('openid', $openid)->order('creat_time desc')->limit(($page-1)*$limit, $limit)->select();
		$list = collection($list)->hidden(['openid'])->toArray();
		$list = array_reverse($list);
		$temp_arr = [];
		foreach ($list as $key => &$value) {
			$date = substr($value['creat_time'], 0, 10);
			if(!in_array($date, $temp_arr)) {
				$value['date'] = $date;
				array_push($temp_arr, $date);
			} else {
				$value['date'] = '';
			}
		}
		return [
			'count' => $count,
			'has_more' => (($page-1)*$limit+count($list)) < $count,
			'next_page' => $page + 1,
			'list' => $list
		];
	}
}
