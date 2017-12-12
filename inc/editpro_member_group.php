<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$id = $_POST['id'];

$array = array(
  'group_name' => $_POST['group_name'],
  'remark' => $_POST['remark'],
  'addtime' => time()
  );

  if( $id ){
      if( update($array,'e_fx_group','id='.$id) ){
         echo 'go';
      }
  }

?>