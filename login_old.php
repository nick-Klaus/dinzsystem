<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>定制系统</title>
<meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="apple-mobile-web-app-status-bar-style" content="black"> 
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="format-detection" content="telephone=no">
  <link rel="shortcut icon" href="./images/title.png">
  <link rel="stylesheet" href="./layui/css/layui.css?t=<?=time()?>"  media="all">
  <link rel="stylesheet" href="./layui/css/global.css?t=<?=time()?>" media="all">
   <script src="./layui/jquery.min.js" charset="utf-8"></script>
  <script src="./layui/layui.js" charset="utf-8"></script>
  
</head>
<body>
<div style="height:30px;width:100%;text-align:right">
  
   <span class="tiptext" style="width:30px;height:30px;background:#F00"></span>
  
</div>

<div class="layui-layout layui-layout-login">


	<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
	  <legend>管理登录</legend>
    </fieldset>
	
	<div class="login_f">
		<form class="layui-form layui-form-pane" action="">
		<div class="layui-form-item">
		<label class="layui-form-label">帐号</label>
		<div class="layui-input-inline">
		  <input type="text" name="username" lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-form-mid layui-word-aux"></div>
	  </div>
	  
	  <div class="layui-form-item">
		<label class="layui-form-label">密码</label>
		<div class="layui-input-inline">
		  <input type="password" name="password"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input">
		</div>
		<div class="layui-form-mid layui-word-aux"></div>
	  </div>
	  
	  <div class="layui-form-item">
		  <button class="layui-btn layui-btn-big layui-btn-primary layui-btn-radius tip" lay-submit="" lay-filter="sublogin">提交登入</button>
	  </div>
	  
	  </form>
  </div>

</div>

<script src="./layui/global.js" charset="utf-8"></script>
<script>
layui.use(['form'], function(){
  var form = layui.form();
  var adminurl="./../inc/login_check.php";
  var tips = '';
  //监听提交
  form.on('submit(sublogin)', function(data){
	//console.log(data.field);//提交的数据
	var index = layer.load(0, {shade: false});
	$.post(adminurl,data.field,function(json){
        if(json == 'go'){
           window.location='./default.php';
        }else{
            layer.confirm('用户名或者密码错误！', {
              btn: ['确认'] //按钮
            }, function(){
              layer.msg('请确认后再次输入！', {
                time: 1000, //0.1s后自动关闭
              });
            });
            layer.close(index);//关闭动画效果  
        } 
         //console.log(json);//提交成功后返回的数据	    
	});
    return false;
  });
  
  
});
</script>

</body>
</html>