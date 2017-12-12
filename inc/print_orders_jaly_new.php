<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>-</title>
    <meta name="content-type" content="text/html" charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1, user-scalable=no"/>   
</head>

<style>

*{font-family: '微软雅黑';box-sizing: border-box;}
body,html{font-family: '微软雅黑';color:#000;background-color: #fff;}
    
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,time,mark,audio,video {margin: 0;padding: 0;border: 0;font-size: 100%;text-decoration: none;}
li,ul{list-style: none;}
.clearfix:after{content: " ";display: block;clear: both;}
.main{width:2480px;background-color: #fff;padding:0 20px;height:3580px;position: relative;}
.table{word-break:break-all; word-wrap:break-all;}
/* 头部 */
.head_img{width:100%;}
.head_img img{width:100%;}
.head_title{width:100%;height:230px;text-align: center;line-height: 230px;font-size: 60px;}
.head_main{width:100%;margin-bottom:20px;}
.head_line{float:left;width:50%;height:100px;line-height: 100px;font-size: 46px;position: relative;}
.head_line dd{position: absolute;width:980px;height:100%;border-bottom:2px solid #000;left:230px;bottom:15px;}
.head_line span{padding-left:20px;}
.main_one{width:100%;margin-bottom:10px;}
table.table{width:100%;font-size: 46px;}
table.table tr td{vertical-align: middle;padding:15px 30px;}
.main_two{width:100%;margin-bottom:10px;}
.main_three{width:100%;margin-bottom:50px;}
.foot{width:100%;}
.foot_box{width:100%;height:200px;}
span.checkbox{display: inline-block;width:40px;height:40px;border:2px solid #000;text-align: center;line-height: 36px;font-size: 38px;font-weight: bold;color:#fff;}
span.checkbox.active{color:#000;}
span.line{padding:0 40px;}
.box{width:100%;height:200px;background-color: #000;}
.foot_img{position: absolute;left:0;bottom:0;width:100%;padding:0 20px;}
.foot_img img{width:100%;}

</style>

<body>

<script type="text/javascript">
// 直接执行谷歌浏览器打印
window.print();

</script>


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


<div class="main">
    <!-- 头部 -->
    <div class="head_img"><img src="../images/img/head.png" alt=""></div>
    <div class="head_title">金嘉利钻石定制APP客户订单</div>
    <div class="head_main clearfix">
        <div class="head_line"><dd></dd>店　　名：<span><?=$rs['store_number']?></span></div>
        <div class="head_line"><dd></dd>联系电话：<span><?=$rs['mob']?></span></div>
        <div class="head_line"><dd></dd>定制单号：<span><?=$rs['order_no']?></span></div>
        <div class="head_line"><dd></dd>下单日期：<span><?=date('Y-m-d H:i:s',$rs['times'])?></span></div>
    </div>
    <div class="main_one">
        <table class="table" border="1" borderColor="#000" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="6" align="center">一、客 户 信 息</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td width="14%" align="center">姓　　名</td>
                    <td width="19.333%"><?=$rs['lxr']?></td>
                    <td width="14%" align="center">手　　机</td>
                    <td width="19.333%"><?=$rs['mob']?></td>
                    <td width="14%" align="center">座　　机</td>
                    <td width="19.333%"></td>
                </tr>
                <tr>
                    <td width="14%" align="center">客户地址</td>
                    <td colspan="5"><?=$rs['addr']?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="main_two">
        <table class="table" border="1" borderColor="#000" cellspacing="0">
            <tbody>
                <tr>
                    <td colspan="8" align="center">二、订 购 信 息</td>
                </tr>
            </tbody>

    <?php
        $allrmb = 0;
        $sql = "select * from e_order_list where order_no='".$order_no."' order by id asc";
        $arr = fetchAll($sql);

        for($i=0;$i<count($arr);$i++)
        {

        $xjrmb = 0;

    if($arr[$i]['goodstxt'] &&  $arr[$i]['goodstxt'] != 'null')
    {     
        $goodstxt = $arr[$i]['goodstxt'];
        $goodstxt = str_replace('"{',"{",$goodstxt);
        $goodstxt = str_replace('}"',"}",$goodstxt);
        $goodstxtval = json_decode($goodstxt,1);
        if($goodstxtval['best64']==1) $goodstxtval['style_thumb'] = "/imagespath/".$goodstxtval['style_thumb'];
        $goodstxtval['goods_name'] = unicode_decode(str_replace('u','\u',$goodstxtval['goods_name']));
        $goodstxtval['material'] = unicode_decode(str_replace('u','\u',$goodstxtval['material']));
        $goodstxtval['StoneType'] = unicode_decode(str_replace('u','\u',$goodstxtval['StoneType']));
        $goodstxtval['Goods_txt'] = unicode_decode(str_replace('u','\u',$goodstxtval['Goods_txt']));
                      
    if($arr[$i]['carttyp'] == 'dz')
{
      
    ?>

    <tr>
        <td colspan="8">款号信息</td>
    </tr>
    <tr>
        <td align="center">款　　号</td>
        <td colspan="3"><?=$goodstxtval['style_no']?></td>
        <td align="center">材　　质</td>
        <td><?=$goodstxtval['material']?></td>
        <td align="center">手　　寸</td>
        <td><?=$goodstxtval['GoodsSize']?></td>
    </tr>
    <tr>
        <td align="center">刻字内容</td>
        <td colspan="2"><?=$goodstxtval['Goods_txt']?></td>
        <td align="center">备　　注</td>
        <td colspan="4"><?=$goodstxtval['Goods_txt_bz']?></td>
    </tr>
    <tr>
        <td align="center">应收金额</td>
        <td><?=$goodstxtval['_Good_price']?></td>
        <td align="center">实售金额</td>
        <td><?=$goodstxtval['Good_price']?></td>
        <td colspan="4" align="center">
            <span class="line">开 票 <span class="checkbox"></span></span>
            <span class="line">不 开 票 <span class="checkbox"></span></span>
        </td>
    </tr>
           
    <?php
     }else{

    ?>
        <tr>
            <td colspan="8">款号信息</td>
        </tr>
        <tr>
            <td align="center">款　　号</td>
            <td colspan="3"><?=$goodstxtval['style_no']?></td>
            <td align="center">材　　质</td>
            <td><?=$goodstxtval['material']?></td>
            <td align="center">手　　寸</td>
            <td><?=$goodstxtval['GoodsSize']?></td>
        </tr>
        <tr>
            <td align="center">刻字内容</td>
            <td colspan="2"><?=$goodstxtval['Goods_txt']?></td>
            <td align="center">备　　注</td>
            <td colspan="4"><?=$goodstxtval['Goods_txt_bz']?></td>
        </tr>
        <tr>
            <td align="center">应收金额</td>
            <td><?=$goodstxtval['_Price']?></td>
            <td align="center">实售金额</td>
            <td><?=$goodstxtval['Price']?></td>
            <td colspan="4" align="center">
                <span class="line">开 票 <span class="checkbox"></span></span>
                <span class="line">不 开 票 <span class="checkbox"></span></span>
            </td>
        </tr>

     <?php   
    }
        
        }

    if($arr[$i]['diatxt'] &&  $arr[$i]['diatxt'] != 'null')
    {
        $diatxt = $arr[$i]['diatxt'];
        $diatxt = str_replace('"{',"{",$diatxt);
        $diatxt = str_replace('}"',"}",$diatxt);
        
        $diaval = json_decode($diatxt,1);
        $diaval['cnShape'] = unicode_decode(str_replace('u','\u',$diaval['cnShape']));
       $xjrmb+=$diaval['Rate'];
    ?>

       
        <tr>
            <td colspan="8">裸石信息</td>
        </tr>
        <tr>
            <td width="12%" align="center">颜　　色</td>
            <td width="13%"><?=$diaval['Color']?></td>
            <td width="12%" align="center">净　　度</td>
            <td width="13%"><?=$diaval['Clarity']?></td>
            <td width="12%" align="center">切　　工</td>
            <td width="13%"><?=$diaval['Cut']?></td>
            <td width="12%" align="center">重　　量</td>
            <td width="13%"><?=$diaval['Size']?>ct</td>
        </tr>
        <tr>
            <td align="center">裸石标价</td>
            <td><?=$diaval['_Rate']?></td>
            <td align="center">裸石售价</td>
            <td><?=$diaval['Rate']?></td>
            <td align="center">货　　号</td>
            <td colspan="3"><?=$diaval['Ref']?></td>
        </tr>
  <?
   }
    } 
  ?>  

        </table>
    </div>

    <div class="main_three">
        <table class="table" border="1" borderColor="#000" cellspacing="0">
            <thead>
                <tr>
                    <td colspan="6" align="center">三、付 款 信 息</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td align="center">合计金额</td>
                    <td colspan="2"></td>
                    <td align="center">实售金额</td>
                    <td colspan="2">
                        
                    </td>
                </tr>
                <tr>
                    <td align="center">已付定金</td>
                    <td></td>
                    <td align="center">余　　款</td>
                    <td></td>
                    <td colspan="2" align="center">
                        <span class="line">已 付 <span class="checkbox"></span></span>
                        <span class="line">未 付 <span class="checkbox"></span></span>
                    </td>
                </tr> 
                <tr>
                    <td align="center" colspan="2">现 金 <span class="checkbox active"></span></td>
                    <td align="center">刷 卡 <span class="checkbox"></span></td>
                    <td align="center">转 账 <span class="checkbox"></span></td>
                    <td align="center" colspan="2">购 物 卡 <span class="checkbox"></span></td>
                </tr>
                <tr>
                    <td align="center">票　　据</td>
                    <td></td>
                    <td align="center">需店内取</td>
                    <td></td>
                    <td align="center">需邮寄</td>
                    <td></td>
                </tr>           
                <tr>
                    <td width="16%" align="center">确认订单已下</td>
                    <td width="14%"></td>
                    <td width="18%" align="center">公司下单时间</td>
                    <td width="20%"></td>
                    <td width="12%" align="center">收货日期</td>
                    <td width="20%"></td>
                </tr>
            </tbody>


        </table>
    </div>

    <div class="foot">
        <table class="table" border="1" borderColor="#000" cellspacing="0">
            <tr>
                <td width="12%" align="center">订单确认</td>
                <td width="13%"></td>
                <td width="12%" align="center">财　　务</td>
                <td width="13%"></td>
                <td width="12%" align="center">下单确认</td>
                <td width="13%"></td>
                <td width="12%" align="center">质　　检</td>
                <td width="13%"></td>
            </tr>
        </table>
    </div>

    <div class="foot_img"><img src="../images/img/foot.png" alt=""></div>

</div>


</body>




</html>
