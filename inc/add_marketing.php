<?php
include "./../fun/eby_admin_api.php";

$adduid = $_GET['uid'];
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
  <legend><b>添加营销配置</b></legend>
</fieldset>

<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">标题：</label>
    <div class="layui-input-block">
      <input type="text" name="service_tit" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
      <input type="hidden" name="adduid" value="<?php echo $adduid ?>">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">图片：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl' style="height:100px;width:100px;" src="../images/timg.jpg">
    </div>
      <input type="hidden" name="service_logo" id="style_thumb"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;" >
      <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：415*737）</button>
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">URL：</label>
    <div class="layui-input-block">
      <input type="text" name="service_url" lay-verify="user_bz" autocomplete="off" placeholder="请输入URL" class="layui-input">
    </div>
  </div>  
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">说明：</label>
    <div class="layui-input-block">
<!--      <textarea placeholder="请输入具体内容" name='introduce' class="layui-textarea"></textarea>-->
        <textarea class="layui-textarea layui-hide" name="introduce" lay-verify="content" id="LAY_demo_editor"></textarea>
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
  var adminurl="./addpro_marketing.php";
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
        content: './pic.php',//iframe的url
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


 //监听提交
   form.on('submit(demo1)', function(data){
    //console.log(data);
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