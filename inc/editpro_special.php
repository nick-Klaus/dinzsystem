<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$id = $_POST['id'];
   $arr = array(
     'zt_name'=>$_POST['zt_name'],
     'zt_logo'=>$_POST['zt_logo'],
     'zt_benner'=>$_POST['zt_benner'],
     'zt_txt' => $_POST['zt_txt'],
     'times'=>time(),
     'zt_type'=>$_POST['zt_type'],
  );

  if( $id ){
    if( update($arr,'e_user_zt','id='.$id) ){
       echo 'go';
       exit;
    }  
  }

$edit_id = $_POST['edit_id'];
$uid     = $_POST['uid'];
$sort    = $_POST['sort'];
$array   = array( 'sort' => $sort );
$where   = "adduid=".$uid." and id=".$edit_id;
  if( $edit_id ){
    if( update($array,'e_user_zt',$where ) ){
       echo 'letgo';
       exit;
    }  
  }

?>