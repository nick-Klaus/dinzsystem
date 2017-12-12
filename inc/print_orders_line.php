<?php
include "./../fun/eby_admin_api.php";

$order_no = $_GET['order_no'];
$sql = "select s.*,f.mac_logo from e_mac_code f left join  e_order_mac s  on f.id=s.macid  where order_no='$order_no'";
$rs = fetchOne($sql);
$arr = json_decode($rs['cartlist'],true);

?>

<!DOCTYPE html>
<html>

<head>
    <title>销售订单</title>
    <meta name="content-type" content="text/html" charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1, user-scalable=no"/>

    
</head>

<style>

*{
    font-family: '微软雅黑';
    box-sizing: border-box;
}
body,html{
    font-family: '微软雅黑';
    color:#000;
    background-color: #fff;
    
}
    
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,time,mark,audio,video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    text-decoration: none;
}
li,ul{
    list-style: none;
}
.clearfix:after{
    content: " ";
    display: block;
    clear: both;
}

.main{
    width:2480px;
    background-color: #fff;
}
/* 头部 */
.head{
    width:100%;
    height:420px;
    
    padding:31px 60px 0;
}
.head_left{
    float:left;
    width:360px;
    height:100%;
}
.head_left img{
    width:100%;
}
.head_middle{
    float:left;
    width:700px;
    height:100%;
    margin-left:50px;
    padding-top:46px;
}
.head_middle img{
    width:100%;
}
.head_right{
    float:right;
    width:480px;
    height:100%;
    padding-top:50px;
}
.head_right dd{
    width:100%;
    line-height: 88px;
    font-size: 34px;
}

.orderNum{
    width:100%;
    height:180px;
    border:2px solid #c5c5c5;
    padding:21px 60px 0 120px;
}
.order_num{
    float:left;
    width:448px;
    height:100%;
}
.order_num dd{
    width:100%;
    height:60px;
    line-height: 60px;
    font-size: 36px;
}
.order_num dt{
    width:100%;
    height:70px;
    line-height: 70px;
    font-size: 36px;
    
}
.customer{
    width:100%;
    height:200px;
    padding:65px 60px 0;
}
.customer_pic{
    float:left;
    width:180px;
    height:100%;
    margin:0 146px 0 55px;
}
.customer_pic img{
    width:100%;
}
.customer_name{
    float:left;
    width:424px;
    height:100%;
}
.customer_name dd{
    float:left;
    width:34px;
    height:100%;
    margin:19px 30px 0 0;
}
.customer_name dd img{
    width:100%;
}
.customer_name dt{
    float:left;
    height:100%;
    font-size: 34px;
    line-height: 70px;
}
.shop{
    width:100%;
}
.shop_head{
    width:100%;
    height:100px;
    border-top:2px solid #c5c5c5;
    border-bottom:2px solid #c5c5c5;
    font-size: 34px;
    line-height: 96px;
    text-align: center;
}
.shop_head_left{
    float:left;
    width:322px;
    height:100%;
}
.shop_head_middle{
    float:left;
    width:1678px;
    height:100%;
}
.shop_head_right{
    float:left;
    width:480px;
    height:100%;
}
.shop_main{
    width:100%;
}
.shop_info{
    width:100%;
    height:281px;
    border-bottom:1px solid #c5c5c5;
    padding:20px 0;
    overflow: hidden;
}
.shop_info_left{
    float:left;
    width:322px;
    height:100%;
    font-size: 34px;
    line-height: 240px;
    text-align: center;
}
.shop_info_middle{
    float:left;
    width:1678px;
    height:100%;
    color:#222222;
    padding:0 18px;
}
.shop_info_right{
    float:left;
    width:480px;
    height:100%;
    padding:0 20px;
    color:#222222;
    text-align: center;
    font-size: 32px;
    line-height: 240px;
}
.shop_detail{
    float:left;
    width:720px;
    height:100%;
    font-size: 22px;
    position: relative;
}
.shop_detail_pic{
    position: absolute;
    left:0;
    top:0;
    width:240px;
    height:100%;
}
.shop_detail_pic img{
    width:100%;
}
ul.shop_detail_text{
    position: absolute;
    right:0;
    top:0;
    width:480px;
    height:100%;
    padding:11px 0 0 30px;
}
ul.shop_detail_text li{
    width:100%;
    line-height: 42px;
}
.shop_detail_icon{
    float:left;
    width:40px;
    height:100%;
    padding-top:100px;
    margin:0 80px;
}
.shop_detail_icon img{
    width:100%;
}
.foot{
    width:100%;
    padding:0 60px;
    color:#222222;
}
.foot_total{
    float:right;
    line-height: 200px;
    position: relative;
    font-size: 38px;
}
.foot_total span{
    font-size: 40px;
    color:#e40000;

}
.foot_name{
    position: absolute;
    left:0;
    top:222px;
    line-height: 56px;
}

</style>

<body>
    
<div class="main">

<!-- 头部 -->
<div class="head clearfix">
    <div class="head_left"><img src="http://imageserver.echao.com<?php echo $rs['mac_logo'] ?>" alt=""></div>
    <div class="head_middle"><img src="../layui/img/print_06.png" alt=""></div>
    <div class="head_right">
        <dd>销售员：<?php echo $rs['store_number']?></dd>
        <dd>销售门店：<?php echo $rs['sales_person']?></dd>
        <dd>电话：<?php echo $rs['mob']?></dd>
    </div>
</div>

<!-- 订单号 -->
<div class="orderNum clearfix">
    <div class="order_num">
        <dd>订单号：</dd>
        <dt><?php echo $rs['order_no']?></dt>
    </div>
    <div class="order_num" style="width:600px;">
        <dd>下单时间：</dd>
        <dt><?php echo date("Y-m-d H:i:s",$rs['times']) ?></dt>
    </div>
    <div class="order_num" style="width:460px;">
        <dd>订单总额：</dd>
        <dt>￥<?php echo $rs['rmb']?>元</dt>
    </div>
    <div class="order_num" style="width:460px;">
        <dd>应付定金：</dd>
        <dt>￥<?php echo $rs['deposit']?>元</dt>
    </div>
    <div class="order_num" style="width:320px;">
        <dd>订单状态：</dd>
        <dt><?php 

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

    ?></dt>
    </div>
</div>

<!-- 客户资料 -->
<div class="customer clearfix">
    <div class="customer_pic"><img src="../layui/img/print_11.png" alt=""></div>
    <div class="customer_name">
        <dd><img src="../layui/img/print_19.png" alt=""></dd>
        <dt><?php echo $rs['lxr']?></dt>
    </div>
    <div class="customer_name" style="width:514px">
        <dd style="width:18px;margin-right:36px"><img src="../layui/img/print_14.png" alt=""></dd>
        <dt><?php echo $rs['mob']?></dt>
    </div>
    <div class="customer_name" style="width:1040px">
        <dd style="width:27px;margin-right:32px"><img src="../layui/img/print_16.png" alt=""></dd>
        <dt style="padding-top:14px;line-height:44px;width:900px;"><?php echo $rs['addr']?></dt>
    </div>
</div>

<!-- 商品 -->
<div class="shop">
    <div class="shop_head clearfix">
        <div class="shop_head_left">序号</div>
        <div class="shop_head_middle">商品</div>
        <div class="shop_head_right">价格</div>
    </div>
  <?php
   
      $array = is_array($arr['cartlist'])?$arr['cartlist']:array();
      foreach ($array as $k => $v) {
        if( !$i ){
          $i=0;
        }
    ?>   
    <div class="shop_main">
  <?php  

  if( $v['carttyp'] == 0  ){

  ?>
        <div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['style_thumb'] ?>" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>款号：<?php  echo $v['goodstxt']['style_no'] ?></li>
                        <li>现托货号：<?php  echo $v['goodstxt']['goods_no'] ?></li>
                        <li>材质：<?php  echo $v['goodstxt']['material'] ?> 镶口：<?php  echo $v['goodstxt']['S_Weight'] ?> 手寸：<?php  echo $v['goodstxt']['GoodsSize'] ?>#</li>
                        <li>刻字：<?php  echo $v['goodstxt']['kz'] ?> 备注：<?php  echo $v['goodstxt']['bz'] ?></li>
                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['Price'] ?></span> 元</li>
                    </ul>
                </div>                
            </div>
             <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div> 
        </div>
  <?php
  }
  
  ?>

<?php  
      if( $v['carttyp'] == 1  ){
      
  ?>

        <div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="../layui/img/line_page.png" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>货号：<?php  echo $v['goodstxt']['diamond']['Ref'] ?></li>
                        <li>形状：<?php  echo $v['goodstxt']['diamond']['cnShape'] ?> 大小：<?php  echo $v['goodstxt']['diamond']['Size'] ?>ct</li>
                        <li>颜色：<?php  echo $v['goodstxt']['diamond']['Color'] ?> 净度：<?php  echo $v['goodstxt']['diamond']['Clarity'] ?></li>
                        <li>切工：<?php  echo $v['goodstxt']['diamond']['Cut'] ?> 抛光：<?php  echo $v['goodstxt']['diamond']['Polish'] ?> 对称：<?php  echo $v['goodstxt']['diamond']['Sym'] ?></li>
                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['diamond']['Rate'] ?></span> 元</li>
                    </ul>
                </div>
            </div>
            <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div>
        </div>

<?php
  }
  
  ?>


 <?php  
      if( $v['carttyp'] == 2  ){

  ?> 

<div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['style_thumb'] ?>" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>款号：<?php  echo $v['goodstxt']['style_no'] ?></li>
                        <li>现托货号：<?php  echo $v['goodstxt']['goods_no'] ?></li>
                        <li>材质：<?php  echo $v['goodstxt']['material'] ?> 镶口：<?php  echo $v['goodstxt']['S_Weight'] ?> 手寸：<?php  echo $v['goodstxt']['GoodsSize'] ?>#</li>
                        <li>刻字：<?php  echo $v['goodstxt']['kz'] ?> 备注：<?php  echo $v['goodstxt']['bz'] ?></li>
                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['Price'] ?></span> 元</li>
                    </ul>
                </div>
                <div class="shop_detail_icon"><img src="../layui/img/print_32.png" alt=""></div>
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="../layui/img/line_page.png" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>货号：<?php  echo $v['goodstxt']['diamond']['Ref'] ?></li>
                        <li>形状：<?php  echo $v['goodstxt']['diamond']['cnShape'] ?> 大小：<?php  echo $v['goodstxt']['diamond']['Size'] ?>ct</li>
                        <li>颜色：<?php  echo $v['goodstxt']['diamond']['Color'] ?> 净度：<?php  echo $v['goodstxt']['diamond']['Clarity'] ?></li>
                        <li>切工：<?php  echo $v['goodstxt']['diamond']['Cut'] ?> 抛光：<?php  echo $v['goodstxt']['diamond']['Polish'] ?> 对称：<?php  echo $v['goodstxt']['diamond']['Sym'] ?></li>
                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['diamond']['Rate'] ?></span> 元</li>
                    </ul>
                </div>
            </div>
            <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div>
        </div>

<?php
  }
  
  ?>


  <?php  
   if( $v['carttyp'] == 3  ){
      
     if( $v['goodstxt']['G_Goods'] ){
     
  ?>

 <div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['G_Goods']['style_thumb'] ?>" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>款号：<?php  echo $v['goodstxt']['style_no'] ?></li>
                        <li>货号：<?php  echo $v['goodstxt']['G_Goods']['goods_no'] ?></li>
                        <li>材质：<?php  echo $v['goodstxt']['G_Goods']['material'] ?> 金重：<?php  echo $v['goodstxt']['G_Goods']['goldWeight'] ?>g 尺寸：<?php echo $v['goodstxt']['G_Goods']['GoodsSize'] ?>#</li>
                        <li>主石：<?php  echo $v['goodstxt']['G_Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['G_Goods']['StoneNum'] ?>颗 <?php  echo $v['goodstxt']['G_Goods']['StoneWeight'] ?>ct 颜色:<?php  echo $v['goodstxt']['G_Goods']['Color'] ?> 净度:<?php  echo $v['goodstxt']['G_Goods']['Clarity'] ?></li>
                        <li>副石:<?php  echo $v['goodstxt']['G_Goods']['DeStoneNum'] ?>颗,<?php  echo $v['goodstxt']['G_Goods']['DeStoneWeight'] ?>ct</li>

                       <li> <?php  if( $v['goodstxt']['G_Goods']['kz'] ){    ?> 
                           刻字:<?php  echo $v['goodstxt']['G_Goods']['kz'] ?>
                            <?php
                            }
                            ?>
                           <?php  if( $v['goodstxt']['G_Goods']['bz'] ){    ?> 
                           备注:<?php  echo $v['goodstxt']['G_Goods']['bz'] ?>
                           <?php
                            }
                            ?>  </li>   

                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['G_Goods']['Price'] ?></span> 元</li>
                    </ul>
                </div>
               
            </div>
             <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div> 
        </div>
<?php

}

?>

 <?php  

     if( $v['goodstxt']['B_Goods'] ){   
  ?> 

<div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['B_Goods']['style_thumb'] ?>" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>款号：<?php  echo $v['goodstxt']['style_no'] ?></li>
                        <li>货号：<?php  echo $v['goodstxt']['B_Goods']['goods_no'] ?></li>
                        <li>材质：<?php  echo $v['goodstxt']['B_Goods']['material'] ?> 金重：<?php  echo $v['goodstxt']['B_Goods']['goldWeight'] ?>g 尺寸：<?php echo $v['goodstxt']['B_Goods']['GoodsSize'] ?>#</li>
                        <li>主石：<?php  echo $v['goodstxt']['B_Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['B_Goods']['StoneNum'] ?>颗 <?php  echo $v['goodstxt']['B_Goods']['StoneWeight'] ?>ct 颜色:<?php  echo $v['goodstxt']['B_Goods']['Color'] ?> 净度:<?php  echo $v['goodstxt']['B_Goods']['Clarity'] ?></li>
                        <li>副石:<?php  echo $v['goodstxt']['B_Goods']['DeStoneNum'] ?>颗,<?php  echo $v['goodstxt']['B_Goods']['DeStoneWeight'] ?>ct</li>

                       <li> <?php  if( $v['goodstxt']['B_Goods']['kz'] ){    ?> 
                           刻字:<?php  echo $v['goodstxt']['B_Goods']['kz'] ?>
                            <?php
                            }
                            ?>
                           <?php  if( $v['goodstxt']['B_Goods']['bz'] ){    ?> 
                           备注:<?php  echo $v['goodstxt']['B_Goods']['bz'] ?>
                           <?php
                            }
                            ?>  </li>   

                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['B_Goods']['Price'] ?></span> 元</li>
                    </ul>
                </div>              
            </div>
             <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div> 
        </div>
<?php

}

?>
   <?php  

     if( $v['goodstxt']['Goods'] ){
     
  ?>  
<div class="shop_info clearfix">
            <div class="shop_info_left"><?php echo $i+=1; ?></div>
            <div class="shop_info_middle clearfix">
                <div class="shop_detail">
                    <div class="shop_detail_pic"><img src="<?php if( $v['goodstxt']['best64'] == 1 ){echo  "http://imageserver.echao.com/imagespath"; }else{ echo "http://imageserver.echao.com"; } ?>/<?php  echo $v['goodstxt']['Goods']['style_thumb'] ?>" alt=""></div>
                    <ul class="shop_detail_text">
                        <li>款号：<?php  echo $v['goodstxt']['style_no'] ?></li>
                        <li>货号：<?php  echo $v['goodstxt']['Goods']['goods_no'] ?></li>
                        <li>材质：<?php  echo $v['goodstxt']['Goods']['material'] ?> 金重：<?php  echo $v['goodstxt']['Goods']['goldWeight'] ?>g 尺寸：<?php echo $v['goodstxt']['Goods']['GoodsSize'] ?>#</li>
                        <li>主石：<?php  echo $v['goodstxt']['Goods']['StoneType'] ?> <?php  echo $v['goodstxt']['Goods']['StoneNum'] ?>颗 <?php  echo $v['goodstxt']['Goods']['StoneWeight'] ?>ct 颜色:<?php  echo $v['goodstxt']['Goods']['Color'] ?> 净度:<?php  echo $v['goodstxt']['Goods']['Clarity'] ?></li>
                        <li>副石:<?php  echo $v['goodstxt']['Goods']['DeStoneNum'] ?>颗,<?php  echo $v['goodstxt']['Goods']['DeStoneWeight'] ?>ct</li>

                       <li> <?php  if( $v['goodstxt']['Goods']['kz'] ){    ?> 
                           刻字:<?php  echo $v['goodstxt']['Goods']['kz'] ?>
                            <?php
                            }
                            ?>
                           <?php  if( $v['goodstxt']['Goods']['bz'] ){    ?> 
                           备注:<?php  echo $v['goodstxt']['Goods']['bz'] ?>
                           <?php
                            }
                            ?>  </li>   

                        <li style="margin-top:12px">￥ <span style="color:#e40000;font-size:26px;"><?php  echo $v['goodstxt']['Goods']['Price'] ?></span> 元</li>
                    </ul>
                </div>
               
            </div>
             <div class="shop_info_right">￥<?php echo $v['rmb']  ?>元</div> 
        </div>
<?php

}

?>

<!-- carttyp = 3结束括号 -->
<?php

}

?>
     <!-- foreach循环结束括号 -->
    <?php
      }
    ?>
</div>

<div class="foot">
    <div class="foot_total">
    共 <span><?php echo $rs['TotalList']?></span> 件商品　　　合计 ￥<span><?php echo $rs['rmb']?></span> 元
    <div class="foot_name">签字确认：</div>
    </div>
</div>
</div>
</body>
</html>
