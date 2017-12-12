<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$style_no = $_POST['style_no'];
if( $style_no ){
  $array = array
    (
      'style_no' => $style_no,
      'goods_no' => $_POST['goods_no'],
      'goods_name' => $_POST['goods_name'],
      'goods_thumb' => $_POST['goods_thumb'],
      'goods_video' => $_POST['goods_video'],
      'Price' => $_POST['Price'],
      'material' => $_POST['material'],
      'GoodsSize' => $_POST['GoodsSize'],
      'goldWeight' => $_POST['goldWeight'],
      'StoneType' => $_POST['StoneType'],
      'StonePrice' => $_POST['StonePrice'],
      'StoneTxt' => $_POST['StoneTxt'],
      'Color' => $_POST['Color'],
      'Clarity' => $_POST['Clarity'],
      'StoneWeight' => $_POST['StoneWeight'],
      'DeStoneNum' => $_POST['DeStoneNum'],
      'DeStoneWeight' => $_POST['DeStoneWeight'],
      'goods_type' => $_POST['goods_type'],
      'StoneShape' => $_POST['StoneShape'],
      'StoneNum' => $_POST['StoneNum'],
      'adduid' => $_POST['adduid'],
    );
}
   if( insert($array,'e_goods_list') ){
       echo 'go';
   }

?>