<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
//查询出款式的款号
$id = $_POST['id'];
$style_no = $_POST['style_no'];
$sql = "select max(Price),min(Price),max(StoneWeight),min(StoneWeight),max(DeStoneWeight),min(DeStoneWeight) from e_goods_list where style_no='$style_no'";
$res = fetchAll( $sql )[0];

$num_sql = "select * from e_goods_list where style_no='$style_no'";
$num = getTotalRows( $num_sql );
    $array = array(
        'stocks' => $num,
        // 'MinPrice' => $res['min(Price)'],
        // 'MaxPrice' => $res['max(Price)'],
        'MinStoneWeight' => $res['min(StoneWeight)'],
        'MaxStoneWeight' => $res['max(StoneWeight)'],
        'MinDeStoneWeight' => $res['min(DeStoneWeight)'],
        'MaxDeStoneWeight' => $res['max(DeStoneWeight)']
    );
  update($array,'e_goods_sylte','id='.$id);
?>