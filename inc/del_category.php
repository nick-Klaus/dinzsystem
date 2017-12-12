<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$uid = $_SESSION['uid'];
$delid = $_POST['delid'];
if( $delid ){
    if( delete('e_goods_category','id='.$delid) > 0 ){
        //如果存在子类，父类删除则子类全部清除
        $sql = "select * from  e_goods_category where  pid='$delid' and  adduid='$uid'";
         if( count(fetchAll($sql)) > 0){
            if(delete('e_goods_category','pid='.$delid) > 0){
                echo 'go';
            }  
         }else{
            echo 'go';
         }     
    }
}


?>