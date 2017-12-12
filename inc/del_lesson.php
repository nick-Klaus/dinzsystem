<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
$uid = $_SESSION['uid'];
if( $delid ){
    if( delete('e_user_stu','id='.$delid) > 0){
        //删除与专题相关的课程
        delete('e_user_stu_list','stu_id='.$delid);
        echo 'go';
    }
}



?>