<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
  $adduid = $_SESSION['uid'];
  if( $adduid ){
    $arr = array(
      'stu_id'=>$_POST['stu_id'],
      'stu_tit'=>$_POST['stu_tit'],
      'stu_pic'=>$_POST['stu_pic'],
      'stu_txt'=>$_POST['stu_txt'],
      'stu_type'=>$_POST['stu_type'],
      'thumb_url'=>json_encode(explode(",",$_POST['thumb_url'])),
      'times'=>time(),
      'video_url'=>$_POST['video_url'],
      'adduid'=>$adduid
    );

  }
  if(insert($arr,'e_user_stu_list')){
      echo 'go';
  }

?>