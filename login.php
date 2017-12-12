<!DOCTYPE html>
<html>

<head>
    <title>珠宝定制系统</title>
    <meta name="content-type" content="text/html" charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1, user-scalable=no"/>
    <link rel="shortcut icon" href="./images/title.png">
    <link rel="stylesheet" href="./layui/css/layui.css?t=<?=time()?>"  media="all">
    <link rel="stylesheet" href="./layui/css/global.css?t=<?=time()?>" media="all">
    <script src="./layui/jquery.min.js" charset="utf-8"></script>
    <script src="./layui/layui.js" charset="utf-8"></script>
</head>

<style>

*{
    font-family: '宋体';
    box-sizing: border-box;
}
body,html{
    font-family: '宋体';
    color:#141414;
    background-color: #edf1f2;
    
}
    
html,body,div,span,applet,object,iframe,h1,h2,h3,h4,h5,h6,p,blockquote,pre,a,abbr,acronym,address,big,cite,code,del,dfn,em,img,ins,kbd,q,s,samp,small,strike,strong,sub,sup,tt,var,b,u,i,center,dl,dt,dd,ol,ul,li,fieldset,form,label,legend,time,mark,audio,video {
    margin: 0;
    padding: 0;
    border: 0;
    font-size: 100%;
    text-decoration: none;
}
li,ul{
    list-style: none;
}
.clearfix:after{
    content: " ";
    display: block;
    clear: both;
}

.banner{
    width:100%;
    height:480px;
    min-width: 1200px;
    padding-top:250px;
    overflow: hidden;
    background-image:url(./images/loginimg/dz_login_banner.png);
    background-position-x:center;
    background-position-y:center;
    background-repeat:no-repeat;
    background-size: cover;
}
.banner_logo{
    width:100%;
    text-align: center;
    color: #ffffff;
    font-size: 32px;
}
.banner_logo img{
    display: inline-block;
}

.login_main{
    width:100%;
    min-width: 1200px;
    height:285px;
    position: relative;
}
.login_info{
    position: absolute;
    width:100%;
    height:422px;
    text-align: center;
    left:0;
    bottom:0;
}
.login_info_box{
    display: inline-block;
    width:370px;
    height:100%;
    padding-top:52px;
}
.login_page{
    width:100%;
    height:100%;
    background-color: #fff;
    border-radius: 4px;
    position: relative;
    padding-top:86px;
}
.login_page_pic{
    position: absolute;
    left:0;
    top:-52px;
    width:100%;
    height:104px;
    text-align: center;
}
.login_page_pic dd{
    display: inline-block;
    width:104px;
    height:100%;
    border:2px solid #fff;
    overflow: hidden;
    border-radius: 50%;
}
.login_page_pic dd img{
    display: inline-block;
    width:100%;
}
.login_page_title{
    width:100%;
    padding:0 20px;
    line-height: 20px;
    text-align: center;
    font-size: 12px;
    margin-bottom:28px;
}
.login_input{
    width:100%;
    height:32px;
    text-align: center;
    margin-bottom:20px;
}
.login_input_box{
    display: inline-block;
    width:240px;
    height:100%;
    position: relative;
}
.login_input_box dd{
    position: absolute;
    width:36px;
    height:100%;
    left:0;
    top:0;
}
.login_input_box dd img{
    width:100%;
}
.login_input_box input{
    width:100%;
    height:100%;
    border:none;
    line-height: 32px;
    background-color: #edf1f2;
    border-radius: 4px;
    padding-left:36px;
    padding-right:10px;
    outline: none;
    font-size: 12px;
}
.login_btn{
    width:100%;
    height:32px;
    margin-top:60px;
    text-align: center;
}
.login_btn button{
    width:240px;
    height:100%;
    border-radius: 4px;
    background-color: #009688;
    color:#fff;
    font-size: 12px;
    border:none;
    outline: none;
    cursor: pointer;
}
.login_shadow{
    position: absolute;
    width:88px;
    height:120px;
    right:-88px;
    bottom:-4px;
}
.login_shadow img{
    width:100%;
    height:100%;
}

</style>

<body>

<!-- banner -->
<div class="banner">
<!--    <div class="banner_logo"><img src="./images/loginimg/dz_login_03.png" alt=""></div>-->
    <div class="banner_logo">珠 宝 定 制 系 统</div>
</div>
<form class="layui-form layui-form-pane" action="">
<!-- 内容 -->
<div class="login_main">
    <div class="login_info">
        <div class="login_info_box">
            <div class="login_page">
                <!-- <div class="login_page_pic"><dd><img src="./images/loginimg/dz_login_07.png" alt=""></dd></div> -->
                <div class="login_shadow"><img src="./images/loginimg/dz_login_shadow.png" alt=""></div>
                <div class="login_page_title">欢 迎 使 用 珠 宝 定 制 系 统</div>
                <div class="login_input">
                    <div class="login_input_box">
                        <dd><img src="./images/loginimg/dz_login_11.png" alt=""></dd>
                        <input type="text" name="username" lay-verify="required" placeholder="" autocomplete="off" class="layui-input" style='-webkit-box-shadow: 0 0 0px 1000px white inset; border: 1px solid #CCC!important;'>
                    </div>
                </div>
                <div class="login_input">
                    <div class="login_input_box">
                        <dd><img src="./images/loginimg/dz_login_14.png" alt=""></dd>
                        <input type="password" name="password"  lay-verify="required" placeholder="" autocomplete="off" class="layui-input" style='-webkit-box-shadow: 0 0 0px 1000px white inset; border: 1px solid #CCC!important;'>
                    </div>
                </div>
                <div class="login_btn">                    
                    <button  lay-submit="" lay-filter="sublogin" style='color:;'>登录</button>
              </div>
            </div>
        </div>
    </div>
</div>
</form>

 

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
            if( json == 'going' ){
                window.location='./inc/agent_details.php';
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
        }
         //console.log(json);//提交成功后返回的数据       
    });
    return false;
  });
  
  
});
</script>

    
</body>
</html>
