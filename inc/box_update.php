<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$macid = $_GET['id'];

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
  <legend><b>设备配置</b></legend>
</fieldset>

<?
$sql = "select a.*,b.uid as m_uid,b.wechat_picture,b.alipay_picture from e_mac_code a left join e_members b on a.uid=b.uid where a.id='$macid'";

$rs = fetchOne($sql);

?>  
<form class="layui-form" action="">
<table class="layui-table">

    <tbody>
    <!-- <input type="hidden" name="act" value="admin_box_set" /> -->
    <input type="hidden" name="id" value="<?=$rs['id']?>">
    <input type="hidden" name="m_uid" value="<?=$rs['m_uid']?>">
     <tr>
        <td height="35" align="right" width="200">订单Logo图：</td>
  
        <td>
      <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
     <img src="<?php
         if( $rs['mac_logo'] ){
             echo "http://imageserver.echao.com/".$rs['mac_logo'];
         }else{
             echo "../images/timg.jpg";
         }
     ?>" id='imgurl' style="width:100%;height:100%">
    </div> 
     <input type="hidden" name="mac_logo" id="style_thumb"  placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="<?=$rs['mac_logo']?>">
     <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style="margin-top:10px;" >点击选图(尺寸：360*360)</button>
       </td>
      </tr>
    <tr>
        <td height="35" align="right" width="200">微信支付：</td>
        <td>
          <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
          <img src="<?php
             if( $rs['wechat_picture'] ){
                 echo "http://imageserver.echao.com/".$rs['wechat_picture'];
             }else{
                 echo "../images/timg.jpg";
             }
         ?>" id='wechat_imgurl' style="width:100%;height:100%">
         </div>
     <input type="text" name="wechat_picture" id="wechat_picture"  placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="<?=$rs['wechat_picture']?>">
     <button type="button" id="wechat_picture_cil" class="layui-btn layui-btn-radius" style="margin-top:10px;" >点击选图</button>
       </td>

    </tr>
    <tr>
      <td height="35" align="right" width="200">支付宝支付：</td>
      <td>
        <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
       <img src="<?php
           if( $rs['alipay_picture'] ){
               echo "http://imageserver.echao.com/".$rs['alipay_picture'];
           }else{
               echo "../images/timg.jpg";
           }
       ?>" id='alipay_imgurl' style="width:100%;height:100%">
      </div> 
       <input type="text" name="alipay_picture" id="alipay_picture"  placeholder="点击上传图片" class="layui-input"   style="width:300px;" value="<?=$rs['alipay_picture']?>">
       <button type="button" id="alipay_picture_cil" class="layui-btn layui-btn-radius" style="margin-top:10px;" >点击选图</button>
       </td>
       
    </tr>
    <tr class="hidd">
    <td height="35" align="right" width="200">微信支付UID：</td>
    <td><input name="wei_uid" type="text" id="uid" value="<?php echo $rs['wei_uid'] ?>"  placeholder="请输入微信公众号支付uid"  class="layui-input" /></td>
    </tr>
      
    <tr class="hidd">
    <td height="35" align="right" width="200">订单通知UID：</td>
    <td><input name="eby_weixin" type="text"  value="<?php echo $rs['eby_weixin'] ?>"  placeholder="接收订单通知的uid"  class="layui-input" /></td>
    </tr>


    <tr class="hidd">
    <td height="35" align="right" width="200">设备备注：</td>
    <td><input name="mac_remark" type="text" value="<?php echo $rs['mac_remark'] ?>"  placeholder="请输入设备备注"  class="layui-input" /></td>
    </tr>
    <!--用户设置的备注-->
    <tr class="user_hidd">
        <td height="35" align="right" width="200">设备备注：</td>
        <td><input name="user_remark" type="text" value="<?php echo $rs['user_remark'] ?>"  placeholder="请输入设备备注"  class="layui-input" /></td>
    </tr>

    <tr class="hidd hid" >
    <td height="35" align="right" width="200">管理员ID：</td>
    <td><input name="uid" type="text"  value="<?php echo $rs['uid'] ?>" placeholder="请输入管理员ID" autocomplete="off" class="layui-input" /></td>
    </tr>
    <tr class="hidd hid" >
    <td height="35" align="right" width="200">服务开始时间：</td>
    <td> <input class="layui-input" name='startTime' placeholder="自定义日期格式" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?=$rs['startTime'] ? date('Y-m-d H:i:s',$rs['startTime']):''?>"></td>
    </tr>
    <tr class="hidd hid" >
        <td height="35" align="right" width="200">服务结束时间：</td>
        <td> <input class="layui-input" name='endTime' placeholder="自定义日期格式" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?=$rs['endTime'] ? date('Y-m-d H:i:s',$rs['endTime']):''?>"></td>
    </tr>

      <tr>
        <td  width="200">&nbsp;</td>
        <td height="24" align="left"><button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button></td>
      </tr>
</form>
    </tbody>
</table>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./boxpro_update.php";


var uid = "<?php echo $c_uid ?>";

if( uid != 1  ){
  $(".hidd").css('display','none');
}else{
    $(".user_hidd").css('display','none');
}
if( uid == 4 ){
  $(".hid").css('display','');
  $(".hidd").css('display','');
}

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
   $('#wechat_picture_cil').on('click',function(){   
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
        var img=document.getElementById('wechat_imgurl');
        var input=document.getElementById('wechat_picture');
        img.src='http://imageserver.echao.com/uploadfile/'+src;
        input.value = '/uploadfile/'+src;
        layer.close(index);       
    }
  });

   //点击出现弹出层
   $('#alipay_picture_cil').on('click',function(){   
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
        var img=document.getElementById('alipay_imgurl');
        var input=document.getElementById('alipay_picture');
        img.src='http://imageserver.echao.com/uploadfile/'+src;
        input.value = '/uploadfile/'+src;
        layer.close(index);       
    }
  }); 

//监听提交
form.on('submit(demo1)', function(data){
    //console.log(data);
    $.post(adminurl,data.field,function( json ){
       //console.log(json);
        if( json == 'go' || json == 'gogo' ){
            layer.msg('编辑成功');
            //关闭子页面
            parent.location.reload();
        }else{
            layer.msg('您没有进行数据操作！', function(){
            });
        }
    });
    return false;
});
});

</script>

</body>
</html>