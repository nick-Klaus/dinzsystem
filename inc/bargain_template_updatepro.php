<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

if( $_POST['addurl'] == "imgurl" ){
    $arr = array(
        "remark" => $_POST['remark']
    );
   if( update($arr, 'bargain_admin_addurl', 'id=' . $_POST['id']) ){
        echo "go";
        exit;
   }
}else{
    $array = array(
        "logo" => $_POST['logo'],
        "name" => $_POST['name'],
        "list_url" => $_POST['list_url'],
        "add_url" => $_POST['add_url'],
        "bargain_des" => $_POST['bargin_des'],
        "addtime" => time()
    );
    if( insert($array,'bargain_template') ){
        echo 'go';
    }
}



?>