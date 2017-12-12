<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];
$add = $_GET['add'];
$qdz_type = $_GET['qdz_type'];
if( $qdz_type ){
  $str = "-{$qdz_type}";
}else{
  $qdz_type = 0;
  $str = "";
}
$page = $_GET['page'];
//单个上架款式
if( $add ){
    $sql = "select * from e_goods_sylte where id=$add";
    $array = fetchOne( $sql );
    $array['adduid'] = $uid;
    $array['past_id'] = $add;
    $array['times'] = time();
    $array['qdz_type'] = $qdz_type;
    $array['style_no'] .= "-{$uid}".$str;
    unset($array['id']);
    if( $uid ){
      insert($array,'e_goods_sylte');
      if( $qdz_type ){
        header("location:qdz_add.php?_page=".$page."&qdz_type=".$qdz_type);
      }else{
        header("location:style_list_user.php?_page=".$page."&qdz_type=".$qdz_type);
      }
      exit;
    }
}
//单个下架款式
$del = $_GET['del'];
if( $del &&  $uid){
    $where = " past_id='$del' and adduid='$uid' and qdz_type='$qdz_type'";
    delete('e_goods_sylte',$where);
    if( $qdz_type ){
        header("location:qdz_add.php?_page=".$page."&qdz_type=".$qdz_type);
      }else{
        header("location:style_list_user.php?_page=".$page."&qdz_type=".$qdz_type);
      }
    exit;
}

//批量上架
$addids = $_POST['addids'];
$pages = $_POST['page'];
$addids = isset($addids)?$addids:array();
if( $uid ){
  foreach ($addids as $k => $v) {
      $sql1 = "select * from e_goods_sylte where adduid='$uid'  and qdz_type='$qdz_type' and past_id=".$v;
      $arr1 = fetchOne( $sql1 );

      if( $arr1 ){
        $where = "adduid='".$uid."' and past_id=".$v." and qdz_type=".$qdz_type; 
        delete('e_goods_sylte',$where);
      }else{
        $sql = "select * from e_goods_sylte where id=".$v;
        $arr = fetchOne( $sql );
        $arr['adduid'] = $uid;
        $arr['past_id'] = $v;
        $arr['times'] = time();
        $arr['qdz_type'] = $qdz_type;
        $arr['style_no'] .= "-{$uid}".$str;
        unset($arr['id']);
        insert($arr,'e_goods_sylte');
      }
    }
      if( $qdz_type ){
        header("location:qdz_add.php?_page=".$page."&qdz_type=".$qdz_type);
      }else{
        header("location:style_list_user.php?_page=".$page."&qdz_type=".$qdz_type);
      }
      exit;
}



?>