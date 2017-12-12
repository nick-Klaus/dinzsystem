<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
// 修改砍价活动的状态
$id = $_POST['id'];
$status = $_POST['status'];
if( $status > 0  ){
    $array = array( 'status'=> 0 );
}else{
    $array = array( 'status'=> 1 );
}

if( $id ){
    if( update($array,'bargain','id='.$id) ){
        echo go;
    }
}



?>