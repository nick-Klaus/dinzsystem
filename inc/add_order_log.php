<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$order_no = $_POST['order_no'];
if( $order_no ){
    $array = array(
        'order_no' => $order_no,
        'times' => time(),
        'logty' => $_POST['logty'],
        'logtyname' => $_POST['logtyname'],
        'diatxt' => $_POST['diatxt'],
        'ip' => $_SERVER["REMOTE_ADDR"]
    );
}
if( insert($array,'e_order_log') ){
    header("Location:http://master.echao.com/inc/orders_show_web.php?order_no=".$order_no);
}


?>