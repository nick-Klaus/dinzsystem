<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid =  $_SESSION['uid'];
$addid  = $_POST['addid'];

$zt_sql = "select * from  e_user_zt where id='$addid'";

$res    = fetchOne( $zt_sql );

if( is_array($res) ){

    $arr    = array(
      "zt_name" => $res['zt_name'],
      "zt_logo" => $res['zt_logo'],
      "zt_benner" => $res['zt_benner'],
      "zt_txt" => $res['zt_txt'],
      "zt_type" => $res['zt_type'],
      "times" => time(),
      "adduid" => $uid,
      "sort" => $res['sort']
      );
    //添加的$goods_id 为 e_user_zt_goods 表的 ztid
    $goods_id = insert($arr,'e_user_zt');

    if( $goods_id ){

        $goods_sql = "select * from  e_user_zt_goods where ztid='$addid'";

        $row = fetchAll( $goods_sql );

        $array = is_array( $row )?$row:array();

        foreach ($array as $k => $v) {

            $goods_arr = array(
              'ztid' => $goods_id,
              'style_no' => $v['style_no'],
              'zt_type' => $v['zt_type'],
              'times' => time(),
              'adduid' => $uid
              );
             insert($goods_arr,'e_user_zt_goods');          
        }
        echo 'go';        
    }
 }







?>