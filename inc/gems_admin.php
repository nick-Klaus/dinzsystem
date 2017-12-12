<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];  
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
     tr:hover{ 
        background:#ABB0C1;
     }
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
  <legend><b>彩宝管理</b></legend>

<table class="layui-table">
<tr style='background:#ffffff;' ><td colspan="11" style='border:none;' ><a  onclick='openpage()'  class="layui-btn" ><i class="layui-icon"></i>彩宝添加</a></td></tr>

<?php
$sql = "select * from e_gems ";
if($uid > 1){
  $sql.="  where adduid='$uid'";
}
$page_get.="&a=".$a."&cls1=".$cls1."&cls2=".$cls2."&cls3=".$cls3."&keys=".$keys;
pages($sql,$s,$page_get,10);

?>
  <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td><b>货号</b></td>
  <td><b>图片</b></td>
  <td><b>材质</b></td>
  <td><b>形状</b></td>
  <td><b>定制类型</b></td>
  <td><b>等级</b></td>
  <td><b>重量(ct)</b></td>
  <td><b>规格</b></td>
  <td><b>价格</b></td>
  <td><b>备注</b></td>
  <td width='200' ><b>操作</b></td>
  
</tr>
  
<?php

while($rs=mysql_fetch_array($results_date)) 
{

?>

<tr align="center">
  <td><?=$rs['Ref']?></td>
  <td><img src="http://imageserver.echao.com/<?=$rs['pic']?>" style='width:70px;height:70px;'></td>
  <td><?=$rs['category']?></td>
  <td ><?=$rs['Shape']?></td>
  <td> <?=$rs['style']?> </td>
  <td><?=$rs['Grade']?></td>
  <td><?=$rs['Size']?></td>
  <td> <?=$rs['spe']?> </td>
  <td><?=$rs['Rate']?></td>
  <td><?=$rs['Bz']?></td>
  <td width="40"><a  class="layui-btn"  onclick="openpage2( <?=$rs['id']?> )" title='编辑' ><i class="layui-icon"></i></a><a  class="layui-btn layui-btn-danger" onclick='openpage3(<?php echo $rs['id'] ?>)'  title='删除' ><i class="layui-icon"></i></a></td>
</tr>
<?php
}
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="11"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>
//打开增加页面的弹出层
function  openpage(){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '彩宝添加',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '550px'],
                content: 'add_gems.php'
            });
        });
}

//打开编辑页面的弹出层
function  openpage2( id ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '彩宝编辑',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '550px'],
                content: 'edit_gems.php?editid='+id
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
         url: "del_gems.php",
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