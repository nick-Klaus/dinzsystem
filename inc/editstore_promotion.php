<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$sql = "select * from e_mac_service where id=".$_GET['uid'];
$row = fetchOne( $sql );

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
              
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend><b>编辑促销</b></legend>
</fieldset>

<form class="layui-form" action="">
<input type="hidden" name="id" value='<?php  echo $row['id'] ?>'>
  <div class="layui-form-item">
    <label class="layui-form-label">标题：</label>
    <div class="layui-input-block">
      <input type="text" name="service_tit" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input"  value='<?php  echo $row['service_tit'] ?>'>
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">logo图片：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl' style="height:100px;width:100px;" src="http://imageserver.echao.com/<?php  echo $row['service_logo'] ?>">
    </div>
      <input type="hidden" name="service_logo" id="style_thumb"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;" value='<?php  echo $row['service_logo'] ?>'  >
      <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：414*735）</button>
    </div>
  </div>

    <div class="layui-form-item">
    <label class="layui-form-label">界面图片：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl_1' style="height:100px;width:100px;" src="http://imageserver.echao.com/<?php  echo $row['service_page'] ?>">
    </div>
      <input type="hidden" name="service_page" id="style_thumb_1"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;" value='<?php  echo $row['service_page'] ?>'  >
      <button type="button" id="style_thumb_1_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：414*735）</button>
    </div>
  </div>

    <div class="layui-form-item">
    <label class="layui-form-label">URL：</label>
    <div class="layui-input-block">
      <input type="text" name="service_url" lay-verify="user_bz" autocomplete="off" placeholder="请输入URL" class="layui-input" value='<?php  echo urldecode($row['service_url']) ?>'  >   
    </div>
  </div>  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">说明：</label>
    <div class="layui-input-block">
        <textarea class="layui-textarea layui-hide" name="introduce" lay-verify="content" id="LAY_demo_editor"><?php  echo $row['introduce'] ?></textarea>
    </div>
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
  var adminurl="./editpro_marketing.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 2){
        return '标题至少得2个字符';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });


 //点击出现弹出层
   $('#style_thumb_cl').on('click',function(){      
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
        img.src='http://imageserver.echao.com/uploadfile/'+src;
        input.value = '/uploadfile/'+src;
        layer.close(index);       
    }
  });

 //点击出现弹出层
   $('#style_thumb_1_cl').on('click',function(){      
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
        var img=document.getElementById('imgurl_1');
        var input=document.getElementById('style_thumb_1');
        img.src='http://imageserver.echao.com/uploadfile/'+src;
        input.value = '/uploadfile/'+src;
        layer.close(index);       
    }
  });   


 //监听提交
   form.on('submit(demo1)', function(data){
    //console.log(data);
    $.post(adminurl,data.field,function( json ){
        console.log(json);
        if( json == 'go' ){
            layer.msg('编辑成功');
            //关闭子页面
            parent.location.reload();  
        }else{
            layer.msg('编辑失败', function(){  
            });  
        }   
    });
    return false;
  }); 
});

</script>

</body>
</html>