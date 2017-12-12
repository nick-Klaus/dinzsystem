<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

 $uid = $_POST['uid'];
 if( $uid ){
  $array = array
    (
      'catename' => $_POST['catename'],
      'pid' => $_POST['pid'],
      'webid' => 0,
      'adduid' => $uid,
      'times'=> time()
    );
 }

 if( $_POST['jians'] == "yes"  ){
 	$array = array
    (
      'catename' => $_POST['catename'],
      'pid' => $_POST['pid'],
      'webid' => 0,
      'adduid' => 0,
      'times'=> time()
    );
 }
 if( insert($array,'e_goods_category') ){
        echo 'go';
 }
 


?>