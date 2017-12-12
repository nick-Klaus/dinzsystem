<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
    //$admin_user=$_POST['username'];
    $style_thumb=$_POST['style_thumb'];
    $password=$_POST['password'];
    $member_name=$_POST['member_name'];
    $member_phone=$_POST['member_phone'];
    $categorytype=$_POST['categorytype'];
    $diamond_data_typ=$_POST['diamond_data_typ'];
    $datatype=$_POST['datatype'];
    $marketing=$_POST['marketing'];
    $promotion=$_POST['promotion'];
    $train=$_POST['train'];
    $thematic_sets=$_POST['thematic_sets'];
    $maydiakeys=$_POST['maydiakeys'];
    $maydiatable=$_POST['maydiatable'];
    $g_18=$_POST['g_18'];
    $g_pt=$_POST['g_pt'];
    $huilv=$_POST['huilv'];
    $order_notice=trim($_POST['order_notice']);
    $sql = "update  e_members  set  maydiakeys='$maydiakeys',maydiatable='$maydiatable',marketing='$marketing',promotion='$promotion',train='$train',thematic_sets='$thematic_sets',style_thumb='$style_thumb',password='$password',member_name='$member_name',member_phone='$member_phone',categorytype='$categorytype',diamond_data_typ='$diamond_data_typ',datatype='$datatype',g_18='$g_18',g_pt='$g_pt',huilv='$huilv',order_notice='$order_notice'  where uid=".$_POST['uid'];
    if( mysql_query($sql) ){
        echo 'go';  
    }else{
        echo 'error';
    }




?>