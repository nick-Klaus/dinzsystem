<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];
$mac_web = $_POST['mac_web'];
// 生成质保单
if( $_POST['pay_id'] == 5 && $_POST['warranty_bool'] == 'warranty' ){
    $uri = "http://weixin.echao.com/app/index.php?i=4&c=entry&do=policy_create_api&m=simp_warranty";//这里换成自己的服务器的地址
    // 参数数组
    $data = array (
        "source" => "demo",
        "card_no" => "",
        "order_no" => $_POST['order_no'],
        "standard" => "",
        "other" => "",
        "amount" => $_POST['rmb'],
        "remark" => $_POST['remark'],
        "real_name" => $_POST['lxr'],
        "mobile" => $_POST['mob'],
        "gd_no" => $_POST['style_no'],
        "gd_image" => "",
        "weight" => "",
        "certificate_no" => "",
        "confirm_name" => $_POST['lxr'],
        "original_price" => "",
        "sell_name" => $_POST['store_number'],
        "appsecret" => "1DC07F47272498E6",
        "openid" => $id
    );
    $ch = curl_init ();
    curl_setopt ( $ch, CURLOPT_URL, $uri );
    curl_setopt ( $ch, CURLOPT_POST, 1 );
    curl_setopt ( $ch, CURLOPT_HEADER, 0 );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
    $return = curl_exec ( $ch );
    curl_close ( $ch );
    //print_r();
    $arr_data = json_decode($return,true);
    $return = is_array ($arr_data)?$arr_data:array();
    if( $return['error_code'] == 0 ){
        $creat_data =  $return['data'];
        $creat = array(
            "uniacid"=> intval($creat_data['uniacid']),
            "shop"=> addslashes($_POST['store_number']),
            "member_id"=> intval($creat_data['member_id']),
            "policy_number"=> intval($creat_data['policy_number']),
            "selling_time"=> addslashes($creat_data['selling_time']),
            "branch_title"=> addslashes($creat_data['branch_title']),
            "standard"=> addslashes($creat_data['standard']),
            "other"=> addslashes($creat_data['other']),
            "remark"=> addslashes($creat_data['remark']),
            "status"=> intval($creat_data['status']),
            "amount"=> floatval($creat_data['status']),
            "amount_capital"=> addslashes($creat_data['amount_capital']),
            "card_no"=> addslashes($creat_data['card_no']),
            "order_no"=> addslashes($creat_data['order_no']),
            "real_name"=> addslashes($creat_data['real_name']),
            "mobile"=> addslashes($creat_data['mobile']),
            "source"=> addslashes($creat_data['source']),
            "gd_no"=> addslashes($creat_data['gd_no']),
            "gd_image"=> addslashes($creat_data['gd_image']),
            "weight"=> floatval($creat_data['weight']),
            "certificate_no"=> addslashes($creat_data['certificate_no']),
            "confirm_name"=> addslashes($creat_data['confirm_name']),
            "original_price"=> floatval($creat_data['original_price']),
            "sell_name"=> addslashes($creat_data['sell_name']),
            "template_id"=> intval($creat_data['template_id']),
            "examine_staffid"=> intval($creat_data['examine_staffid'])
        );
        // 添加到本地质保单信息中
        $warranty_id = insert($creat,'e_warranty_policy');
        if( $warranty_id ){
            $array = array(
                "warranty_id" => intval($creat_data['id']),
                "warranty_this_id" => $warranty_id
            );
            // 修改订单内信息
            if( update($array,'e_order_mac',' id='.$id) > 0 ){
                echo "go";
            }
        }
    }else{
        echo "error";
    }
    exit;
}

// 修改数据
if( $id ){
    $array = array(
    'pay_id' => $_POST['pay_id'],
    'rmb2' => $_POST['rmb2'],
    'lxr' => $_POST['lxr'],
    'mob' => $_POST['mob'],
    'addr' => $_POST['addr'],
    'deposit' => $_POST['deposit'],
    'sales_person' => $_POST['sales_person'],
    'store_number' => $_POST['store_number'],
);
}
if( $mac_web == "mac" ){
    $array['remark'] = $_POST['remark'];
	if( update($array,'e_order_mac',' id='.$id) > 0 ){
        echo "go";
	}
}elseif( $mac_web == "web" ){
	if( update($array,'e_order',' id='.$id) > 0 ){
        header("Location:http://master.echao.com/inc/orders_show_web.php?order_no=".$order_no);
	}
}






?>