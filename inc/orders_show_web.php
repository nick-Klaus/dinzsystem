<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>layui</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <link rel="stylesheet" href="../layui/css/layui.css"  media="all">
    <script src="../layui/jquery.min.js" charset="utf-8"></script>
    <script src="../layui/layui.js" charset="utf-8"></script>
<style>

body{
    padding:10px;
}
.stock-table span{color:#0066FF;}
</style>
</head>
<body>
 
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend><b>订单详情</b></legend>
</fieldset>    



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

<form class="layui-form"  action='./update_order.php' method="post">
<!--选项卡的内容-->
<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">订单详情</li>
    <!-- <li>收货信息</li> -->
    <li>订单处理</li>
  </ul>
  <div class="layui-tab-content">
  <!--内容1-->
<div class="layui-tab-item layui-show">

<input type="hidden" name="order_no" value="<?=$order_no?>" />
<input type="hidden" name="mac_web" value="web" >
<input type="hidden" name="id" value="<?=$rs['id']?>" >

<table class="layui-table">
  <tr>
    <td width="100" height="40" align='right'>订单号：</td>
    <td width="40%"><?=$rs['order_no']?></td>
    <td width="100" align='right' >订单状态：</td>
    <td width="40%" >
    
    <? if($rs['pay_id'] == 99){ ?>
      订单已取消
    <? }else{?>

      <input type="radio" name="pay_id" value="0" <? if($rs['pay_id']==0){echo 'checked';}?> title="待处理"  /> 
      <input type="radio" name="pay_id" value="1"  <? if($rs['pay_id']==1){echo 'checked';}?> title="已付定金" /> 

      <input type="radio" name="pay_id" value="2"  <? if($rs['pay_id']==2){echo 'checked';}?> title="确认付款" /> 
      <input type="radio" name="pay_id" value="3"  <? if($rs['pay_id']==3){echo 'checked';}?> title="确认发货" /> 
      <input type="radio" name="pay_id" value="4"  <? if($rs['pay_id']==4){echo 'checked';}?> title="确认收货" /> 
      
      <input type="radio" name="pay_id" value="5"  <? if($rs['pay_id']==5){echo 'checked';}?> title="订单完成" /> 
    <?
    }
    ?>
      </td>
  </tr>
    <tr>
    <td width="100" height="40" align='right'>下单日期：</td>
    <td><?=date('Y-m-d H:i:s',$rs['times'])?></td>
    <td align='right' >支付时间：</td>
    <td><?=$rs['pay_id']?date('Y-m-d H:i:s',$rs['pay_time']):'-'?></td>
  </tr>
    <tr>
    <td width="100" height="40" align='right'>订单金额：</td>
    <td>￥<b style="color:red"><?=$rs['rmb']?></b></td>
    <td align='right' >支付方式：</td>
    <td><?=$rs['pay_id']?date('Y-m-d H:i:s',$rs['pay_bank']):'-'?></td>
  </tr>
    <tr>
    <td width="100" height="40" align='right'>已收款：</td>
    <td>￥<b style="color:red"><?=$rs['rmb1']?></b></td>

    <td width="100" height="40" align='right'>应收款：</td>
    <td >
      <label class="layui-form-label">￥</label>
      <div class="layui-input-inline" >
        <input type="number" name="rmb2" value='<?=$rs['rmb2']?>'  lay-verify="number" autocomplete="off" class="layui-input">
      </div>
   </td>
  </tr>
</table>
<table class="layui-table">
  <tr>
    <td style="width:5%">序号</td>
    <td style="width:40%">款式</td>
    <td style="width:40%">钻石</td>
    <td style="width:10%">小计</td>

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
    <td><?=($i+1)?>    </td>
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
  <tr  >

    <td width="50" rowspan="2"><img src="http://imageserver.echao.com/<?=$goodstxtval['style_thumb']?>" style="width:100px;" /></td>
    <td width="126" height="25">定制款式</td>
    <td  style="text-align:right"> ￥<b style="color:red"> <?=$goodstxtval['Good_price']?></b>元</td>
  </tr>
  <tr>
    <td height="50" colspan="2" style="line-height:25px">款号:<span><?=$goodstxtval['style_no']?></span> 材质:<span> <?=$goodstxtval['material']?></span> 尺寸:<span><?=$goodstxtval['GoodsSize']?></span> 镶口:<span><?=$goodstxtval['MinStoneWeight']?></span> <br/> 刻字:<span><?=$goodstxtval['Goods_txt']?></span> 备注: <span><?=$goodstxtval['Goods_txt_bz']?></span></td>
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
            <td width="100" rowspan="2"><img src="../images/<?=$diaval['cnShape']?$diaval['Shape']:'ROUND'?>.png" style="width:50px;height:40px" /></td>
            <td width="126" height="25"><span>
              <?=$diaval['Size']?>
              </span>ct <span>
                <?=$diaval['cnShape']?$diaval['cnShape']:$diaval['Shape']?>
              </span>裸钻</td>
            <td   style="text-align:right"> ￥<b style="color:red">
              <?=$diaval['Rate']?>
            </b>元</td>
          </tr>
          <tr>
            <td height="50" colspan="2" style="line-height:25px">颜色:<span>
              <?=$diaval['Color']?>
              </span> 净度:<span>
                <?=$diaval['Clarity']?>
                </span> 切工:<span>
                  <?=$diaval['Cut']?>
                  </span> 抛光:<span>
                    <?=$diaval['Polish']?>
                    </span> 对称:<span>
                      <?=$diaval['Sym']?>
                      </span><br/>
              荧光:<span>
                <?=$diaval['Flour']?>
                </span> 证书:<span>
                  <?=$diaval['Cert']?>
                  证书</span> 货号:<span>
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
  <table  width="100%" class="layui-table">
<tr>
<td width="100">联系人 </td><td> <input type="text" name="lxr" value="<?php echo $rs['lxr']?>" class="layui-input"></td>
</tr>
<tr>
<td width="100">联系电话 </td><td><input type="text" name="mob" value="<?php echo $rs['mob']?>" class="layui-input"></td>
</tr>
<tr>
<td width="100">联系地址</td><td><input type="text" name="addr" value="<?php echo $rs['addr']?>" class="layui-input"></td>
</tr>
<tr>
<td width="100">销售门店 </td><td><input type="text" name="sales_person" value="<?php echo $rs['sales_person']?>" class="layui-input"></td>
</tr>
<tr>
<td width="100">销售员 </td><td><input type="text" name="store_number" value="<?php echo $rs['store_number']?>" class="layui-input"></td>
</tr>
<tr>
<td width="100">定金 </td><td><input type="text" name="deposit" value="<?php echo $rs['deposit']?>" class="layui-input"></td>
</tr>
   
<tr>
<td colspan="2"><button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button> </td></td>
</tr>
</table>
</form>
 </div> 
<!--内容3-->
<div class="layui-tab-item">
<table width="70%" border="0" cellspacing="0" cellpadding="0" class="am-table am-table-bordered">
<form action='./add_order_log.php'  method='post'>
<input type="hidden" name="order_no" value="<?=$order_no?>" />
<input type="hidden" name="logty" value="0" />
<input type="hidden" name="logtyname" value="admin" />
<tr>
  <td >    
<?
$sql = "select * from e_order_log where order_no='$order_no' order by id asc";
$arr = fetchAll($sql);
for($i=0;$i<count($arr);$i++)
{
   if($arr[$i]['logty']==0)
   {
      echo '<div style="color:#000;border-bottom:#ddd 1px solid;margin:10px;text-align:left">
        '.$arr[$i]['diatxt'].' <br>('.$arr[$i]['logtyname'].' '.date('Y-m-d H:i:s',$arr[$i]['times']).')
      </div>';
   }
   else
   {
        echo '<div style="color:#f60;border-bottom:#ddd 1px solid;margin:10px;text-align:right">
        '.$arr[$i]['diatxt'].' <br>('.$arr[$i]['logtyname'].' '.date('Y-m-d H:i:s',$arr[$i]['times']).')
      </div>';
   }
}
       ?>
</td>
</tr>
<tr><td>
    <textarea placeholder="请输入内容" class="layui-textarea" name="diatxt" ></textarea>
    </td>
</tr>
<tr >
   <td><button class="layui-btn"  type='submit' >立即提交</button></td>
</tr>
</form>  
</table></div>
   
  </div>
</div>

<script>
layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="pro_orders.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
//自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 5){
        return '此项为必填项！';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });
  
});


layui.use('element', function(){
  var $ = layui.jquery
  ,element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块
  
  //触发事件
  var active = {
    tabAdd: function(){
      //新增一个Tab项
      element.tabAdd('demo', {
        title: '新选项'+ (Math.random()*1000|0) //用于演示
        ,content: '内容'+ (Math.random()*1000|0)
      })
    }
    ,tabChange: function(){
      //切换到指定Tab项
      element.tabChange('demo', 1); //切换到第2项（注意序号是从0开始计算）
    }
  };
  
  $('.site-demo-active').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});




</script>

</body>
</html>