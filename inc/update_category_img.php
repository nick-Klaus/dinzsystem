<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];
$uid = $_POST['uid'];
$url = $_POST['url'];
$array = array(
    'box_default_ico' => $url
    );
$where = "id=".$id;
if( $id ){
    if(update($array,'e_goods_category',$where) > 0){
      echo 'go';
    }
}

?>