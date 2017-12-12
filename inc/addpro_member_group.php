<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$adduid = $_SESSION['uid'];

$array = array(
  'group_name' => $_POST['group_name'],
  'remark' => $_POST['remark'],
  'adduid' => $adduid,
  'addtime' => time()
  );

  if( $adduid ){
      if( insert($array,'e_fx_group') ){
        echo 'go';
      }
  }

?>