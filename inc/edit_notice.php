<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$editid = $_GET['editid'];
$sql = "select * from e_admin_notice where id='$editid'";
$res = fetchOne( $sql );


if( $res['mac_id'] ){
  $arr = json_decode($res['mac_id'],true);
  $str = implode(",",$arr);
}else{
  $str = 0;
}

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
  <legend><b>添加新公告</b></legend>
</fieldset>

<form class="layui-form" action="">
  <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
  <div class="layui-form-item">
    <label class="layui-form-label">公告标题：</label>
    <div class="layui-input-block">
      <input type="text" name="title" lay-verify="title" autocomplete="off" value="<?php echo $res['title'] ?>" placeholder="请输入公告标题" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">注意事项：</label>
    <div class="layui-input-block">
      <input type="text" name="warning" lay-verify="title" autocomplete="off" value="<?php echo $res['warning'] ?>" placeholder="请输入公告注意事项" class="layui-input">
    </div>
  </div>

  <div class="layui-form-item">
    <label class="layui-form-label">设备id：</label>
    <div class="layui-input-block" style="height:40px;line-height: 40px;">
      <input type="text" name="mac_id"  value="<?php echo  $str ?>" placeholder="请输入设备id" class="layui-input" style="width:400px;float:left;">
      <span  style="color:#009E94">（0为所有设备,多个设备用","隔开）</span>
    </div>

  </div>

  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">公告内容：</label>
    <div class="layui-input-block">
      <textarea class="layui-textarea layui-hide" name="content"  lay-verify="content" id="LAY_demo_editor"><?php echo $res['content'] ?></textarea>
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
    var adminurl="./editpro_notice.php";
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
        //console.log(json);
        if( json == 'go' ){
          layer.msg('编辑成功！');
          //关闭子页面
          parent.location.reload();
        }else{
          layer.msg('编辑失败!', function(){
          });
        }
      });
      return false;
    });
  });

</script>

</body>
</html>