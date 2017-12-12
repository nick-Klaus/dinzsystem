<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id       = $_POST['id'];
$str = trim($_POST['catename']);
$catename = mb_ereg_replace('^(([ \r\n\t])*(　)*)*', '', $str); //去除前面的全角空格
$sort     = trim($_POST['sort']);
if( $sort >= 0 && empty($catename) ){
	$array = array( 'sort' => $sort );
}else{
	$array = array( 'catename' => $catename );
}
$where = "id='$id'";
if( $id ){
    if(update($array,'e_goods_category',$where) > 0){
        echo 'go';
    }
}

?>