<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_POST['uid'];
$times = time();
  $openid = md5($times.$uid);
  $array = array(
    'openid' => $openid,
    'uid' => $uid
  );
  if( $uid ){
    if( insert($array,'e_mac_code') ){
      echo 'go';
    }
  }

?>