<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_POST['uid'];
if( $uid ){
  $array = array
   (
    'username' => $_POST['username'],
    'userpwd' => $_POST['userpwd'],
    'user_bz' => $_POST['user_bz'],
    'groupid' => $_POST['groupid'],
    'webid'=> $_POST['webid'],
    'prov'=> $_POST['prov'],
    'city'=> $_POST['city'],
    'dist'=> $_POST['dist'],
    'store_name'=> $_POST['store_name'],
    'txcodes'=> $_POST['txcodes'],
    'email'=> $_POST['email'],
    'nickname'=> $_POST['nickname'],
    'mobile_phone'=> $_POST['mobile_phone'],
    'address'=> $_POST['address'],
    'birthday'=> $_POST['birthday'],
    'domain'=> $_POST['domain'],
    'user_sex'=> $_POST['user_sex'],
    'company_name'=> addslashes($_POST['company_name']),
   );
   if( update($array,'e_fx_members','uid='.$uid) ){
       echo 'go';
    }
    exit;
}
//停用会员
$edit_uid = $_POST['edit_uid'];
$usertyp = $_POST['usertyp'];
if( $edit_uid ){
  if( $usertyp == 0 ){
      $array = array('usertyp' => 1 );
  }elseif( $usertyp == 1  ){
      $array = array('usertyp' => 0 );
  }
  if( update($array,'e_fx_members','uid='.$edit_uid) ){
      echo 'go';
  }
  exit;
}




?>