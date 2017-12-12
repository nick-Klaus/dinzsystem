<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    $order_no = $_GET['order_no'];
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>订单详情</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../layui/css/layui.css"  media="all">
    <script src="../layui/jquery.min.js" charset="utf-8"></script>
    <script src="../layui/layui.js" charset="utf-8"></script>
    <script language="javascript" src="../layui/LodopFuncs.js"></script>
    <style>

        body{
            padding:10px;
        }
        .stock-table span{color:#0066FF;}
        .otherTable td{border:none!important;}
        .otherTable td span{padding:0 10px;}
        .otherTable td div {width: 150px; float: left}
    </style>


    <style media=print type="text/css">

        .noprint{visibility:hidden}
    </style>
</head>
<body>


<?php
    function unicode_decode($name)
    {
        $name = str_replace('u','\\u',$name);
        //转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all($pattern, $name, $matches);
        if (!empty($matches))
        {
            $name = '';
            for ($j = 0; $j < count($matches[0]); $j++)
            {
                $str = $matches[0][$j];
                if (strpos($str, '\\u') === 0)
                {
                    $code = base_convert(substr($str, 2, 2), 16, 10);
                    $code2 = base_convert(substr($str, 4), 16, 10);
                    $c = chr($code).chr($code2);
                    $c = iconv('UCS-2', 'UTF-8', $c);
                    $name .= $c;
                }
                else
                {
                    $name .= $str;
                }
            }
        }
        return $name;
    }

    function format_json($val)
    {
        // $val = str_replace('}"','}',str_replace('"{','{',$val));
        $val = str_replace(']"',']',str_replace('"[','[',$val));
        $val = str_replace('}"','}',str_replace('"{','{',$val));
        $val = str_replace('}"','}',str_replace('"{','{',$val));
        $val = str_replace('""','"',$val);

        return($val);
    }

    $sql = "select * from e_order_mac where order_no='$order_no'";
    $rs = fetchOne($sql);
    $arr = json_decode($rs['cartlist'],true);

?>

<table class="layui-table" >
    <tr>
        <td>
            订单号：<?php echo $rs['order_no']?>
        </td>
        <td>
            下单日期：<?php echo date("Y-m-d H:i:s",$rs['times']) ?>
        </td>
        <td>
            当前状态：  <?php

                switch ( $rs['pay_id'] ) {
                    case '0':
                        echo "待处理";
                        break;
                    case '1':
                        echo "已经确认";
                        break;
                    case '2':
                        echo "确认付款";
                        break;
                    case '3':
                        echo "确认发货";
                        break;
                    case '4':
                        echo "确认收货";
                        break;
                    case '5':
                        echo "订单完成";
                        break;
                }

            ?>
        </td>
    </tr>
</table>
<table width="100%" class="layui-table">
    <tr>
        <td width="10%" height="40" style="text-align:center">序号</td>
        <td width="80%">商品</td>
    </tr>

    <?php
        // foreach ($arr['cartlist'] as $k => $v) {

        //  if($v['carttyp'] == 1){
        //    var_dump($v['goodstxt']['diamond']['cnShape']) ;
        //  }
        // }
        $array = is_array($arr['cartlist'])?$arr['cartlist']:array();
        foreach ($array as $k => $v) {
            if( !$i ){
                $i=0;
            }
            ?>
            <tr>
                <td width="5%" height="80" style="text-align:center"> <?php echo $i+=1; ?></td>
                <td  style="overflow:hidden">

                    <?php
                        if( $v['carttyp'] == 0  ){

                            ?>

                            <table class="layui-table" style="font-size:.7em;width:50%">
                                <tr>
                                    <th width="70" rowspan="2" style="text-align:center">

                                        <img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['style_thumb'] ?>" style="width:60px;height:60px"  />
                                    </th>
                                    <td width="50%" style="text-align:left;padding-left:10px"><span>款号:</span><?php  echo $v['goodstxt']['style_no'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"  style="text-align:left;padding-left:10px">

                                        <span>现托货号:</span> <?php  echo $v['goodstxt']['goods_no'] ?> <br/>


                                        <span>材质:</span><?php  echo $v['goodstxt']['material'] ?> <span>镶口:</span><?php  echo $v['goodstxt']['S_Weight'] ?> <span>手寸:</span><?php  echo $v['goodstxt']['GoodsSize'] ?>#  <br/><span>刻字:</span><?php  echo $v['goodstxt']['kz'] ?> <span>备注:</span><?php  echo $v['goodstxt']['bz'] ?>

                                    </td>
                                </tr>

                            </table>
                            <?php
                        }

                    ?>


                    <?php
                        if( $v['carttyp'] == 1  ){

                            ?>

                            <table class="layui-table" style="font-size:.7em;width:50%;">
                                <tr>
                                    <th width="70" rowspan="2"  style="text-align:center" class="click_goods" >

                                        <img src="../images/<?php  echo $v['goodstxt']['diamond']['Shape'] ?>.png" style="height:50px;margin-bottom:5px">


                                    </th>
                                    <td width="50%" style="text-align:left;padding-left:10px"><span>货号:</span><?php  echo $v['goodstxt']['diamond']['Ref'] ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2"  style="text-align:left;padding-left:10px">
                                        <span>形状:</span> <?php  echo $v['goodstxt']['diamond']['cnShape'] ?>
                                        <span>大小:</span> <?php  echo $v['goodstxt']['diamond']['Size'] ?>ct
                                        <span>颜色:</span> <?php  echo $v['goodstxt']['diamond']['Color'] ?>
                                        <span>净度:</span> <?php  echo $v['goodstxt']['diamond']['Clarity'] ?> <br/>
                                        <span>切工:</span> <?php  echo $v['goodstxt']['diamond']['Cut'] ?>
                                        <span>抛光:</span> <?php  echo $v['goodstxt']['diamond']['Polish'] ?>
                                        <span>对称:</span> <?php  echo $v['goodstxt']['diamond']['Sym'] ?>
                                        <span>荧光:</span> <?php  echo $v['goodstxt']['diamond']['Flour'] ?>
                                    </td>
                                </tr>

                            </table>
                            <?php
                        }

                    ?>

                    <?php
                        if( $v['carttyp'] == 2  ){

                            ?>

                            <table class="layui-table" width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td width="50%">

                                        <table class="layui-table" style="font-size:.7em;width:100%">
                                            <tr>
                                                <th width="70" rowspan="2" style="text-align:center">

                                                    <img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['style_thumb'] ?>" style="width:60px;height:60px"  />
                                                </th>
                                                <td width="50%" style="text-align:left;padding-left:10px"><span>款号:</span><?php  echo $v['goodstxt']['style_no'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"  style="text-align:left;padding-left:10px">

                                                    <span>现托货号:</span> <?php  echo $v['goodstxt']['goods_no'] ?> <br/>   <?php  echo $v['goodstxt']['kz'] ?>

                                                    <span>材质:</span><?php  echo $v['goodstxt']['material'] ?><span>镶口:</span><?php  echo $v['goodstxt']['S_Weight'] ?><span>手寸:</span><?php  echo $v['goodstxt']['GoodsSize'] ?>#  <br/><span>刻字:</span><?php  echo $v['goodstxt']['kz'] ?>  <span>备注:</span><?php  echo $v['goodstxt']['bz'] ?>

                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                    <td  width="50%">

                                        <table class="layui-table" style="font-size:.7em;width:100%;">
                                            <tr>
                                                <th width="70" rowspan="2"  style="text-align:center" class="click_goods" >


                                                    <img src="../images/<?php  echo $v['goodstxt']['diamond']['Shape'] ?>.png" style="height:50px;margin-bottom:5px">


                                                </th>
                                                <td width="50%" style="text-align:left;padding-left:10px"><span>货号:</span><?php  echo $v['goodstxt']['diamond']['Ref'] ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"  style="text-align:left;padding-left:10px">
                                                    <span>形状:</span> <?php  echo $v['goodstxt']['diamond']['cnShape'] ?>
                                                    <span>大小:</span> <?php  echo $v['goodstxt']['diamond']['Size'] ?>ct
                                                    <span>颜色:</span> <?php  echo $v['goodstxt']['diamond']['Color'] ?>
                                                    <span>净度:</span> <?php  echo $v['goodstxt']['diamond']['Clarity'] ?> <br/>
                                                    <span>切工:</span> <?php  echo $v['goodstxt']['diamond']['Cut'] ?>
                                                    <span>抛光:</span> <?php  echo $v['goodstxt']['diamond']['Polish'] ?>
                                                    <span>对称:</span> <?php  echo $v['goodstxt']['diamond']['Sym'] ?>
                                                    <span>荧光:</span> <?php  echo $v['goodstxt']['diamond']['Flour'] ?>
                                                </td>
                                            </tr>

                                        </table>

                                    </td>
                                </tr>
                            </table>

                            <?php
                        }

                    ?>

                    <!-- 旋转戒-->
                    <?php
                        if( $v['carttyp'] == 4  ){
                            ?>
                            <table class="layui-table otherTable" style="font-size:.7em;width:100%; border: none;">
                                <tr>
                                    <td width="70"  rowspan="3" style="text-align:center">
                                        中转圈：
                                    </td>
                                    <td   style="text-align:left">
                                        <div><span>款号: </span><?php  echo $v['goodstxt']['zdj']['zq']['sku_no'] ?></div>
                                        <div><span>款名: </span><?php  echo $v['goodstxt']['zdj']['zq']['sku_name'] ?></div>
                                        <div><span>款式: </span><?php  echo $v['goodstxt']['zdj']['zq']['sex']=='f'?"女款":"男款" ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td   style="text-align:left">
                                        <div>  <span>材质: </span><?php  echo $v['goodstxt']['zdj']['zq']['caizhi'] ?></div>
                                        <div>  <span>指圈: </span><?php  echo $v['goodstxt']['zdj']['zq']['zquan'] ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td   style="text-align:left ">
                                        <div> <span>肌理: </span><?php  echo $v['goodstxt']['zdj']['zq']['jl_name'] ?></div>
                                        <div> <span>钻石: </span><?php  echo $v['goodstxt']['zdj']['zq']['dia'] ?></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70"  style="text-align:center">
                                        边圈1：
                                    </td>
                                    <td style="text-align:left">
                                        <div> <span>款号: </span><?php  echo $v['goodstxt']['zdj']['bq1']['sku_no'] ?></div>
                                        <div> <span>款名: </span><?php  echo $v['goodstxt']['zdj']['bq1']['sku_name'] ?></div>
                                        <div> <span>材质: </span><?php  echo $v['goodstxt']['zdj']['bq1']['caizhi'] ?></div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="70"  style="text-align:center">
                                        边圈2：
                                    </td>
                                    <td style="text-align:left">
                                        <div> <span>款号: </span><?php  echo $v['goodstxt']['zdj']['bq2']['sku_no'] ?></div>
                                        <div> <span>款名: </span><?php  echo $v['goodstxt']['zdj']['bq2']['sku_name'] ?></div>
                                        <div> <span>材质: </span><?php  echo $v['goodstxt']['zdj']['bq2']['caizhi'] ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="70"  rowspan="2" style="text-align:center">
                                        杯底：
                                    </td>
                                    <td style="text-align:left">
                                        <div> <span>款号: </span><?php  echo $v['goodstxt']['zdj']['bd']['sku_no'] ?></div>
                                        <div> <span>款名: </span><?php  echo $v['goodstxt']['zdj']['bd']['sku_name'] ?></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="text-align:left">
                                        <div> <span>材质: </span><?php  echo $v['goodstxt']['zdj']['bd']['caizhi'] ?></div>
                                        <div> <span>指圈: </span><?php  echo $v['goodstxt']['zdj']['bd']['sku_name'] ?></div>
                                    </td>
                                </tr>
                            </table>


                            <?php
                        }
                    ?>
                    <!-- 旋转戒-->
                    <?php
                        if( $v['carttyp'] == 3  ){

                            if( $v['goodstxt']['G_Goods'] ){

                                ?>


                                <table class="layui-table" style="font-size:.7em;width:50%;float:left">
                                    <tr>
                                        <th width="70" rowspan="2" style="text-align:center">


                                            <img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['G_Goods']['style_thumb'] ?>" style="width:60px;height:60px"  />
                                        </th>
                                        <td width="50%" style="text-align:left;padding-left:10px"><span>款号:</span><?php  echo $v['goodstxt']['style_no'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"  style="text-align:left;padding-left:10px">
                                            <?php  echo $v['goodstxt']['G_Goods']['goods_name'] ?>

                                            <span>货号:</span> <?php  echo $v['goodstxt']['G_Goods']['goods_no'] ?>

                                            <span>金重:</span><?php  echo $v['goodstxt']['G_Goods']['goldWeight'] ?>g <span>材质:</span><?php  echo $v['goodstxt']['G_Goods']['material'] ?> <br/>
                                            <span>主石:</span><?php  echo $v['goodstxt']['G_Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['G_Goods']['StoneNum'] ?><span>颗</span> <?php  echo $v['goodstxt']['G_Goods']['StoneWeight'] ?>ct <span>颜色:</span><?php  echo $v['goodstxt']['G_Goods']['Color'] ?> <span>净度:</span><?php  echo $v['goodstxt']['G_Goods']['Clarity'] ?>   <br/>

                                            <?php  if( $v['goodstxt']['G_Goods']['style_sort'] == 0 ){    ?>
                                                <span>尺寸:</span><?php echo $v['goodstxt']['G_Goods']['GoodsSize'] ?>#
                                                <?php
                                            }
                                            ?>

                                            <span>副石:</span><?php  echo $v['goodstxt']['G_Goods']['DeStoneNum'] ?><span>颗,</span><?php  echo $v['goodstxt']['G_Goods']['DeStoneWeight'] ?><span>ct</span> <br/>

                                            <?php  if( $v['goodstxt']['G_Goods']['kz'] ){    ?>
                                                <span>刻字:</span><?php  echo $v['goodstxt']['G_Goods']['kz'] ?>
                                                <?php
                                            }
                                            ?>
                                            <?php  if( $v['goodstxt']['G_Goods']['bz'] ){    ?>
                                                <span>备注:</span><?php  echo $v['goodstxt']['G_Goods']['bz'] ?>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>

                                </table>

                                <?php
                            }

                            ?>

                            <?php

                            if( $v['goodstxt']['B_Goods'] ){

                                ?>


                                <table class="layui-table" style="font-size:.7em;width:50%;float:left">
                                    <tr>
                                        <th width="70" rowspan="2" style="text-align:center">


                                            <img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['B_Goods']['style_thumb'] ?>" style="width:60px;height:60px"  />
                                        </th>
                                        <td width="50%" style="text-align:left;padding-left:10px"><span>款号:</span><?php  echo $v['goodstxt']['style_no'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"  style="text-align:left;padding-left:10px">
                                            <?php  echo $v['goodstxt']['B_Goods']['goods_name'] ?>
                                            <?php  if( $v['goodstxt']['B_Goods']['goods_no'] ){    ?>
                                                <span>货号:</span> <?php  echo $v['goodstxt']['B_Goods']['goods_no'] ?>
                                                <?php
                                            }
                                            ?>

                                            <span>金重:</span><?php  echo $v['goodstxt']['B_Goods']['goldWeight'] ?>g <span>材质:</span><?php  echo $v['goodstxt']['B_Goods']['material'] ?> <br/>
                                            <span>主石:</span><?php  echo $v['goodstxt']['B_Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['B_Goods']['StoneNum'] ?><span>颗</span> <?php  echo $v['goodstxt']['B_Goods']['StoneWeight'] ?>ct <span>颜色:</span><?php  echo $v['goodstxt']['B_Goods']['Color'] ?> <span>净度:</span><?php  echo $v['goodstxt']['B_Goods']['Clarity'] ?>  <br/>

                                            <?php  if( $v['goodstxt']['B_Goods']['style_sort'] == 0 ){    ?>
                                                <span>尺寸:</span><?php  echo $v['goodstxt']['B_Goods']['GoodsSize'] ?>#
                                                <?php
                                            }
                                            ?>
                                            <span>副石:</span><?php  echo $v['goodstxt']['B_Goods']['DeStoneNum'] ?><span>颗,</span>
                                            <?php  echo $v['goodstxt']['B_Goods']['DeStoneWeight'] ?><span>ct</span> <br/>

                                            <?php  if( $v['goodstxt']['B_Goods']['kz'] ){    ?>
                                                <span>刻字:</span><?php  echo $v['goodstxt']['B_Goods']['kz'] ?>
                                                <?php
                                            }
                                            ?>
                                            <?php  if( $v['goodstxt']['B_Goods']['bz'] ){    ?>
                                                <span>备注:</span><?php  echo $v['goodstxt']['B_Goods']['bz'] ?>
                                                <?php
                                            }
                                            ?>

                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                            ?>

                            <?php

                            if( $v['goodstxt']['Goods'] ){

                                ?>



                                <table class="layui-table" style="font-size:.7em;width:50%">
                                    <tr>
                                        <th width="70" rowspan="2" style="text-align:center">
                                            <img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['Goods']['style_thumb'] ?>" style="width:60px;height:60px"  />
                                        </th>
                                        <td width="50%" style="text-align:left;padding-left:10px"><span>款号:</span><?php  echo $v['goodstxt']['style_no'] ?></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"  style="text-align:left;padding-left:10px">
                                            <?php  if( $v['goodstxt']['Goods']['goods_no'] ){    ?>
                                                <span>货号:</span> <?php  echo $v['goodstxt']['Goods']['goods_no'] ?>
                                                <?php
                                            }
                                            ?>

                                            <span>金重:</span><?php  echo $v['goodstxt']['Goods']['goldWeight'] ?>g <span>材质:</span><?php  echo $v['goodstxt']['Goods']['material'] ?> <br/>
                                            <span>主石:</span><?php  echo $v['goodstxt']['Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['Goods']['StoneNum'] ?><span>颗</span> <?php  echo $v['goodstxt']['Goods']['StoneWeight'] ?>ct <span>颜色:</span><?php  echo $v['goodstxt']['Goods']['Color'] ?> <span>净度:</span><?php  echo $v['goodstxt']['Goods']['Clarity'] ?>   <br/>

                                            <?php  if( $v['goodstxt']['Goods']['style_sort'] == 0 ){    ?>
                                                <span>尺寸:</span><?php  echo $v['goodstxt']['Goods']['GoodsSize'] ?>#
                                                <?php
                                            }
                                            ?>

                                            <?php  echo $v['goodstxt']['Goods']['DeStoneWeight'] ?>

                                            <span>副石:</span><?php  echo $v['goodstxt']['Goods']['DeStoneNum'] ?><span>颗,</span><?php  echo $v['goodstxt']['Goods']['DeStoneWeight'] ?><span>ct</span> <br/>

                                            <?php  if( $v['goodstxt']['Goods']['kz'] ){    ?>
                                                <span>刻字:</span><?php  echo $v['goodstxt']['Goods']['kz'] ?>
                                                <?php
                                            }
                                            ?>
                                            <?php  if( $v['goodstxt']['Goods']['bz'] ){    ?>
                                                <span>备注:</span><?php  echo $v['goodstxt']['Goods']['bz'] ?>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                </table>

                                <?php
                            }

                            ?>



                            <?php
                        }
                    ?>
                </td>
            </tr>

            <?php
        }
    ?>
</table>
<table  width="100%" class="layui-table">
    <tr>
        <td width="100">联系人 </td><td> <?php echo $rs['lxr']?></td>
    </tr>
    <tr>
        <td width="100">联系电话 </td><td><?php echo $rs['mob']?></td>
    </tr>
    <tr>
        <td width="100">联系地址</td><td><?php echo $rs['addr']?></td>
    </tr>
    <tr>
        <td width="100">销售门店 </td><td><?php echo $rs['sales_person']?></td>
    </tr>
    <tr>
        <td width="100">销售员 </td><td><?php echo $rs['store_number']?></td>
    </tr>
    <tr>
        <td width="100">定金 </td><td><?php echo $rs['deposit']?></td>
    </tr>
    <tr>
        <td width="100">备注 </td><td><?php echo $rs['remark']?></td>
    </tr>

</table>



<!-- <a href="javascript:prn3_preview()" class="layui-btn" id='layui-btn'>打印订单</a> -->
<input type="button" class="noprint" value=" 打 印 "  style="width:100px;height:35px;background:#1AA094;border:none;color:#ffffff;-webkit-border-radius:3px; "  onclick="xx()">
<script type="text/javascript">

    function xx(){
        window.print();
    }
</script>
</body>
</html>