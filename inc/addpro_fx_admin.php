<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$webid = $_POST['webid'];
  $array = array
   (
      'username' => $_POST['username'],
      'userpwd' => $_POST['userpwd'],
      'user_bz' => $_POST['user_bz'],
      'groupid' => $_POST['groupid'],
      'webid'=> $webid,
      'prov'=> $_POST['prov'],
      'city'=> $_POST['city'],
      'dist'=> $_POST['dist'],
      'store_name'=> $_POST['store_name'],
      'txcodes'=> $_POST['txcodes'],
      'email'=> $_POST['email'],
      'nickname'=> $_POST['nickname'],
      'mobile_phone'=> $_POST['mobile_phone'],
      'address'=> $_POST['address'],
      'user_sex'=> $_POST['user_sex'],
      'usertyp'=> 1,
      'birthday'=> $_POST['birthday']
   );
  if( $webid ){
    if( insert($array,'e_fx_members') ){
       echo 'go';
    }else{
        echo "error";
    }

  }


?>