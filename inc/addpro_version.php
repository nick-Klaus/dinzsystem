<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];

  $arr = array(
    'version_name' => $_POST['version_name'],
    'version_folder' => $_POST['version_folder'],
    'addid' => $uid,
    'addtime' => time()
  );

  if( insert($arr,'soft_version_name') ){
    echo 'go';
  }

?>