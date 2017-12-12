<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];
$uid = $_SESSION['uid'];
$sql = "select id,stu_logo from e_user_stu_list where id=".$delid;
$res = fetchOne($sql);
if( $delid ){
    if( delete('e_user_stu_list','id='.$delid) > 0){
        echo 'go';
    }
}

?>