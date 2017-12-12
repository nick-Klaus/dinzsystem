<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
  $adduid = $_SESSION['uid'];
  $id=$_POST['id'];
  if( $id ){
    $arr = array(
      'stu_tit'=>$_POST['stu_tit'],
      'stu_pic'=>$_POST['stu_pic'],
      'stu_txt'=>$_POST['stu_txt'],
      'stu_type'=>$_POST['stu_type'],
      'thumb_url'=>json_encode(explode(",",$_POST['thumb_url'])),
      'times'=>time(),
      'video_url'=>$_POST['video_url'],
    );
  }

  $sort_id = $_POST['sort_id'];
  if( $sort_id ){
      $arr = array('lesson_sort' => $_POST['sort']);
      $id  = $sort_id;
  }
  if(update($arr,'e_user_stu_list','id='.$id) > 0){
      echo 'go';
  }



?>