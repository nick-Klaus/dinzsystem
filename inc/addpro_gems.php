<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid']; 
if( $uid ){
  $array = array
   (
    'Ref' => $Ref,
    'pic' => $pic,
    'category' => $category,
    'Shape' => $Shape,
    'style' => $style,
    'Grade' => $Grade,
    'Size' => $Size,
    'spe' => $spe,
    'Rate' => $Rate,
    'Bz' => $Bz,
    'adduid' => $uid
  );
}
  if( insert($array,'e_gems') ){
      echo 'go';   
  }


?>