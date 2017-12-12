<?
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

 $id = $_POST['id'];
  if( $id ){
    $arr = array(
       'stu_name'=>$_POST['stu_name'],
       'stu_logo'=>$_POST['stu_logo'],
       'stu_txt' => $_POST['stu_txt'],
       'video_url' => $_POST['video_url'],
       'times'=>time(),
       'stu_type'=>$_POST['stu_type'],
      );
 if( update($arr,'e_user_stu','id='.$id) > 0 ){
         echo 'go';   
    }
     
}
?>