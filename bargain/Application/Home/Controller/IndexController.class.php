<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{
    public function _initialize()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
    }

    // 获取活动详情
    public function index()
    {
        // 参加活动用户的参数
        $bargain_id = I("post.bargain_id");// 主活动ID
        $user_id = I("post.user_id");
        $openid = I("post.openid");

        $list = M("bargain")->where(array("id" => $bargain_id))->find();;
        $list['gift_describe'] = json_decode($list['gift_describe'], true);
        $list['company_introduction_img'] = json_decode($list['company_introduction_img'], true);
        $user_mod = M("bargain_user");
        // 参加此活动总人数和排名
        $bargain_user_all = $user_mod->where(array("bargain_id" => $bargain_id))->order('new_price asc,id DESC')->limit("0,20")->select();
        if ($user_id) {
            $where = array("id" => $user_id, "bargain_id" => $bargain_id);
            // 判断是否为本机的活动 我要参与
            $where_u = array("openid" => $openid, "bargain_id" => $bargain_id);
            $where_this = array("openid" => $openid, "bargain_id" => $bargain_id);
            // 砍价日志的获取判断是否砍过
            $list_log = M("bargain_log")->where(array("user_id" => $user_id, "openid" => $openid, "bargain_id" => $bargain_id))->select();
            if ($user_mod->where($where_u)->count()) {
                $user_data = 1;
            } else {
                $user_data = 2;
            }
        } else {
            $where = array("openid" => $openid, "bargain_id" => $bargain_id);
        }
        // 当前活动的用户
        $user_list = $user_mod->where($where)->select();
        $user_this = $user_mod->where($where_this)->select();

        // 当前活动有多少人查看过
        $check_list_see = intval($list['user_ck']);
        // 当前活动有多少人分享过
        $check_list = intval($list['user_fx']);
        // 当前活动有多少人参与
        $check_list_cj = intval($list['user_cj']);

        $this->ajaxReturn(array("list" => $list, "user_list" => $user_list, "list_log" => (array)$list_log, "user_l" => $user_data, "bargain_user_all" => $bargain_user_all, "check_list_see" => $check_list_see, "check_list" => $check_list, "user_this" => $user_this, "check_list_cj" => $check_list_cj));

    }

    // 获取活动详情 有轮播图的模板
    public function index_banner()
    {
        // 参加活动用户的参数
        $bargain_id = I("post.bargain_id");// 主活动ID
        $user_id = I("post.user_id");
        $openid = I("post.openid");

        $list = M("bargain")->where(array("id" => $bargain_id))->find();;
        $list['gift_describe'] = json_decode($list['gift_describe'], true);
        $list['company_introduction_img'] = json_decode($list['company_introduction_img'], true);
        $list['image_logo'] = json_decode($list['image_logo'], true);
        $user_mod = M("bargain_user");
        // 参加此活动总人数和排名
        $bargain_user_all = $user_mod->where(array("bargain_id" => $bargain_id))->order('new_price asc,id DESC')->limit("0,20")->select();
        if ($user_id) {
            $where = array("id" => $user_id, "bargain_id" => $bargain_id);
            // 判断是否为本机的活动 我要参与
            $where_u = array("openid" => $openid, "bargain_id" => $bargain_id);
            $where_this = array("openid" => $openid, "bargain_id" => $bargain_id);
            // 砍价日志的获取判断是否砍过
            $list_log = M("bargain_log")->where(array("user_id" => $user_id, "openid" => $openid, "bargain_id" => $bargain_id))->select();
            if ($user_mod->where($where_u)->count()) {
                $user_data = 1;
            } else {
                $user_data = 2;
            }
        } else {
            $where = array("openid" => $openid, "bargain_id" => $bargain_id);
        }
        // 当前活动的用户
        $user_list = $user_mod->where($where)->select();
        $user_this = $user_mod->where($where_this)->select();

        // 当前活动有多少人查看过
        $check_list_see = intval($list['user_ck']);
        // 当前活动有多少人分享过
        $check_list = intval($list['user_fx']);
        // 当前活动有多少人参与
        $check_list_cj = intval($list['user_cj']);

        $this->ajaxReturn(array("list" => $list, "user_list" => $user_list, "list_log" => (array)$list_log, "user_l" => $user_data, "bargain_user_all" => $bargain_user_all, "check_list_see" => $check_list_see, "check_list" => $check_list, "user_this" => $user_this, "check_list_cj" => $check_list_cj));

    }

    // 获取活动详情 有支付定金版本
    public function index_pay()
    {
        // 参加活动用户的参数
        $bargain_id = I("post.bargain_id");// 主活动ID
        $user_id = I("post.user_id");
        $openid = I("post.openid");

        $list = M("bargain")->where(array("id" => $bargain_id))->find();;
        $list['gift_describe'] = json_decode($list['gift_describe'], true);// 奖品描述转为数组
        $list['company_introduction_img'] = json_decode($list['company_introduction_img'], true);// 企业说明 转为数组

        // 商城支付参数
        $now_time = time();
        $list['pay_time'] = $now_time;// 令牌生成时间
        $list['modify'] = 'no';// 是否可以修改价格
        $list['order_no'] = "PAY-".$user_id;// 支付单号 字母必须为大写
        $list['token'] = md5($now_time.md5($list['pay_deposit'].$list['order_no'].$now_time));// 支付令牌
        $list['_url'] = urlencode("http://master.echao.com/bargain/index.php/Home/BargainPayLog/pay_deposit"); // 回调链接



        $user_mod = M("bargain_user");
        // 参加此活动总人数和排名
        $bargain_user_all = $user_mod->where(array("bargain_id" => $bargain_id))->order('new_price asc,id DESC')->limit("0,20")->select();
        if ($user_id) {
            $where = array("id" => $user_id, "bargain_id" => $bargain_id);
            // 判断是否为本机的活动 我要参与
            $where_u = array("openid" => $openid, "bargain_id" => $bargain_id);
            $where_this = array("openid" => $openid, "bargain_id" => $bargain_id);
            // 砍价日志的获取判断是否砍过
            $list_log = M("bargain_log")->where(array("user_id" => $user_id, "openid" => $openid, "bargain_id" => $bargain_id))->select();
            if ($user_mod->where($where_u)->count()) {
                $user_data = 1;
            } else {
                $user_data = 2;
            }
        } else {
            $where = array("openid" => $openid, "bargain_id" => $bargain_id);
        }
        // 当前活动的用户
        $user_list = $user_mod->where($where)->select();
        $user_this = $user_mod->where($where_this)->select();

        // 当前活动有多少人查看过
        $check_list_see = intval($list['user_ck']);
        // 当前活动有多少人分享过
        $check_list = intval($list['user_fx']);
        // 当前活动有多少人参与
        $check_list_cj = intval($list['user_cj']);

        $this->ajaxReturn(array("list" => $list, "user_list" => $user_list, "list_log" => (array)$list_log, "user_l" => $user_data, "bargain_user_all" => $bargain_user_all, "check_list_see" => $check_list_see, "check_list" => $check_list, "user_this" => $user_this, "check_list_cj" => $check_list_cj));

    }

    // 活动缓存到文件中
    private function getItem($id)
    {
        $item = S("bargain_cache" . $id);
        if (!is_array($item)) {
            $item = M("Bargain")->where(array("id" => $id))->find();
            if (!is_array($item)) {
                exit("404, 活动不存在！");
            }
            S("bargain_cache" . $id, $item);
        }
        return $item;
    }

    //点击获取用户排名
    public function user_list()
    {

        $user_mod = M("bargain_user");
        $bargain_id = I("post.bargain_id");
        $total = I("post.total");
        $limit = "0," . $total;

        $count = $user_mod->where(array("bargain_id" => $bargain_id))->count();

        if ($total <= $count) {
            $bargain_user = $user_mod->where(array("bargain_id" => $bargain_id))->order('new_price asc,id DESC')->limit($limit)->select();
        } else {
            $bargain_user = "error";
        }
        $this->ajaxReturn($bargain_user);
    }


}
