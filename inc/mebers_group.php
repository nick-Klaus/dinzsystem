<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$sql = "select * from e_fx_group where adduid=".$c_uid;
$page_get.="&a=".$a;
pages($sql,$s,$page_get,10);//数据分页 每页20条

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
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>会员组管理</b></legend>
  
<table class="layui-table">
  <tr  style=' background:#ffffff;'>
      <td colspan="6" style="border:none;"><a  id="openpage" onclick="openpage()"  class="layui-btn"><i class="layui-icon"></i> 添加组别</a>
      </td>
</tr>
    <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
      <td><b>id</b></td>
      <td><b>会员组名称</b></td>
      <td><b>添加id</b></td>
      <td><b>添加时间</b></td>
      <td><b>备注</b></td>
      <td><b>折扣</b></td>
      <td><b>操作</b></td>
    </tr>
 
<?php

while($rs=mysql_fetch_array($results_date)) 
{
  
?>
    <tr align="center">
      <td><?php echo $rs['id'] ?></td>
      <td><?php echo $rs['group_name'] ?></td>
      <td><?php echo $rs['adduid'] ?></td>
      <td><?php echo  date("Y-m-d H:i:s", $rs['addtime'])  ?></td>
      <td><?php echo $rs['remark'] ?></td>
      <td><a  class="layui-btn" onclick="openpage2(<?=$rs['id']?>)"  >倍率</a></td>
      <td><a  class="layui-btn"  onclick="openpage1( <?=$rs['id']?> )" ><i class="layui-icon"></i></a><a class="layui-btn layui-btn-danger" onclick="openpage3( <?=$rs['id']?> )"  ><i class="layui-icon"></i></a></td>
    </tr>
<?php
}
?> 
<tr align='center' style=' background:#ffffff;'>
  <td colspan="7"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table> 

</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_admin.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 3){
        return '帐号至少得3个字符';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });

 //监听提交
   form.on('submit(demo1)', function(data){
    //console.log(data);
    $.post(adminurl,data.field,function( json ){
        if( json == 'go' ){
            layer.msg('增加成功');
            //关闭子页面
            parent.location.reload();  
        }else{
            layer.msg('增加失败,上级id不能为0', function(){  
            });  
        }   
    });
    return false;
  }); 
});

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
                title: '添加组别',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '750px'],
                content: 'add_member_group.php'
            });
        });
}

//打开编辑页面的弹出层
function  openpage1( editid ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑组别',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '700px'],
                content: 'edit_member_group.php?editid='+editid
            });
        });
}

//打开折扣页面的弹出层
function  openpage2( group_id ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '本组折扣',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '700px'],
                content: 'group_zk.php?group_id='+group_id
            });
        });
}


//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('与之对应的所有会员都将删除，请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_member_group.php",
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