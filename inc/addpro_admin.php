<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

//添加管理员数据的处理
 $cuid = $_POST['cuid'];
$arr = fetchOne("select domain from e_members where uid = '$cuid'");
if( $arr['domain'] == 0 ){
    $domain = $cuid.',';
}else{
    $domain = $arr['domain'].$cuid.',';
}

if($arr){
    //$domain = $arr['domain']?$arr['domain']:"".$cuid.',';
    $array = array(
        'username' => $_POST['username'],
        'password' => $_POST['password'],
        'user_bz' => $_POST['user_bz'],
        'domain' => $domain,
        'cuid'=> $cuid,
        'datatype' => $_POST['datatype'],
        'diamond_data_typ' => $_POST['diamond_data_typ'],
        'categorytype'=> $_POST['categorytype'],
        'thematic_sets'=> $_POST['thematic_sets'],
        'train'=> $_POST['train'],
        'promotion'=> $_POST['promotion'],
        'marketing'=> $_POST['marketing'],
        'maydiakeys'=> $_POST['maydiakeys'],
        'maydiatable'=> $_POST['maydiatable'],
        'auth_type'=> $_POST['auth_type'],
        'regdate' => time()
     );
     }
     
    if( insert($array,'e_members') ){
         echo 'go';   
    }
     

?>