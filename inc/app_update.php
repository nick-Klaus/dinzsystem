<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid =  $_SESSION['uid'];
$sql = "select * from e_webapp_set where uid=".$uid;
$res = fetchOne( $sql );
//幻灯片图片所在的表
$sql1 = "select * from ppt_upload where adduid=".$uid." and macid='0'" ;
$res1 = fetchOne( $sql1 );
$json = json_decode($res1['url'],true);
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
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>WEBAPP设置</b></legend>

<div class="layui-tab">
  <ul class="layui-tab-title">
    <li class="layui-this">信息设置</li>
    <li>添加幻灯片</li>
    
  </ul>
  <div class="layui-tab-content">
  <!-- 信息设置 -->
    <div class="layui-tab-item layui-show">
      <form class="layui-form" action="">
<table class="layui-table" lay-skin="line">
    <tbody>
    <input type="hidden" name="id" value="<?php echo $res['id'] ?>">
    <input type="hidden" name="uid" value="<?php echo $res['uid'] ?>">

     <tr>
        <td height="35" align="right" width="200">品牌名：</td>
        <td width="587"><input name="app_tit" type="text" lay-verify="title" autocomplete="off" placeholder="请输入品牌名" class="layui-input" value="<?php echo $res['app_tit'] ?>"/>         </td>
        <td width="500" rowspan="7" align='center'>
        <div style='width:300px;height:300px;'>
        <?php 
        if( $uid == 19 ){
          $url = urlencode("http://j.echao.com/?webid=$uid&fpage=reg&1481528903");
            echo "<img src='http://api.echao.com/qrcode/?value={$url}' style='width:100%;'>";
        }elseif( $uid == 8 ){
            $_url = urlencode("http://e.echao.com/jumeishan.php");
            echo "<img src='http://api.echao.com/qrcode/?value={$_url}' style='width:100%;'>";
        }else{
          $_url = urlencode("http://e.echao.com/?webid=$uid&fpage=reg&1481528903");
            echo "<img src='http://api.echao.com/qrcode/?value={$_url}' style='width:100%;'>";
        }
        ?>
          

        </div>
    </td>
      </tr>
         
      <tr>
        <td height="35" align="right" width="200">Logo图：</td>
  
        <td>
       <div style="height:60px;width:100%;border:#efefef 1px solid;background:#FFF;text-align:left" >
       <img src="http://imageserver.echao.com/<?php echo $res['app_logo'] ?>"  id="imgurl" style='height:100%;' style='border:1px solid #ccc;'>
         </div>
            <!-- <input name="app_logo" type="" class="layui-input" placeholder="点击插入图片" /> -->
            <input type="hidden" name="app_logo" id="app_logo"  autocomplete="off" readonly="1" lay-verify="required"  placeholder="点击上传图片" class="layui-input" value="<?php echo $res['app_logo'] ?>" >
            <button type="button" id="app_logo_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：239*57）</button>
        </td>
      </tr>

       <tr>
        <td height="35" align="right" width="200">联系人：</td>
        <td><input name="mac_lxr" type="text" lay-verify="title" autocomplete="off" placeholder="请输入联系人" class="layui-input" value="<?php echo $res['mac_lxr'] ?>"/></td>
      </tr>
      <tr>
        <td height="35" align="right" width="200">联系电话/手机：</td>
        <td><input name="web_phone" type="text" lay-verify="title" autocomplete="off" placeholder="请输入联系电话/手机" class="layui-input" value="<?php echo $res['web_phone'] ?>" /></td>
      </tr>

<?php  

if( $uid == 1 ){
	echo "<tr>
    <td height='35' align='right' width='200'>管理员ID：</td>
    <td><input name='uid' type='text' lay-verify='title' autocomplete='off' placeholder='请输入管理员ID' class='layui-input' value='".$res['uid']."' /></td>
    </tr>";
}

?>     
      <tr>
        <td  width="200">&nbsp;</td>
        <td height="24" align="left"><button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button></td>
      </tr>
      <!-- <input type="hidden" name="thumb_url" value="<?php echo implode(",",json_decode($res['thumb_url'],true))  ?>"> -->
      <input type="hidden" name="act" value="no_ppt">
</form>
    </tbody>
</table>
    </div>
<!-- 添加幻灯片 -->

  <div class="layui-tab-item">
<form class="layui-form" action="" >


<input type="hidden" name="id" value="<?php echo $res1['id'] ?>">
<input type="hidden" name="adduid" value="<?php echo $uid ?>">
<input type="hidden" name="act" value="ppt">
<div class="layui-form-item" >
    <label class="layui-form-label">幻灯地址：</label>
    <div class="layui-input-block"  >
     <input type="hidden" id="pages" name="url" lay-verify="user_bz"  readonly="1" autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"  value="<?php echo implode(",",$json); ?>" >
     <button type="button" id="pages_cl" class="layui-btn layui-btn-radius" >点击选图（上传多张图片可重复点击，尺寸：370*168）</button>
    <div id='pageall' style='height:135px;'>
    <?php 

    $arr=json_decode($res1['url'],true);
    $arr = empty($arr)?array():$arr; 

    foreach ($arr as $key => $value) {
       echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/".$value."' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>" ;
    }

    ?> 
     </div>

    </div>
    <button class="layui-btn" lay-submit="" lay-filter="demo2">立即提交</button>
  </div>
  </form> 
  </div>  

  </div>
</div>

</fieldset>
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
  var adminurl="./app_updatepro.php";
  var adminurl1="./app_updatepro.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  // form.verify({
  //   title: function(value){
  //     if(value.length < 1){
  //       return '这是必填选项';
  //     }
  //   }
  //   ,pass: [/(.+){6,12}$/, '密码必须6到12位']
  //   ,content: function(value){
  //     layedit.sync(editIndex);
  //   }
  // });

 //点击出现弹出层
   $('#app_logo_cl').on('click',function(){      
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
        var input=document.getElementById('app_logo');
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
    console.log(data);
    $.post(adminurl,data.field,function( json ){
      console.log(json);
        if( json == 'go' ){
            layer.msg('设置成功');
            //关闭子页面
            window.location.reload();
        }else{
            layer.msg('设置失败', function(){  
            });  
        }   
    });
    return false;
  }); 

 //监听提交
   form.on('submit(demo2)', function(data){
    //console.log(data);
    $.post(adminurl1,data.field,function( json ){
      //console.log(json);
        if( json == 'go' ){
            layer.msg('设置成功');
            //关闭子页面
            window.location.reload();
        }else{
            layer.msg('设置失败', function(){  
            });  
        }   
    });
    return false;
  }); 


});

layui.use('element', function(){
  var $ = layui.jquery
  ,element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块
  
  //触发事件
  var active = {
    tabAdd: function(){
      //新增一个Tab项
      element.tabAdd('demo', {
        title: '新选项'+ (Math.random()*1000|0) //用于演示
        ,content: '内容'+ (Math.random()*1000|0)
      })
    }
    ,tabChange: function(){
      //切换到指定Tab项
      element.tabChange('demo', 1); //切换到第2项（注意序号是从0开始计算）
    }
  };
  
  $('.site-demo-active').on('click', function(){
    var type = $(this).data('type');
    active[type] ? active[type].call(this) : '';
  });
});



</script>

</body>
</html>