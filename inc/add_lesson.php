<?php
include "./../fun/eby_admin_api.php";

$sql = "select id,stu_name  from e_user_stu where stu_type='0' and adduid=".$_SESSION['uid'];
$res = fetchAll( $sql );

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
  <legend><b>添加课程专题</b></legend>
</fieldset>

<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">标题：</label>
    <div class="layui-input-block">
      <input type="text" name="stu_name" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input">
<!--      <input type="hidden" name="stu_type" value="--><?php // echo $_GET['stu_type']; ?><!--">-->
        <input type="hidden" name="error" value="<?php if( !is_array($res) ){ echo 'yes'; } ?>">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">缩略图：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl' style="height:100px;width:100px;" src="">
    </div>
      <input type="hidden" name="stu_logo" id="style_thumb"   placeholder="点击上传图片" class="layui-input"   style="width:300px;" >
      <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：350*350）</button>
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">视频地址：</label>
    <div class="layui-input-block">
      <input type="text" name="video_url" lay-verify="user_bz" autocomplete="off" placeholder="请输入视频地址" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">课程项目：</label>
    <div class="layui-input-block">
      <select name="stu_type" lay-filter="aihao">  
    <?php
      if( is_array($res) ){
          foreach ($res as $k => $v) {
              echo  "<option value=".$v['id'].">".$v['stu_name']."</option>";
          }
      }else{
          echo  "<option value=''>您没有任何项目可选择，请先添加课程项目！</option>";
      }

    ?>
      </select>
    </div>
  </div>
   <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">说明：</label>
    <div class="layui-input-block">
      <textarea  name='stu_txt'  placeholder="请输入内容" class="layui-textarea"></textarea>
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
  var adminurl="./addpro_lesson.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 3){
        return '标题至少得3个字符';
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
        }else if( json == 'error' ){
            layer.msg('您没有任何课程项目，请先添加！', function(){
            });
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