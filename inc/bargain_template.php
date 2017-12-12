<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$sql = "select * from bargain_template order by id desc";

$page_get.="a=".$a;
pages($sql,$s,$page_get,12);//数据分页 每页20条


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
     body{
      min-width: 850px;
      overflow: auto;
     }
</style>

</head>
<body>
<fieldset class="layui-elem-field layui-field-title " style="margin: 20px 20px 0px 20px;">
  <legend><b>砍价活动模板</b></legend>

<table class="layui-table" lay-skin="line">
    <tr >
      <td style="border: none;text-align:left;background-color: #ffffff;"><button class="layui-btn" onclick="openpage()" >添加活动模板</button></td>
    </tr>
    <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
      <td><b>模板LOGO</b></td>
      <td><b>模板名称</b></td>
      <td><b>模板描述</b></td>
      <td><b>添加时间</b></td>
      <td><b>操作</b></td>
    </tr>
<?php

while($rs=mysql_fetch_array($results_date)) 
{

?>
    <tr align="center" >
      <td> <img src="<?=$rs['logo']?>" height='80'> </td>
      <td> <?=$rs['name']?></td>
      <td> <?=$rs['bargain_des']?></td>
      <td> <?php echo date("Y-m-d H:i:s", $rs['addtime'])?></td>
      <td> 
        <button class="layui-btn layui-btn-danger" onclick="openpage1(<?php echo $rs['id']?>)" >删除</button>
      </td>
    </tr>
<?php

}
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="12"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
  
</table> 
</fieldset>    
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>

//打开修改页面的弹出层
function  openpage(id){
   layer.config({
        extend: 'extend/layer.ext.js'
    });  
    //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
    layer.ready(function() {
    var index = layer.open({
            type: 2,
            skin: 'layui-layer-molv',
            title: '修改砍价内容',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['1000px', '700px'],
            content: 'bargain_template_add.php?id='+id
        });
    });
}


function  openpage1( id ){
  var delid = id;
  layer.confirm('确定要删除此模板吗，请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "bargain_template_del.php",
         data: "delid="+delid,
         success: function(msg){
          console.log( msg );
            if(msg  == 'go1' ){
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