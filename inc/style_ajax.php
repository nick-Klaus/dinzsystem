<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

 // 根据顶级分类的id 查询出子级 
 $bigid = $_GET['bigname']; 
if(isset($bigid)){ 
  $q=mysql_query("select * from e_goods_category where pid = $bigid"); 
  $select = "";
  $select[] = array("id"=>0,"catename"=>"请选择子级分类"); 
  while($row=mysql_fetch_array($q)){ 
    $select[] = array("id"=>$row['id'],"catename"=>$row['catename']); 
  } 
  echo json_encode($select);
  exit;
} 


?>