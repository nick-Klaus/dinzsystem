<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];
$zt_type = $_POST['zt_type'];
   $arr = array(
     'zt_name'=>$_POST['zt_name'],
     'zt_logo'=>$_POST['zt_logo'],
     'zt_benner'=>$_POST['zt_benner'],
     'zt_txt' => $_POST['zt_txt'],
     'times'=>time(),
     'adduid'=>$uid,
     'zt_type'=>$zt_type,
  );
$error = $_POST['error'];
if( $error == 'yes' ){
    echo 'error';
    exit;
}

  if( $uid && isset($zt_type) ){
    if( insert($arr,'e_user_zt') ){
       echo 'go';
       exit;
    }
  }

if( $uid && !isset($zt_type)){
    if( insert($arr,'e_user_zt') ){
        echo 'go';
        exit;
    }
}




?>