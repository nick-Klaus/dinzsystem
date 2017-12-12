<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
  $id  = $_POST['id'];
  $array = array_filter(explode(",",$_POST['url']));
  $data_type = $_POST['data_type'];
  $arr = array(
    'title' => $_POST['title'],
    'url' =>json_encode($array),
    'adduid' => $_POST['uid'],
    'addtime' => time(),
    'macid' =>  $_POST['macid'],
    'data_type'=> $data_type,
  );

if( $data_type == 3 || $data_type == 2 ){
    $arr['thum_url'] = $_POST['thum_url'];
}

//如果为视频则为  单图片和视频地址
if( $data_type == 3 ){
    $arr['video_url'] = urlencode($_POST['video_url']);
}

if( $id ){
  //存在这条数据则更新
  if( update($arr,'ppt_upload','id='.$id) ){
      echo 'go';
      exit;
  }
}else{
    //不存在数据则添加
    if( insert($arr,'ppt_upload') ){
        echo 'go';
        exit;
    }
}

?>