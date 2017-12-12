<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$adduid = $_SESSION['uid'];
$sql= "select * from  e_user_zt where id=".$_GET['id'];
$res = fetchOne($sql);

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
  <legend><b>编辑专题</b></legend>
</fieldset>

<form class="layui-form" action="">
<input type="hidden" name="id" value='<?php echo $res['id'] ?>' >
  <div class="layui-form-item">
    <label class="layui-form-label">专题名：</label>
    <div class="layui-input-block">
      <input type="text" name="zt_name" lay-verify="title" autocomplete="off" placeholder="请输入专题名" class="layui-input" value="<?php echo $res['zt_name'] ?>" >
    </div>
  </div>
    <div class="layui-form-item"> 
    <label class="layui-form-label">缩略图：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl' style="height:100px;width:100px;" src="<?php
           if( $res['zt_logo'] ){
               echo "http://imageserver.echao.com/".$res['zt_logo'];
           }else{
              echo "../images/timg.jpg";
           }
       ?>">
    </div>
      <input type="hidden" name="zt_logo" id="style_thumb"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="<?php echo $res['zt_logo'] ?>" >
      <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" >点击选图（尺寸：384*216）</button>
    </div>
  </div>

    <div class="layui-form-item"> 
    <label class="layui-form-label">横幅图：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='benner' style="height:100px;width:100px;" src="<?php
           if( $res['zt_benner'] ){
               echo "http://imageserver.echao.com/".$res['zt_benner'];
           }else{
              echo "../images/timg.jpg";
           }
       ?>">
    </div>
      <input type="hidden" name="zt_benner" id="zt_benner"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="<?php echo $res['zt_benner'] ?>" >
      <button type="button" id="zt_benner_cl" class="layui-btn layui-btn-radius" >点击选图（尺寸：1920*1080）</button>
    </div>
  </div>
    <div class="layui-form-item">
        <label class="layui-form-label">专题类别：</label>
        <div class="layui-input-inline">
            <select name="zt_type">
            <option value=""></option>
                <?php
                $sql_head = "select id,zt_name from e_user_zt where  zt_type='0' and adduid=".$_SESSION['uid'];
                $row = fetchAll( $sql_head );
                $row = is_array($row)?$row:array();
                foreach($row as $k => $V  ){

                ?>
                <option value="<?php echo $V['id'] ?>" <?php if( $res['zt_type'] == $V['id'] ){echo selected; } ?> ><?php echo $V['zt_name'] ?></option>
                <?php
                }
                ?>
            </select>
        </div>
    </div>
   <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">专题说明：</label>
    <div class="layui-input-block">
    <textarea placeholder="请输入具体内容" class="layui-textarea layui-hide" name="zt_txt" lay-verify="content" id="LAY_demo_editor"><?php echo $res['zt_txt'] ?></textarea>
      <!-- <textarea placeholder="请输入内容" name='zt_txt' class="layui-textarea"><?php echo $res['zt_txt'] ?></textarea> -->
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
  var adminurl="./editpro_special.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 1){
        return '此项为必填选项';
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


 //点击出现弹出层
   $('#zt_benner_cl').on('click',function(){      
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
        var img=document.getElementById('benner');
        var input=document.getElementById('zt_benner');
        img.src='http://imageserver.echao.com/uploadfile/'+src;
        input.value = '/uploadfile/'+src;
        layer.close(index);       
    }
  });

 //监听提交
   form.on('submit(demo1)', function(data){
   console.log(data);
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