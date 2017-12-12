<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];
if( $id ){
    $arr = array(
     'service_tit'=>$_POST['service_tit'],
     'service_logo'=>$_POST['service_logo'],
     'introduce'=>$_POST['introduce'],
     'service_url'=>$_POST['service_url'],
     'service_page'=>$_POST['service_page'],
    );
}   

//修改排序
$sort_id = $_POST['sort_id'];

    if( $sort_id ){
        $arr = array( 'service_sort' => $_POST['sort']  );
        $id = $_POST['sort_id'];
    }

    if( update($arr,'e_mac_service','id='.$id) > 0 ){
        echo 'go';
    }

?>