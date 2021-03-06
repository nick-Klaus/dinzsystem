<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";

?>
<!doctype html>
<html>
<head>
    <meta charset = "utf-8">
    <title>layui</title>
    <meta name = "renderer" content = "webkit">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1">
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
    <link rel = "stylesheet" href = "../layui/css/layui.css" media = "all">
    <script src = "../layui/jquery.min.js" charset = "utf-8"></script>
    <script src = "../layui/layui.js" charset = "utf-8"></script>
    <style>

        body {
            padding: 10px;
        }

        .stock-table span {
            color: #0066FF;
        }

        .otherTable td {
            border: none !important;
        }

        .otherTable td span {
            padding: 0 10px;
        }

        .otherTable td div {
            width: 150px;
            float: left
        }
        #img_hover{
              position: relative;
          }
        #img_hover div{
            position: absolute;
            width: 300px;
            height: 300px;
            display: none;
        }
        #img_hover img{
            width:180px;
            height: 80px;
        }
        #img_hover:hover div{
            display: block;
        }
        #img_hover:hover div img{
            width:100%;
            height:100%;
        }
        .yj_img{
            width:80px;
            height: 50px;
        }
        .yj_img:hover {
            transform: scale(4); /*指的是图片放大的倍数*/
        }

    </style>
</head>
<body>

<fieldset class = "layui-elem-field layui-field-title" style = "margin-top: 20px;">
    <legend><b>订单详情</b></legend>
</fieldset>


<?php
    function unicode_decode ( $name )
    {
        $name = str_replace ( 'u' , '\\u' , $name );
        //转换编码，将Unicode编码转换成可以浏览的utf-8编码
        $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
        preg_match_all ( $pattern , $name , $matches );
        if ( ! empty( $matches ) ) {
            $name = '';
            for ( $j = 0 ; $j < count ( $matches[ 0 ] ) ; $j ++ ) {
                $str = $matches[ 0 ][ $j ];
                if ( strpos ( $str , '\\u' ) === 0 ) {
                    $code = base_convert ( substr ( $str , 2 , 2 ) , 16 , 10 );
                    $code2 = base_convert ( substr ( $str , 4 ) , 16 , 10 );
                    $c = chr ( $code ) . chr ( $code2 );
                    $c = iconv ( 'UCS-2' , 'UTF-8' , $c );
                    $name .= $c;
                }
                else {
                    $name .= $str;
                }
            }
        }

        return $name;
    }

    function format_json ( $val )
    {
        // $val = str_replace('}"','}',str_replace('"{','{',$val));
        $val = str_replace ( ']"' , ']' , str_replace ( '"[' , '[' , $val ) );
        $val = str_replace ( '}"' , '}' , str_replace ( '"{' , '{' , $val ) );
        $val = str_replace ( '}"' , '}' , str_replace ( '"{' , '{' , $val ) );
        $val = str_replace ( '""' , '"' , $val );

        return ( $val );
    }

    $sql = "select a.*,b.type_id,b.body from e_order_mac a left join e_customization  b on a.Goodsopenid=b.code_no  where order_no='$order_no'";
    $rs = fetchOne ( $sql );
    $arr = json_decode ( $rs[ 'cartlist' ] , TRUE );
    // var_dump( $rs['cartlist'] );
?>

<form class = "layui-form" action = "">
    <input type = "hidden" name = "id" value = "<?php echo $rs[ 'id' ] ?>">
    <input type = "hidden" name = "mac_web" value = "mac">
    <!--选项卡的内容-->
    <table class = "layui-table">
        <tr>
            <td>
                订单号：<?php echo $rs[ 'order_no' ] ?>
                <input type = "hidden" name = "order_no" value = "<?php echo $rs[ 'order_no' ] ?>" >
            </td>
            <td>
                下单日期：<?php echo date ( "Y-m-d H:i:s" , $rs[ 'times' ] ) ?>
            </td>
            <td width = "800">
                当前状态： <?php if ( $rs[ 'pay_id' ] == 99 ) {
                    echo "订单已取消";
                } else { ?>
                    <input type = "radio" name = "pay_id" value = "0"  title = "待处理" <?php if ( $rs[ 'pay_id' ] == 0 ) {
                        echo "checked='checked'";
                    }elseif($rs[ 'pay_id' ] == 5){ echo "disabled"; } ?> />
                    <input type = "radio" name = "pay_id" value = "1" title = "已经确认" <?php if ( $rs[ 'pay_id' ] == 1 ) {
                        echo "checked='checked'";
                    }elseif($rs[ 'pay_id' ] == 5){ echo "disabled"; } ?> />
                    <input type = "radio" name = "pay_id" value = "2" title = "确认付款" <?php if ( $rs[ 'pay_id' ] == 2 ) {
                        echo "checked='checked'";
                    }elseif($rs[ 'pay_id' ] == 5){ echo "disabled"; } ?> />
                    <input type = "radio" name = "pay_id" value = "3" title = "确认发货" <?php if ( $rs[ 'pay_id' ] == 3 ) {
                        echo "checked='checked'";
                    }elseif($rs[ 'pay_id' ] == 5){ echo "disabled"; } ?> />
                    <input type = "radio" name = "pay_id" value = "4" title = "确认收货" <?php if ( $rs[ 'pay_id' ] == 4 ) {
                        echo "checked='checked'";
                    }elseif($rs[ 'pay_id' ] == 5){ echo "disabled"; } ?> />
                    <input type = "radio" name = "pay_id" value = "5" title = "订单完成" <?php if ( $rs[ 'pay_id' ] == 5 ) {
                        echo "checked='checked'";
                    } ?> />
                <?php } ?>
            </td>
        </tr>
    </table>
    <table width = "100%" class = "layui-table">
        <tr>
            <td width = "10%" height = "40" style = "text-align:center">序号</td>
            <td width = "80%">商品</td>
            <td width = "10%">价格</td>

        </tr>

        <?php
            // foreach ($arr['cartlist'] as $k => $v) {

            //  if($v['carttyp'] == 1){
            //    var_dump($v['goodstxt']['diamond']['cnShape']) ;
            //  }
            // }
            $array = is_array ( $arr[ 'cartlist' ] ) ? $arr[ 'cartlist' ] : [];

            foreach ( $array as $k => $v ) {
                if ( ! $i ) {
                    $i = 0;
                }
                ?>
                <tr>
                    <td width = "5%" height = "80" style = "text-align:center"> <?php echo $i += 1; ?></td>
                    <td style = "overflow:hidden">
                        <!--空托-->
                        <?php
                            if ( $v[ 'carttyp' ] == 0 ) {

                                ?>

                                <table class = "layui-table" style = "font-size:.7em;width:50%">
                                    <tr>
                                        <th width = "70" rowspan = "2" style = "text-align:center">

                                            <img src = "<?php if ( $v[ 'goodstxt' ][ 'best64' ] == 1 ) {
                                                echo "http://imageserver.echao.com/imagespath";
                                            } else {
                                                echo "http://imageserver.echao.com";
                                            } ?>/<?php echo $v[ 'goodstxt' ][ 'style_thumb' ] ?>"
                                                 style = "width:60px;height:60px" />
                                        </th>
                                        <td width = "50%" style = "text-align:left;padding-left:10px">
                                            <span>款号:</span><?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>
                                            <input type = "hidden" name = "style_no" value = "<?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>" >
                                        </td>
                                        <td>￥<b style = "color:red"><?php echo $v[ 'goodstxt' ][ 'Price' ] ?></b>元</td>
                                    </tr>
                                    <tr>
                                        <td colspan = "2" style = "text-align:left;padding-left:10px">

                                            <span>现托货号:</span> <?php echo $v[ 'goodstxt' ][ 'goods_no' ] ?> <br />


                                            <span>材质:</span><?php echo $v[ 'goodstxt' ][ 'material' ] ?>
                                            <span>镶口:</span><?php echo $v[ 'goodstxt' ][ 'S_Weight' ] ?>
                                            <span>手寸:</span><?php echo $v[ 'goodstxt' ][ 'GoodsSize' ] ?># <br /><span>刻字:</span><?php echo $v[ 'goodstxt' ][ 'kz' ] ?>
                                            <span>备注:</span><?php echo $v[ 'goodstxt' ][ 'bz' ] ?>
                                            <br/><?php
                                                $yj_type = $v[ 'goodstxt' ][ 'yj_type' ];
                                                if( $yj_type == 3 || $yj_type == 4 || $yj_type == 5 ){

                                                    if( $yj_type == 3 && $v[ 'goodstxt' ][ 'yj_body' ]) {
                                                        echo  "<span>印记:</span>";
                                                        $arr_type = explode ( "|" , $v[ 'goodstxt' ][ 'yj_body' ] );
                                                        $len = count($arr_type);
                                                        for ( $i=0; $i < $len; $i++){
                                                            echo  $ion = "  <i class='icon iconfont'>". $arr_type[$i] . "</i>";
                                                        }
                                                    }else{
                                                        echo "<span>印记:</span>" .$v[ 'goodstxt' ][ 'yj_body' ];
                                                    }

                                                }else{
                                                    if( $v[ 'goodstxt' ][ 'yj_body' ] ){
                                                        echo "<span>印记:</span><img class='yj_img' src='".$v[ 'goodstxt' ][ 'yj_body' ]."'>";
                                                    }else{
                                                        echo "<span>印记:</span>";
                                                    }
                                                }
                                            ?>
                                        </td>
                                    </tr>

                                </table>
                                <?php
                            }
                        ?>

                        <!--裸石-->
                        <?php
                            if ( $v[ 'carttyp' ] == 1 ) {

                                ?>

                                <table class = "layui-table" style = "font-size:.7em;width:50%;">
                                    <tr>
                                        <th width = "70" rowspan = "2" style = "text-align:center"
                                            class = "click_goods">

                                            <img src = "../images/<?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Shape' ] ?>.png"
                                                 style = "height:50px;margin-bottom:5px">


                                        </th>
                                        <td width = "50%" style = "text-align:left;padding-left:10px">
                                            <span>货号:</span><?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Ref' ] ?></td>
                                        <td style = "text-align:left">￥<b
                                                    style = "color:red"><?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Rate' ] ?></b>元
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan = "2" style = "text-align:left;padding-left:10px">
                                            <span>形状:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'cnShape' ] ?>
                                            <span>大小:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Size' ] ?>ct
                                            <span>颜色:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Color' ] ?>
                                            <span>净度:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Clarity' ] ?>
                                            <br />
                                            <span>切工:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Cut' ] ?>
                                            <span>抛光:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Polish' ] ?>
                                            <span>对称:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Sym' ] ?>
                                            <span>荧光:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Flour' ] ?>
                                        </td>
                                    </tr>

                                </table>
                                <?php
                            }

                        ?>
                        <!--定制-->
                        <?php
                            if ( $v[ 'carttyp' ] == 2 ) {
                                ?>
                                <table class = "layui-table" width = "100%" border = "0" cellspacing = "0"
                                       cellpadding = "0">
                                    <tr>
                                        <td width = "50%">

                                            <table class = "layui-table" style = "font-size:.7em;width:100%">
                                                <tr>
                                                    <th width = "70" rowspan = "2" style = "text-align:center">

                                                        <img src = "<?php if ( $v[ 'goodstxt' ][ 'best64' ] == 1 ) {
                                                            echo "http://imageserver.echao.com/imagespath";
                                                        } else {
                                                            echo "http://imageserver.echao.com";
                                                        } ?>/<?php echo $v[ 'goodstxt' ][ 'style_thumb' ] ?>"
                                                             style = "width:60px;height:60px" />
                                                    </th>
                                                    <td width = "50%" style = "text-align:left;padding-left:10px">
                                                        <span>款号:</span><?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>
                                                        <input type = "hidden" name = "style_no" value = "<?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>" >
                                                    </td>
                                                    <td>
                                                        ￥<b style = "color:red"><?php echo $v[ 'goodstxt' ][ 'Price' ] ?></b>元
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan = "2" style = "text-align:left;padding-left:10px">

                                                        <span>现托货号:</span> <?php echo $v[ 'goodstxt' ][ 'goods_no' ] ?>
                                                        <br /> <?php echo $v[ 'goodstxt' ][ 'kz' ] ?>

                                                        <span>材质:</span><?php echo $v[ 'goodstxt' ][ 'material' ] ?>
                                                        <span>镶口:</span><?php echo $v[ 'goodstxt' ][ 'S_Weight' ] ?>
                                                        <span>手寸:</span><?php echo $v[ 'goodstxt' ][ 'GoodsSize' ] ?>#
                                                        <br /><span>刻字:</span><?php echo $v[ 'goodstxt' ][ 'kz' ] ?>
                                                        <span>备注:</span><?php echo $v[ 'goodstxt' ][ 'bz' ] ?>
                                                        <br/><?php
                                                            $yj_type = $v[ 'goodstxt' ][ 'yj_type' ];
                                                            if( $yj_type == 3 || $yj_type == 4 || $yj_type == 5 ){
                                                                if( $yj_type == 3 && $v[ 'goodstxt' ][ 'yj_body' ]) {
                                                                  echo  "<span>印记:</span>";
                                                                    $arr_type = explode ( "|" , $v[ 'goodstxt' ][ 'yj_body' ] );
                                                                    $len = count($arr_type);
                                                                    for ( $i=0; $i < $len; $i++){
                                                                      echo  $ion = "  <i class='icon iconfont'>". $arr_type[$i] . "</i>";
                                                                    }
                                                                }else{
                                                                    echo "<span>印记:</span>" .$v[ 'goodstxt' ][ 'yj_body' ];
                                                                }
                                                            }else{
                                                                if( $v[ 'goodstxt' ][ 'yj_body' ] ){
                                                                    echo "<span>印记:</span><img class='yj_img' src='".$v[ 'goodstxt' ][ 'yj_body' ]."'>";
                                                                }else{
                                                                    echo "<span>印记:</span>";
                                                                }
                                                            }
                                                        ?>
                                                    </td>
                                                </tr>

                                            </table>

                                        </td>
                                        <td width = "50%">

                                            <table class = "layui-table" style = "font-size:.7em;width:100%;">
                                                <tr>
                                                    <th width = "70" rowspan = "2" style = "text-align:center"
                                                        class = "click_goods">


                                                        <img src = "../images/<?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Shape' ] ?>.png"
                                                             style = "height:50px;margin-bottom:5px">


                                                    </th>
                                                    <td width = "50%" style = "text-align:left;padding-left:10px"><span>货号:</span><?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Ref' ] ?>
                                                    </td>
                                                    <td style = "text-align:left">￥<b
                                                                style = "color:red"><?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Rate' ] ?></b>元
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan = "2" style = "text-align:left;padding-left:10px">
                                                        <span>形状:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'cnShape' ] ?>
                                                        <span>大小:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Size' ] ?>
                                                        ct
                                                        <span>颜色:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Color' ] ?>
                                                        <span>净度:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Clarity' ] ?>
                                                        <br />
                                                        <span>切工:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Cut' ] ?>
                                                        <span>抛光:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Polish' ] ?>
                                                        <span>对称:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Sym' ] ?>
                                                        <span>荧光:</span> <?php echo $v[ 'goodstxt' ][ 'diamond' ][ 'Flour' ] ?>
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
                            if ( $v[ 'carttyp' ] == 4 ) {
                                ?>
                                <table class = "layui-table otherTable"
                                       style = "font-size:.7em;width:100%; border: none;">
                                    <tr>
                                        <td width = "70" rowspan = "3" style = "text-align:center">
                                            中转圈：
                                        </td>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>款号: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'sku_no' ] ?>
                                            </div>
                                            <div>
                                                <span>款名: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'sku_name' ] ?>
                                            </div>
                                            <div>
                                                <span>款式: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'sex' ] == 'f' ? "女款" : "男款" ?>
                                            </div>
                                        </td>
                                        <td rowspan = "3">￥<span
                                                    style = "padding: 0;color: #ff0000;font-weight:bold;"><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'price' ] ?></span>元
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>材质: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'caizhi' ] ?>
                                            </div>
                                            <div>
                                                <span>指圈: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'zquan' ] ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style = "text-align:left ">
                                            <div>
                                                <span>肌理: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'jl_name' ] ?>
                                            </div>
                                            <div>
                                                <span>钻石: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'zq' ][ 'dia' ] ?>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width = "70" style = "text-align:center">
                                            边圈1：
                                        </td>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>款号: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq1' ][ 'sku_no' ] ?>
                                            </div>
                                            <div>
                                                <span>款名: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq1' ][ 'sku_name' ] ?>
                                            </div>
                                            <div>
                                                <span>材质: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq1' ][ 'caizhi' ] ?>
                                            </div>
                                        </td>
                                        <td>
                                            ￥<span style = "padding: 0;color: #ff0000;font-weight:bold;"><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq2' ][ 'price1' ] ?></span>元
                                        </td>
                                    </tr>

                                    <tr>
                                        <td width = "70" style = "text-align:center">
                                            边圈2：
                                        </td>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>款号: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq2' ][ 'sku_no' ] ?>
                                            </div>
                                            <div>
                                                <span>款名: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq2' ][ 'sku_name' ] ?>
                                            </div>
                                            <div>
                                                <span>材质: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq2' ][ 'caizhi' ] ?>
                                            </div>
                                        </td>
                                        <td>
                                            ￥<span style = "padding: 0;color: #ff0000;font-weight:bold;"><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bq2' ][ 'price1' ] ?></span>元
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width = "70" rowspan = "2" style = "text-align:center">
                                            杯底：
                                        </td>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>款号: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bd' ][ 'sku_no' ] ?>
                                            </div>
                                            <div>
                                                <span>款名: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bd' ][ 'sku_name' ] ?>
                                            </div>
                                        </td>
                                        <td rowspan = "2">￥<span
                                                    style = "padding: 0;color: #ff0000;font-weight:bold;"><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bd' ][ 'price' ] ?></span>元
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style = "text-align:left">
                                            <div>
                                                <span>材质: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bd' ][ 'caizhi' ] ?>
                                            </div>
                                            <div>
                                                <span>指圈: </span><?php echo $v[ 'goodstxt' ][ 'zdj' ][ 'bd' ][ 'sku_name' ] ?>
                                            </div>
                                        </td>
                                    </tr>
                                </table>


                                <?php
                            }
                        ?>
                        <!-- 旋转戒-->
                        <?php
                            if ( $v[ 'carttyp' ] == 3 ) {

                                if ( $v[ 'goodstxt' ][ 'G_Goods' ] ) {

                                    ?>
                                    <table class = "layui-table" style = "font-size:.7em;width:50%;float:left">
                                        <tr>
                                            <th width = "70" rowspan = "2" style = "text-align:center">


                                                <img src = "<?php if ( $v[ 'goodstxt' ][ 'best64' ] == 1 ) {
                                                    echo "http://imageserver.echao.com/imagespath";
                                                } else {
                                                    echo "http://imageserver.echao.com";
                                                } ?>/<?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'style_thumb' ] ?>"
                                                     style = "width:60px;height:60px" />
                                            </th>
                                            <td width = "50%" style = "text-align:left;padding-left:10px">
                                                <span>款号:</span><?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>
                                                <input type = "hidden" name = "style_no" value = "<?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>" >
                                            </td>
                                            <td>
                                                ￥<b style = "color:red"><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'Price' ] ?></b>元
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan = "2" style = "text-align:left;padding-left:10px">
                                                <?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'goods_name' ] ?>

                                                <span>货号:</span> <?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'goods_no' ] ?>

                                                <span>金重:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'goldWeight' ] ?>
                                                g
                                                <span>材质:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'material' ] ?>
                                                <br />
                                                <span>主石:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'StoneType' ] ?> <?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'StoneNum' ] ?>
                                                <span>颗</span> <?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'StoneWeight' ] ?>
                                                ct
                                                <span>颜色:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'Color' ] ?>
                                                <span>净度:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'Clarity' ] ?>
                                                <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'G_Goods' ][ 'style_sort' ] == 0 ) { ?>
                                                    <span>尺寸:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'GoodsSize' ] ?>#
                                                    <?php
                                                }
                                                ?>

                                                <span>副石:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'DeStoneNum' ] ?>
                                                <span>颗,</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'DeStoneWeight' ] ?>
                                                <span>ct</span> <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'G_Goods' ][ 'kz' ] ) { ?>
                                                    <span>刻字:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'kz' ] ?>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ( $v[ 'goodstxt' ][ 'G_Goods' ][ 'bz' ] ) { ?>
                                                    <span>备注:</span><?php echo $v[ 'goodstxt' ][ 'G_Goods' ][ 'bz' ] ?>
                                                    <?php
                                                }
                                                ?>
                                                <br/><?php
                                                    $yj_type = $v[ 'goodstxt' ][ 'yj_type' ];
                                                    if( $yj_type == 3 || $yj_type == 4 || $yj_type == 5 ){
                                                        if( $yj_type == 3 && $v[ 'goodstxt' ][ 'yj_body' ]) {
                                                            echo  "<span>印记:</span>";
                                                            $arr_type = explode ( "|" , $v[ 'goodstxt' ][ 'yj_body' ] );
                                                            $len = count($arr_type);
                                                            for ( $i=0; $i < $len; $i++){
                                                                echo  $ion = "  <i class='icon iconfont'>". $arr_type[$i] . "</i>";
                                                            }
                                                        }else{
                                                            echo "<span>印记:</span>" .$v[ 'goodstxt' ][ 'yj_body' ];
                                                        }
                                                    }else{
                                                        if( $v[ 'goodstxt' ][ 'yj_body' ] ){
                                                            echo "<span>印记:</span><img class='yj_img' src='".$v[ 'goodstxt' ][ 'yj_body' ]."'>";
                                                        }else{
                                                            echo "<span>印记:</span>";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>

                                    </table>

                                    <?php
                                }

                                ?>

                                <?php
                                if ( $v[ 'goodstxt' ][ 'B_Goods' ] ) {
                                    ?>
                                    <table class = "layui-table" style = "font-size:.7em;width:50%;float:left">
                                        <tr>
                                            <th width = "70" rowspan = "2" style = "text-align:center">


                                                <img src = "<?php if ( $v[ 'goodstxt' ][ 'best64' ] == 1 ) {
                                                    echo "http://imageserver.echao.com/imagespath";
                                                } else {
                                                    echo "http://imageserver.echao.com";
                                                } ?>/<?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'style_thumb' ] ?>"
                                                     style = "width:60px;height:60px" />
                                            </th>
                                            <td width = "50%" style = "text-align:left;padding-left:10px">
                                                <span>款号:</span><?php echo $v[ 'goodstxt' ][ 'style_no' ] ?></td>
                                            <td>
                                                ￥<b style = "color:red"><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'Price' ] ?></b>元
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan = "2" style = "text-align:left;padding-left:10px">
                                                <?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'goods_name' ] ?>
                                                <?php if ( $v[ 'goodstxt' ][ 'B_Goods' ][ 'goods_no' ] ) { ?>
                                                    <span>货号:</span> <?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'goods_no' ] ?>
                                                    <?php
                                                }
                                                ?>

                                                <span>金重:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'goldWeight' ] ?>
                                                g
                                                <span>材质:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'material' ] ?>
                                                <br />
                                                <span>主石:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'StoneType' ] ?> <?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'StoneNum' ] ?>
                                                <span>颗</span> <?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'StoneWeight' ] ?>
                                                ct
                                                <span>颜色:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'Color' ] ?>
                                                <span>净度:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'Clarity' ] ?>
                                                <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'B_Goods' ][ 'style_sort' ] == 0 ) { ?>
                                                    <span>尺寸:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'GoodsSize' ] ?>#
                                                    <?php
                                                }
                                                ?>
                                                <span>副石:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'DeStoneNum' ] ?>
                                                <span>颗,</span>
                                                <?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'DeStoneWeight' ] ?>
                                                <span>ct</span> <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'B_Goods' ][ 'kz' ] ) { ?>
                                                    <span>刻字:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'kz' ] ?>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ( $v[ 'goodstxt' ][ 'B_Goods' ][ 'bz' ] ) { ?>
                                                    <span>备注:</span><?php echo $v[ 'goodstxt' ][ 'B_Goods' ][ 'bz' ] ?>
                                                    <?php
                                                }
                                                ?>
                                                <br/><?php
                                                    $yj_type = $v[ 'goodstxt' ][ 'yj_type' ];
                                                    if( $yj_type == 3 || $yj_type == 4 || $yj_type == 5 ){
                                                        if( $yj_type == 3 && $v[ 'goodstxt' ][ 'yj_body' ]) {
                                                            echo  "<span>印记:</span>";
                                                            $arr_type = explode ( "|" , $v[ 'goodstxt' ][ 'yj_body' ] );
                                                            $len = count($arr_type);
                                                            for ( $i=0; $i < $len; $i++){
                                                                echo  $ion = "  <i class='icon iconfont'>". $arr_type[$i] . "</i>";
                                                            }
                                                        }else{
                                                            echo "<span>印记:</span>" .$v[ 'goodstxt' ][ 'yj_body' ];
                                                        }
                                                    }else{
                                                        if( $v[ 'goodstxt' ][ 'yj_body' ] ){
                                                            echo "<span>印记:</span><img class='yj_img' src='".$v[ 'goodstxt' ][ 'yj_body' ]."'>";
                                                        }else{
                                                            echo "<span>印记:</span>";
                                                        }
                                                    }
                                                ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <?php
                                }
                                ?>

                                <?php
                                if ( $v[ 'goodstxt' ][ 'Goods' ] ) {
                                    ?>
                                    <table class = "layui-table" style = "font-size:.7em;width:50%">
                                        <tr>
                                            <th width = "70" rowspan = "2" style = "text-align:center">
                                                <img src = "<?php if ( $v[ 'goodstxt' ][ 'best64' ] == 1 ) {
                                                    echo "http://imageserver.echao.com/imagespath";
                                                } else {
                                                    echo "http://imageserver.echao.com";
                                                } ?>/<?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'style_thumb' ] ?>"
                                                     style = "width:60px;height:60px" />
                                            </th>
                                            <td width = "50%" style = "text-align:left;padding-left:10px">
                                                <span>款号:</span><?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>
                                                <input type = "hidden" name = "style_no" value = "<?php echo $v[ 'goodstxt' ][ 'style_no' ] ?>" >
                                            </td>
                                            <td>
                                                ￥<b style = "color:red"><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'Price' ] ?></b>元
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan = "2" style = "text-align:left;padding-left:10px">
                                                <?php if ( $v[ 'goodstxt' ][ 'Goods' ][ 'goods_no' ] ) { ?>
                                                    <span>货号:</span> <?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'goods_no' ] ?>
                                                    <?php
                                                }
                                                ?>

                                                <span>金重:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'goldWeight' ] ?>
                                                g
                                                <span>材质:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'material' ] ?>
                                                <br />
                                                <span>主石:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'StoneType' ] ?> <?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'StoneNum' ] ?>
                                                <span>颗</span> <?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'StoneWeight' ] ?>
                                                ct <span>颜色:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'Color' ] ?>
                                                <span>净度:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'Clarity' ] ?>
                                                <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'Goods' ][ 'style_sort' ] == 0 ) { ?>
                                                    <span>尺寸:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'GoodsSize' ] ?>#
                                                    <?php
                                                }
                                                ?>

                                                <?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'DeStoneWeight' ] ?>

                                                <span>副石:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'DeStoneNum' ] ?>
                                                <span>颗,</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'DeStoneWeight' ] ?>
                                                <span>ct</span> <br />

                                                <?php if ( $v[ 'goodstxt' ][ 'Goods' ][ 'kz' ] ) { ?>
                                                    <span>刻字:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'kz' ] ?>
                                                    <?php
                                                }
                                                ?>
                                                <?php if ( $v[ 'goodstxt' ][ 'Goods' ][ 'bz' ] ) { ?>
                                                    <span>备注:</span><?php echo $v[ 'goodstxt' ][ 'Goods' ][ 'bz' ] ?><br/>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                    $yj_type = $v[ 'goodstxt' ][ 'yj_type' ];
                                                    if( $yj_type == 3 || $yj_type == 4 || $yj_type == 5 ){
                                                        if( $yj_type == 3 && $v[ 'goodstxt' ][ 'yj_body' ]) {
                                                            echo  "<span>印记:</span>";
                                                            $arr_type = explode ( "|" , $v[ 'goodstxt' ][ 'yj_body' ] );
                                                            $len = count($arr_type);
                                                            for ( $i=0; $i < $len; $i++){
                                                                echo  $ion = "  <i class='icon iconfont'>". $arr_type[$i] . "</i>";
                                                            }
                                                        }else{
                                                            echo "<span>印记:</span>" .$v[ 'goodstxt' ][ 'yj_body' ];
                                                        }
                                                    }else{
                                                        if( $v[ 'goodstxt' ][ 'yj_body' ] ){
                                                            echo "<span>印记:</span><img class='yj_img' src='".$v[ 'goodstxt' ][ 'yj_body' ]."'>";
                                                        }else{
                                                            echo "<span>印记:</span>";
                                                        }
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
                    <td width = "10%">￥<b class = "price"><?php echo $v[ 'rmb' ] ?></b>元</td>
                </tr>
            <?php
                }
            ?>
        <tr>
            <td colspan = "3" align = "right">共 <?php echo $rs[ 'TotalList' ] ?> 件商品，合计 ￥ <b
                        class = "price"><?php echo $rs[ 'rmb' ] ?></b> 元
                <input type = "hidden" name = "rmb" value = "<?php echo $rs[ 'rmb' ] ?>" >
            </td>
        </tr>
    </table>

<!--    --><?php
//        $types_id = $rs['type_id'];
//        if( $types_id ){
//           echo "<table width = \"100%\" class = \"layui-table\">" ;
//        if( $types_id == 1 || $types_id == 2 || $types_id == 6 ){
//           echo "<tr><td width = \"10%\" height = \"40\" style = \"text-align:center\">印记内容:</td><td style='padding-left: 50px;font-size: 24px'>".$rs['body']."</td></tr>";
//        }else{
//            echo "<tr id='img_hover'><td width = \"10%\" height = \"40\" style = \"text-align:center\">印记内容:</td>
//                        <td style='padding-left: 50px'><img  src='".$rs['body']."'><div><img  src='".$rs['body']."'></div></td>
//                  </tr>";
//        }
//           echo "</table>";
//        }
//    ?>

    <table width = "100%" class = "layui-table">
        <tr>
            <td width = "100">联系人</td>
            <td>
                <input type = "text" name = "lxr" value = "<?php echo $rs[ 'lxr' ] ?>" class = "layui-input">
            </td>
        </tr>
        <tr>
            <td width = "100">联系电话</td>
            <td><input type = "text" name = "mob" value = "<?php echo $rs[ 'mob' ] ?>" class = "layui-input"></td>
        </tr>
        <tr>
            <td width = "100">联系地址</td>
            <td>
                <input type = "text" name = "addr" value = "<?php echo $rs[ 'addr' ] ?>" class = "layui-input">
            </td>
        </tr>
        <tr>
            <td width = "100">销售门店</td>
            <td>
                <input type = "text" name = "store_number" value = "<?php echo $rs[ 'store_number' ] ?>"
                       class = "layui-input">
            </td>
        </tr>
        <tr>
            <td width = "100">销售员</td>
            <td>
                <input type = "text" name = "sales_person" value = "<?php echo $rs[ 'sales_person' ] ?>"
                       class = "layui-input">
            </td>
        </tr>
        <tr>
            <td width = "100">定金</td>
            <td>
                <input type = "text" name = "deposit" value = "<?php echo $rs[ 'deposit' ] ?>" class = "layui-input">
            </td>
        </tr>
        <tr>
            <td width = "100">订单备注</td>
            <td>
                <input type = "text" name = "remark" value = "<?php echo $rs[ 'remark' ] ?>" class = "layui-input">
            </td>
        </tr>
        <tr>
            <td colspan = "2">
                <button class = "layui-btn" lay-submit = "" lay-filter = "demo1">立即提交</button>
                <?php
                    if( $rs[ 'pay_id' ] == 5 && !$rs[ 'warranty_id' ] && !$rs[ 'warranty_this_id' ] ){
                        echo  "<button class = \"layui-btn\" lay-submit = \"\" lay-filter = \"demo2\">创建质保单</button> ";
                    }
                    if( $rs[ 'pay_id' ] == 5 && $rs[ 'warranty_id' ] && $rs[ 'warranty_this_id' ] ){
                        echo  "<a class = \"layui-btn\" href='http://weixin.echao.com/app/index.php?i=4&c=entry&order_no=".$rs[ 'order_no' ]."&shops_id=1&do=policy&m=simp_warranty' >查看质保单</a> ";
                    }
                ?>
            </td>
            </td>
        </tr>
    </table>

</form>
</table></div>

</div>
</div>
<style>
    /*表情样式*/
    @font-face {font-family: "iconfont";
        src: url('../fonts/iconfont.eot'); /* IE9*/
        src: url('../fonts/iconfont.eot#iefix') format('embedded-opentype'), /* IE6-IE8 */
        url('../fonts/iconfont.woff') format('woff'), /* chrome, firefox */
        url('../fonts/iconfont.ttf') format('truetype'), /* chrome, firefox, opera, Safari, Android, iOS 4.2+*/
        url('../fonts/iconfont.svg#iconfont') format('svg'); /* iOS 4.1- */
    }

    .iconfont {
        font-family:"iconfont" !important;
        font-size:16px;
        font-style:normal;
        -webkit-font-smoothing: antialiased;
        -webkit-text-stroke-width: 0.2px;
        -moz-osx-font-smoothing: grayscale;
    }
</style>
<script>
    layui.use(['form', 'layedit', 'laydate'], function () {
        var form = layui.form()
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
        var adminurl = "./update_order.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');
        //监听提交
        form.on('submit(demo1)', function (data) {
            $.post(adminurl, data.field, function (json) {
                if (json == 'go') {
                    layer.msg('编辑成功');
                } else {
                    layer.msg('编辑失败', function () {
                    });
                }
            });
            return false;
        });
        // 生成质保单
        form.on('submit(demo2)', function (data) {
            data.field.warranty_bool = 'warranty';
            $.post(adminurl, data.field, function (json) {
                console.log(88,json);
                if (json == 'go') {
                    layer.msg('质保单创建成功！');
                    window.location.reload();
                } else {
                    layer.msg('质保单创建失败', function () {
                    });
                }
            });
            return false;
        });

    });
</script>

</body>
</html>