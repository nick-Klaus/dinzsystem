<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$sql = "select * from e_goods_list where style_no='$style_no'";
$sql.= " order by id asc";
$style_no =  $_GET['style_no'];
$style_name =  $_GET['style_name'];
$adduid =  $_SESSION['uid'];
//款号保存在SESSION中
$_SESSION['style_no'] = $style_no;
$_SESSION['style_name'] = $style_name;
$page_get.="&style_no=".$style_no;
pages($sql,$s,$page_get,30);

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

<style>

     .frist_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
    .up_page{
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
    .next_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }

    .end_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
        margin-right:15px;
     }
     .end_page:hover{
        color:#ffffff;
     }
     .next_page:hover{
        color:#ffffff;
     }
     .up_page:hover{
        color:#ffffff;
     }
     .frist_page:hover{
        color:#ffffff;
     }

     #this_page{
             display:inline-block;
        height:30px;
        line-height:30px;
        width:30px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>添加库存</b></legend>


<table class="layui-table">
<tr style='background:#ffffff;' >
<td colspan="5" style="text-align:left;border:none;">
款号：<a href="Javascript: void(0)"> <?=$style_no?></a>　　款名：<a href="Javascript: void(0)"> <?=$style_name?></a>
</td>

<td   style="border:none;width:400px;">
<?php

echo '<a class="layui-btn" onclick="openpage(  '.$adduid.',1 )"><i class="layui-icon"></i>现货成品</a>';
if( $_GET['cls2'] != 3 ){echo '<a class="layui-btn" onclick="openpage(  '.$adduid.',2 )"><i class="layui-icon"></i>现货空托</a>'; }
echo '<a class="layui-btn" onclick="openpage(  '.$adduid.',3 )"><i class="layui-icon"></i>情侣戒参数</a>';

?>


</td>
</tr>
<tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td><b>类别</b></td>
  <td><b>货号</b></td>
  <td><b>主石参数</b></td>
  <td><b>空托参数</b></td>
  <td><b>成本价</b></td>
  <td><b>操作</b></td>
</tr>
  
<?php

while($rs=mysql_fetch_array($results_date)) 
{

?>
<tr align='center'>
<td><?php  if( $rs['goods_type'] == 1 ){ echo "<font color='#1AA094'><b>现货成品</b></font>";  }elseif( $rs['goods_type'] == 2 ){ echo "<font color='#FF6838'><b>现货空托</b></font>"; }elseif( $rs['goods_type'] == 3 ){ echo "<font color='#FF6838'><b>款式参数</b></font>"; }  ?></td>
<td><?=$rs['goods_no']?></td>
<td style="width:600px;" align="left">
<table><tr style='background:#ffffff;'><td style='width:95px;border:none;font-size:12px;'>形状: <?php echo $rs['StoneType']?></td><td style='width:80px;border:none;font-size:12px;'>重量:<?=$rs['StoneWeight']?></td>
<?php if( $rs['goods_type'] == 1 ){ 
echo "<td style='width:70px;border:none;font-size:12px;'>颜色: ".$rs['Color']."</td><td style='width:80px;border:none;'>净度: ".$rs['Clarity']."</td>";
 }?>
<td style='width:120px;border:none;font-size:12px;'>副石数量:<?=$rs['DeStoneNum']?></td><td style='width:100px;border:none;font-size:12px;'>副石重量:<?=$rs['DeStoneWeight']?></td></tr></table>
</td>　
<td style="line-height:14px;font-size:12px;width:350px;" >
<table><tr><td style='width:70px;border:none;font-size:12px;'>材质:<?=$rs['material']  ?></td>  <td style='width:80px;border:none;font-size:12px;'>金重:<?=$rs['goldWeight']?></td>  <td style='width:100px;border:none;font-size:12px;'>尺寸:<?=$rs['GoodsSize']?></td>  <!--  <td style='width:80px;border:none;font-size:12px;'> 镶口:<?=$rs['StoneWeight']?>ct<br/> </td> --> </tr></table>
</td>
<td><?=$rs['Price']?></td>
<td><a  onclick='openpage2("<?=$rs['id']?>","<?=$rs['goods_type']?>")' title='编辑' class="layui-btn" ><i class="layui-icon"></i></a>
<a  class="layui-btn layui-btn-danger" onclick='openpage3(<?php echo $rs['id'] ?>)'  title='删除' ><i class="layui-icon"></i></a></td>
</tr>

<?php
}

?>

<tr align='center' style=' background:#ffffff;'>
  <td colspan="6"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>
//打开增加页面的弹出层
function  openpage( adduid,goods_type ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加库存',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1100px', '850px'],
                content: 'add_goods.php?adduid='+adduid+'&goods_type='+goods_type
            });
        });
}


//打开编辑页面的弹出层
function  openpage2( id, goods_type ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑库存',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '780px'],
                content: 'edit_goods.php?editid='+id+'&goods_type='+goods_type
            });
        });
}
//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('您确定要删除本条数据吗？数据无价！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_goods.php",
         data: "delid="+delid,
         success: function(msg){
            if(msg  == 'go' ){
                layer.msg('删除成功', {  time: 1000,  });
                 window.location.reload();
            }else{
                layer.msg('删除失败', {  time: 1000,  });
            }
         }
      });
  }, function(){
  });
}


</script>
</body>
</html>