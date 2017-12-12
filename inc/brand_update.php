<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
//主页面传来的
$type_id = $_GET['type_id'];
$mac_id = $_GET['id'];//机器的id号
$uid = $_GET['uid'];
//点击标题传来的id
$id = $_GET['ids'];
$sql_ppt = "select * from  ppt_upload  where id='$id'";
$res = fetchOne($sql_ppt);

$sql = "select id,title from  ppt_upload  where data_type='$type_id' and macid='$mac_id'";
$rs = fetchAll($sql);


//json图片地址转化为数组
$json = json_decode($res['url'],true);
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
  <legend><b>幻灯片</b></legend>
</fieldset>

<form class="layui-form" action="">
<table class="layui-table">
    <tr align="center"><td align="right">品牌主题：</td><td>
            <?php
            $rs = is_array($rs)?$rs:array();
            foreach($rs as $v ){
                ?>
            <span class='layui-btn' style='overflow:hidden;'>
                <a href="brand_update.php?ids=<?php echo $v['id'] ?>&id=<?php echo $mac_id ?>&type_id=<?php echo $type_id ?>&uid=<?php echo $uid ?>"  class="layui-btn"><?php echo $v['title'] ?></a>
                <a onclick='openpage4( "<?php echo $v['id'] ?>" )'   style='color:#FF6838;width:20px;display:inline-block;font-size:24px;float:right'>&times;</a>
            </span>
                <?php
            }
            ?>
        </td></tr>
    <tr><td align="right">标题：</td><td> <input type="text" name="title" value="<?=$res['title']?>" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input"></td></tr>
    <input type="hidden" name="id" value="<?=$res['id']?>">
    <input type="hidden" name="macid" value="<?=$mac_id?>">
    <input type="hidden" name="data_type" value="<?=$type_id?>">
    <input type="hidden" name="uid" value="<?=$uid?>">

    <tr class="thum_hid">
        <td align="right">缩略图：</td>
        <td>
            <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
                <img src="<?php
                    if( $res['thum_url'] ){
                        echo "http://imageserver.echao.com/".$res['thum_url'];
                    }else{
                        echo "../images/timg.jpg";
                    }
                    ?>" id='imgurl' style="width:100%;height:100%">
            </div>
            <input type="hidden" style="width:200px;" id="style_thumb" name="thum_url" lay-verify="user_bz"  readonly="1" autocomplete="off" placeholder="点击上传图片" class="layui-input"  value="<?php  echo $res['thum_url'];?>" >
          <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图（尺寸：300*300）</button>
        </td>
    </tr>

      <tr class="_ppt">
        <td align="right"  >幻灯图：</td>
        <td>
         <input type="hidden" id="pages" name="url" lay-verify="user_bz"  readonly="1" autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"  value="<?php  echo implode(",",$json);?>" >
         <button type="button" id="pages_cl" class="layui-btn layui-btn-radius" >点击选图（上传多张图片可重复点击,尺寸：1920*1080）</button>
      <div id='pageall'>
          <?php 
          $arr=json_decode($res['url'],true);
          $arr = empty($arr)?array():$arr; 
          foreach ($arr as $key => $value) {
             echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/".$value."' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>" ;
          }
          ?> 
     </div>  
        
    </td>
      </tr>
      <tr>
        <td  width="100">&nbsp;</td>
        <td height="24" align="left">
            <button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button>
            <a href="brand_update.php?id=<?php echo $mac_id ?>&type_id=<?php echo $type_id ?>&uid=<?php echo $uid; ?>" class="layui-btn layui-btn-primary">新增主题</a>
        </td>
      </tr>
</form>
</table>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
 $(function(){
     var data_type = "<?php echo $type_id; ?>"
     if( data_type == 1 ){
         $(".thum_hid").css("display","none");
     }
 })

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
  var adminurl="./brandpro_update.php";
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


//ajax 删除主题
function  openpage4( id ){
    var delid = id;
    layer.confirm('您确定要删除此主题吗，请谨慎操作！', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: "brand_del.php",
            data: "delid="+delid,
            success: function(msg){
                if(msg  == 'go' ){
                    layer.msg('删除成功', {  time: 1000,  });
                    window.location.reload();
                }else{
                    layer.msg('删除失败', {  time: 1000,  });
                }
            }
        });
    }, function(){
    });
}


</script>

</body>
</html>