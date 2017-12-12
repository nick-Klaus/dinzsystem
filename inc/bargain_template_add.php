
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
  <legend><b>砍价信息</b></legend>
</fieldset>

<form class="layui-form" action="">
<table class="layui-table">

     <tr>
        <td height="35" align="right" width="200">Logo图：</td>
  
        <td>
      <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
     <img src="" id='imgurl' style="width:100%;height:100%">
    </div> 
     <input type="hidden" name="logo" id="style_thumb"  placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="">
     <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style="margin-top:10px;" >点击选图</button>
       </td>
      </tr>

    <tr >
    <td height="35" align="right" width="200">模板名称：</td>
    <td><input name="name" type="text" id="uid" value=""  placeholder="模板名称"  class="layui-input" /></td>
    </tr>
 
    <tr>
    <td height="35" align="right" width="200">演示链接：</td>
    <td><input name="list_url" type="text"  value="" placeholder="演示链接" autocomplete="off" class="layui-input" /></td>
    </tr>

    <tr>
    <td height="35" align="right" width="200">制作链接：</td>
    <td><input name="add_url" type="text"  value="" placeholder="制作链接" autocomplete="off" class="layui-input" /></td>
    </tr>
    <tr>
    <td height="35" align="right" width="200">模板描述：</td>
    <td><textarea class="layui-textarea"  name="bargain_des" ></textarea></td>
    </tr>

      <tr>
        <td  width="200">&nbsp;</td>
        <td height="24" align="left"><button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button></td>
      </tr>
</form>
    
</table>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="bargain_template_updatepro.php";

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
        input.value = 'http://imageserver.echao.com/uploadfile/'+src;
        layer.close(index);       
    }
  });

//监听提交
form.on('submit(demo1)', function(data){
    console.log(data);
    $.post(adminurl,data.field,function( json ){
       console.log(json);
        if( json == 'go' ){
            layer.msg('添加成功');
            //关闭子页面
            parent.location.reload();
        }else{
            layer.msg('添加失败', function(){
            });
        }
    });
    return false;
});
});

</script>

</body>
</html>