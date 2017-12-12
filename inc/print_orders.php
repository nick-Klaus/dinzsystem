<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

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
$sql = "select * from e_order where order_no='$order_no'";
$rs = fetchOne($sql);

?>


<!--选项卡的内容-->
<form  id='form1'>
  <!--内容1-->
<div class="layui-tab-item layui-show">

<input type="hidden" name="order_no" value="<?=$order_no?>" />

<table class="layui-table"  >
  <tr>
    <td width="15%" height="40" align='right'>订单号：</td>
    <td width="40%"><?=$rs['order_no']?></td>
    <td width="15%" align='right' >订单状态：</td>
    <td width="40%" >
    <?php 

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
    <tr>
    <td  height="40" align='right'>下单日期：</td>
    <td><?=date('Y-m-d H:i:s',$rs['times'])?></td>
    <td align='right' >支付时间：</td>
    <td><?=$rs['pay_id']?date('Y-m-d H:i:s',$rs['pay_time']):'-'?></td>
  </tr>
    <tr>
    <td  height="40" align='right'>订单金额：</td>
    <td>￥<b style="color:red"><?=$rs['rmb']?></b></td>
    <td align='right' >支付方式：</td>
    <td><?=$rs['pay_id']?date('Y-m-d H:i:s',$rs['pay_bank']):'-'?></td>
  </tr>
    <tr>
    <td  height="40" align='right'>已收款：</td>
    <td>￥<b style="color:red"><?=$rs['rmb1']?></b></td>

    <td  height="40" align='right'>应收款： </td>
    <td >￥<b style="color:red"> <?=$rs['rmb2']?></b> </td>
  </tr>
</table>
<table class="layui-table">
  <tr>
    <td style="width:5%">序号</td>
    <td style="width:45%">定制款式</td>
    <td style="width:45%">裸钻</td>
    <td style="width:5%">小计</td>

  </tr>
  <?php
$allrmb = 0;
$sql = "select * from e_order_list where order_no='".$order_no."' order by id asc";
$arr = fetchAll($sql);
for($i=0;$i<count($arr);$i++)
{

   $xjrmb = 0;
   
?>
  <tr>
    <td ><?=($i+1)?> </td>
    <td><?php
    if($arr[$i]['goodstxt'] &&  $arr[$i]['goodstxt'] != 'null')
    {     
                $goodstxt = $arr[$i]['goodstxt'];
                $goodstxt = str_replace('"{',"{",$goodstxt);
                $goodstxt = str_replace('}"',"}",$goodstxt);
                //echo $goodstxt;
                $goodstxtval = json_decode($goodstxt,1);
                //print_r($goodstxtval);
                if($goodstxtval['best64']==1) $goodstxtval['style_thumb'] = "/imagespath/".$goodstxtval['style_thumb'];
                $goodstxtval['goods_name'] = unicode_decode(str_replace('u','\u',$goodstxtval['goods_name']));
                $goodstxtval['material'] = unicode_decode(str_replace('u','\u',$goodstxtval['material']));
                $goodstxtval['StoneType'] = unicode_decode(str_replace('u','\u',$goodstxtval['StoneType']));
                $goodstxtval['Goods_txt'] = unicode_decode(str_replace('u','\u',$goodstxtval['Goods_txt']));
                //$goodstxtval['Goods_txt_bz'] = unicode_decode(str_replace('u','\u',$goodstxtval['Goods_txt_bz']));
                 //print_r($goodstxtval);
                
                //$_arr[$_i]['goodstxt'] = json_encode($goodstxtval);          
if($arr[$i]['carttyp'] == 'dz')
{
               
?>

<table class="layui-table">
  <tr>

    <td width="50" rowspan="2"><img src="http://imageserver.echao.com/<?=$goodstxtval['style_thumb']?>" style="width:100px;" /></td>
    
    <td width="100" style="text-align:right"> ￥<b style="color:red"> <?=$goodstxtval['Good_price']?></b>元</td>
  </tr>
  <tr>
    <td height="50" colspan="2" style="line-height:25px">款号:<span><?=$goodstxtval['style_no']?></span> <br/>材质:<span> <?=$goodstxtval['material']?></span> <br/>尺寸:<span><?=$goodstxtval['GoodsSize']?></span> 镶口:<span><?=$goodstxtval['MinStoneWeight']?></span> <br/> 刻字:<span><?=$goodstxtval['Goods_txt']?></span> <br/>备注: <span><?=$goodstxtval['Goods_txt_bz']?></span></td>
  </tr>
</table>

<?
     }
else
    {
            
?>
        <table class="layui-table">
          <tr>
            <td width="100" rowspan="2"><img src="http://imageserver.echao.com/<?=$goodstxtval['style_thumb']?>" style="width:100px;" /></td>
            <td width="126" height="25">款式 <?=$goodstxtval['goods_name']?> <span> <?=$goodstxtval['goods_no']?> </span></td>
            <td  style="text-align:right"> ￥<b style="color:red">  <?=$goodstxtval['Price']?> </b>元</td>
          </tr>
          <tr>
            <td height="50" colspan="2" style="line-height:25px">款号:<span>
                <?=$goodstxtval['style_no']?>
                </span> 尺寸:<span>
                <?=$goodstxtval['GoodsSize']?>
                </span> 金重:<span>
                <?=$goodstxtval['goldWeight']?>
                </span>克 <span>
                <?=$goodstxtval['material']?>
                </span> <br/>
                主石:
                <?=$goodstxtval['StoneType']?>
                <span>
                <?=$goodstxtval['StoneNum']?>
                </span>颗<span>
                <?=$goodstxtval['StoneWeight']?>
                </span>ct <span>
                <?=$goodstxtval['color']?>
                </span>
                <?=$goodstxtval['Clarity']?>
                副石:<span>
                <?=$goodstxtval['DeStoneNum']?>
                </span>颗<span>
                <?=$goodstxtval['DeStoneWeight']?>
                </span>ct
                
            </td>
          </tr>
        </table>
      <?   
      }
    
    }
    ?>    </td>
    <td><?
    //print_r($diatxt[$i]);
    //echo $diatxt[$i] == 'null';
    if($arr[$i]['diatxt'] &&  $arr[$i]['diatxt'] != 'null')
    {
                $diatxt = $arr[$i]['diatxt'];
                $diatxt = str_replace('"{',"{",$diatxt);
                $diatxt = str_replace('}"',"}",$diatxt);
                
                $diaval = json_decode($diatxt,1);
                $diaval['cnShape'] = unicode_decode(str_replace('u','\u',$diaval['cnShape']));
                //print_r($diaval);
                
       $xjrmb+=$diaval['Rate'];
    ?>
        <table width="100%" class="stock-table" style="font-size:.7em">
          <tr>
            <td width="50" rowspan="2"><img src="../images/<?=$diaval['cnShape']?$diaval['Shape']:'ROUND'?>.png" style="width:50px;height:40px" /></td>
            <td width="220" height="25"><span>
              <?=$diaval['Size']?>
              </span>ct <span>
                <?=$diaval['cnShape']?$diaval['cnShape']:$diaval['Shape']?>
              </span></td>
            <td width="200" style="text-align:right"> ￥<b style="color:red">
              <?=$diaval['Rate']?>
            </b>元</td>
          </tr>
          <tr>
            <td height="50" colspan="2" style="line-height:25px">颜色:<span>
              <?=$diaval['Color']?>
              </span>净度:<span>
                <?=$diaval['Clarity']?>
                </span> <br/>切工:<span>
                  <?=$diaval['Cut']?>
                  </span><br/>抛光:<span>
                    <?=$diaval['Polish']?>
                    </span>对称:<span>
                      <?=$diaval['Sym']?>
                      </span><br/>
              荧光:<span>
                <?=$diaval['Flour']?>
                </span> 证书:<span>
                  <?=$diaval['Cert']?>
                  证书</span><br/> 货号:<span>
                    <?=$diaval['Ref']?>
                  </span></td>
          </tr>
      </table>
      <?
    }
    ?>    </td>
      <td><b style="color:red"><?=$arr[$i]['rmb']?></b></td>

  </tr>
  <?
   $allrmb+=$arr[$i]['rmb'];
}
?>
</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td colspan="3"></td>
<td style="text-align:right"> 合计：￥ <b style="color:red"><?=$allrmb?></b> 元</td>
</tr>
</table>
<!-- </div> -->
<!--内容2-->
    <!-- <div class="layui-tab-item"> -->
    <table  class="layui-table" width="100%" border="0" cellspacing="0" cellpadding="0" class="am-table am-table-bordered">
  <tr>
    <td width="100" height="30">联系人</td>
    <td> <?=$rs['lxr']?></td>
  </tr>
  <tr>
    <td height="30">联系电话</td>
    <td><?=$rs['mob']?></td>
  </tr>
  <tr>
    <td >地址</td>
    <td><?=$rs['addr']?></td>
  </tr>
  <tr>
    <td height="30">邮箱</td>
    <td><?=$rs['email']?></td>
  </tr>
</table>
</div>
</form>
<!-- <a href="javascript:prn3_preview()" class="layui-btn" id='layui-btn'>打印订单</a> -->
<input type="button" class="noprint" value=" 打 印 "  style="width:100px;height:35px;background:#1AA094;border:none;color:#ffffff;-webkit-border-radius:3px; "  onclick="xx()">
<script type="text/javascript">

function xx(){
window.print();
}
</script>
</body>
</html>