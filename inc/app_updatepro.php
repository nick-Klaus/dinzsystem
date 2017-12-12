<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$cuid =  $_SESSION['uid'];
$id = $_POST['id'];
$act = $_POST['act'];
//信息设置
if( $act == 'no_ppt' ){
  $array = array(
   'uid' => $cuid,
   'app_tit' => $_POST['app_tit'],
   'app_logo' => $_POST['app_logo'],
   'mac_lxr' => $_POST['mac_lxr'],
   'web_phone' => $_POST['web_phone'],
   //'thumb_url' => json_encode(explode(",",$_POST['thumb_url'])),
   );

  if( $id ){
    if( update($array,'e_webapp_set','id='.$id) ){
      echo "go";     
    }
  }else{
     if( insert($array,'e_webapp_set') ){
      echo "go";     
    }
  }
  exit;
}

//幻灯片设置
if( $act == 'ppt' ){
   $arr = array_filter(explode(",",$_POST['url']));
    $array = array( 
      'adduid' => $_POST['adduid'],
      'url' => json_encode($arr),
      'addtime' => time()
   );

  if( $id ){
    if( update($array,'ppt_upload','id='.$id) ){
      echo "go";     
    }  
  }else{
    if( insert($array,'ppt_upload') ){
      echo "go";     
    } 
  }
  exit;
}



?>