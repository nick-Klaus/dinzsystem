<?
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$uid      = $_SESSION['uid'];
$stu_type = $_POST['stu_type'];
    //添加课程专题的数组
  if( $uid && isset($stu_type) ){
    $arr  = array(
       'stu_name'  => $_POST['stu_name'],
       'stu_logo'  => $_POST['stu_logo'],
       'stu_txt'   => $_POST['stu_txt'],
       'video_url' => $_POST['video_url'],
       'times'     => time(),
       'adduid'    => $uid,
       'stu_type'  => $stu_type,
      );
  }
  //添加课程项目的数组
  if( $uid && !isset($stu_type) ){
    $arr  = array(
      'stu_name'  => $_POST['stu_name'],
      'adduid'    => $uid,
      'times'     => time(),
      'stu_type'  => 0,
      );
  }
//如果不存在课程项目则不能添加
$error = $_POST['error'];
if( $error == 'yes' ){
    echo 'error';
}else{
     if( insert($arr,'e_user_stu') ){
      echo 'go';
      exit;
  }
}


?>