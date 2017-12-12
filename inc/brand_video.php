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
  <legend><b>视频</b></legend>
</fieldset>

<form class="layui-form" action="">
  <table class="layui-table">
    <tr align="center"><td align="right">视频主题：</td><td>
      <?php
        $rs = is_array($rs)?$rs:array();
        foreach($rs as $v ){
      ?>
        <span class='layui-btn' style='overflow:hidden;'> <a href="brand_video.php?ids=<?php echo $v['id'] ?>&id=<?php echo $mac_id ?>&type_id=<?php echo $type_id ?>&uid=<?php echo $uid ?>"  class="layui-btn"><?php echo $v['title'] ?></a><a onclick='openpage4( "<?php echo $v['id'] ?>" )'   style='color:#FF6838;width:20px;display:inline-block;font-size:24px;float:right'>&times;</a></span>
       <?php
      }
      ?>
      </td></tr>
    <tr><td align="right">标题：</td><td> <input type="text" name="title" value="<?=$res['title']?>" lay-verify="title" autocomplete="off" placeholder="请输入标题" class="layui-input"></td></tr>
    <input type="hidden" name="id" value="<?=$res['id']?>">
    <input type="hidden" name="macid" value="<?=$mac_id?>">
    <input type="hidden" name="data_type" value="<?=$type_id?>">
    <input type="hidden" name="uid" value="<?=$uid?>">
    <tr >
      <td align="right">图片：</td>
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
        <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:10px;'>点击选图片</button>
      </td>
    </tr>
    <tr>
      <td align="right" >视频地址：</td>
      <td>
        <input type="text"  name="video_url"  autocomplete="off" placeholder="请输入视频地址" class="layui-input"  value="<?php echo urldecode($res['video_url']) ?>" >
      </td>
    </tr>
    <tr>
      <td  width="100">&nbsp;</td>
      <td height="24" align="left">
        <button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button>
        <a href="brand_video.php?id=<?php echo $mac_id; ?>&type_id=<?php echo $type_id; ?>&uid=<?php echo $uid; ?>" class="layui-btn layui-btn-primary">新增主题</a>
      </td>
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


    //监听提交
    form.on('submit(demo1)', function(data){
      //console.log(data);
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