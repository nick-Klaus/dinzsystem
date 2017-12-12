<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$stu_id = $_GET['stu_id'];  
$sql = "select * from  e_user_stu_list  where id=".$stu_id;
$res = fetchOne( $sql );
$json = json_decode($res['thumb_url'],true);
$json = empty($json)?array():$json;

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
  <legend><b>编辑课程</b></legend>
</fieldset>

<form class="layui-form" action="">
<input type='hidden' name='id' value="<?php  echo $res['id']?>">
  <div class="layui-form-item">
    <label class="layui-form-label">课程标题：</label>
    <div class="layui-input-block">
      <input type="text" name="stu_tit" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input" value="<?php  echo $res['stu_tit']?>" >
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">缩略图：</label>
    <div class="layui-input-block">
    <div style="height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
       <img  id='imgurl' style="height:100px;width:100px;" src="http://imageserver.echao.com/<?php  echo $res['stu_pic']?>">
    </div>
      <input type="hidden" name="stu_pic" id="style_thumb"  lay-verify="required" readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"   style="width:300px;"  value="<?php  echo $res['stu_pic']?>">
      <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：280*140）</button>
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">课程类型</label>
    <div class="layui-input-block">
      <input type="radio" name="stu_type" value="0" title="幻灯片" <?php  if($res['stu_type'] == 0){ echo  'checked';} ?> >
      <input type="radio" name="stu_type" value="1" title="视频" <?php  if($res['stu_type'] == 1){ echo  'checked';} ?>  >
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">视频地址：</label>
    <div class="layui-input-block">
      <input type="text"   name="video_url" lay-verify="user_bz" autocomplete="off" placeholder="请输入视频地址" class="layui-input"  value="<?php  echo $res['video_url']?>" >
    </div>
  </div>

    <div class="layui-form-item" >
    <label class="layui-form-label">幻灯地址：</label>
    <div class="layui-input-block"  >
     <input type="hidden" id="pages" name="thumb_url" lay-verify="user_bz"  readonly="1" autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"  value="<?php  echo implode(",",$json);?>" >
     <button type="button" id="pages_cl" class="layui-btn layui-btn-radius" >点击选图（上传多张图片可重复点击，尺寸：1920*1231）</button>
    <div id='pageall'>
    <?php 

    //$arr=explode(',',$res['thumb_url']);
    $arr = json_decode($res['thumb_url'],true);
    $arr = empty($arr)?array():$arr; 

    foreach ($arr as $key => $value) {
       echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com".$value."' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>" ;
    }

       //echo "<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='../images/"+src+"' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>" 
    ?> 
     </div>
    </div>
  </div>

   <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">说明：</label>
    <div class="layui-input-block">
      <textarea  name='stu_txt'    placeholder="请输入内容" class="layui-textarea"><?php  echo $res['stu_txt']?></textarea>
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
var inputObj = document.getElementById('pages');
var mycars = inputObj.value.split(",");//表单内原有的图片地址变为数组
var parentObj = document.getElementById('pageall');
var chil1 = parentObj.getElementsByTagName("div");
function delpage(){
    for (var i = 0; i < chil1.length; i++) {
         chil1[i].index = i;
        chil1[i].onclick=function(){
            var j = this.index;
            parentObj.removeChild(chil1[j]);//清除点击当前的图片
            mycars.splice(j,1);//清除图片地址在数组中的位置
            inputObj.value=mycars.join(",");//从新把数组符给表单
        };
    }  
}

layui.use(['form', 'layedit', 'laydate'], function(){
  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./editpro_lesson_list.php";
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

 //点击添加多张图片
 
   $('#pages_cl').on('click',function(){      
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
       // var img=document.getElementById('imgurl');
      var input=document.getElementById('pages');
       // img.src='../images/'+src;
       mycars.push('/uploadfile/'+src);
        input.value = mycars;

       $("#pageall").append("<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/uploadfile/"+src+"' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>");
        layer.close(index);       
    }
  });
   
 //监听提交
   form.on('submit(demo1)', function(data){
    //console.log(data);
    $.post(adminurl,data.field,function( json ){
        //console.log(json);
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