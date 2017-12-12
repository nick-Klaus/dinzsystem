<?php
include "./../fun/eby_admin_api.php";
    $admin_user=$_POST['username'];
    $admin_pwd=$_POST['password'];
    $sql = "select * from e_members where username='$admin_user' and password='$admin_pwd'";
    $res = mysql_query($sql);
    if( $row=mysql_fetch_assoc( $res ) ){
        $_SESSION['uid']= $row['uid'];
        $_SESSION['ch_domain']=$row['domain'];
        $_SESSION['ch_username']=$row['username'];
        if( $_SESSION['uid'] == 195){
            echo 'going';
        }else{
            echo 'go';
        }
    }
?>