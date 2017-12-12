<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

if( $_SESSION['uid'] ){
    $uid = $_SESSION['uid'];
    $sql = "select categorytype from e_members where uid='$uid'";
    $categorytype = fetchOne($sql)['categorytype'];
}else{
    $uid = 1;
}
//找出当前登录用户的倍率信息
if($categorytype == 1){
    $sql = "select id,catename,webid,pid,adduid,box_default_ico from e_goods_category where pid=0 and adduid = '$uid'  order by times desc ";
}else{
    $sql = "select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where pid=0 and adduid='$uid' order by times desc ";
}
$area = fetchAll($sql);  
$area = isset($area)?$area:array();


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

body{
    padding:10px;
}

</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin:20px 0px 40px 0px;">
  <legend><b>添加产品分类</b></legend>
</fieldset>
<h2 ></h2>
<form class="layui-form" action="">
  <input type="hidden" name="uid" value="<?php echo $uid ?>">
  <div class="layui-form-item">
    <label class="layui-form-label">分类名：</label>
    <div class="layui-input-block">
      <input type="text" name="catename" lay-verify="title" autocomplete="off" placeholder="请输入分类名" class="layui-input">
    </div>
  </div>
   
   <div class="layui-form-item" style='height:42px;line-height:42px;'>
    <label class="layui-form-label">上级分类：</label>
    <div class="layui-input-inline" >
      <select name="pid">
        <option value="">请选分类</option>
        <option value="0">新增顶级分类</option>
    <?php
    foreach ($area as $v) {
    ?>
            <option value="<?php  echo $v['id'] ?>"><?php  echo $v['catename'] ?></option>
    <?php

    }
    ?>
      </select>
     
    </div>
    <br/>

    </div>
     <div style='color:#019F95;margin-left: 30px;height: 40px;'>（*若是添加“顶级分类”，则无须选择上级分类，若添加“子分类”，则选择相对应的“上级分类”*）
     </div>
  <div class="layui-form-item">
    <div class="layui-input-block">
      <button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button>
    </div>
  </div>
</form>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_category.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 2){
        return '请输入2位以上分类名！';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });


 //点击出现弹出层
   $('#style_thumb').on('click',function(){      
     var index = layer.open({
        type: 2,
        title: '我的图片库',
        shadeClose: true,
        shade: 0.8,
        area: ['65%', '70%'],
        content: '../../inc/pic.php',//iframe的url
    });
     //抓取子窗口img的src，加入父窗口中
    window.top.document.image = function(src){ 
        var img=document.getElementById('imgurl');
        var input=document.getElementById('style_thumb');
        img.src='../images/'+src;
        input.value = '../images/'+src;
        layer.close(index);       
    }
  });


 //监听提交
   form.on('submit(demo1)', function(data){
    console.log(data);
    $.post(adminurl,data.field,function( json ){
        console.log(json);
        if( json == 'go' ){
            layer.msg('增加成功');
            //关闭子页面
            parent.location.reload();  
        }else{
            layer.msg('增加失败', function(){  
            });  
        }   
    });
    return false;
  }); 
});

</script>

</body>
</html>