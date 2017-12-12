<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$id = $_POST['id'];
$arr = array_filter(explode(",", $_POST['mac_id']));
$arr = empty($arr)?0:$arr;
$array = array(
    'title'   => $_POST['title'],
    'warning' => $_POST['warning'],
    'content' => $_POST['content'],
    'addtime' => time(),
    'mac_id'  => json_encode($arr),
);


if( update($array,'e_admin_notice','id='.$id) ){
    echo 'go';
}



?>