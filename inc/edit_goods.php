<?php   
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
//需要编辑数据的ID
$editid = $_GET['editid'];
$goods_type = $_GET['goods_type'];
$style_name = $_SESSION['style_name'];
$sql = "select * from e_goods_list where id=".$editid;
$rs = fetchOne($sql);

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
  <legend><b>编辑库存</b></legend>
</fieldset>

<form class="layui-form" action="">
 <table class="layui-table">
    <input type="hidden" name="id" value="<?php echo $editid ?>">
    <input type="hidden" name="style_no" value="<?php echo $rs['style_no'] ?>">
    <input type="hidden" name="goods_name" value="<?php echo $rs['goods_name'] ?>">
<tr>
<td colspan="2">
款号：<span style='color:#019F95;' ><?php echo $rs['style_no'] ?></span>　款名：<span style='color:#019F95;' ><?php echo $style_name ?></span>
</td>
<td class="_hids"></td>
<td class="_hids"></td>
<td align="right" class="hids">款式:</td>
<td class="hids">

<input type="radio" name="goods_name" onclick='block()'  value="男款" title="男款" <?php  if( trim($rs['goods_name']) == "男款" ){ echo "checked";  }   ?>  />
<input type="radio" name="goods_name" onclick='block()'  value="女款" title="女款" <?php  if( trim($rs['goods_name']) == "女款" ){ echo "checked";  } ?>  />
</td>
</tr>
<tr>
  <td width="100" align="right">货号:</td>
  <td width="200" ><input name="goods_no" type="text" id="goods_no"  lay-verify="title" autocomplete="off" placeholder="请输入货号" class="layui-input" value="<?php  echo $rs['goods_no'] ?>" /> </td>

    <td width="100" align="right">类别:</td>
  <td>
  <!-- <input name="goods_name" type="text" id="goods_name"   lay-verify="title" autocomplete="off" placeholder="请输入品名" class="layui-input" value="<?php  echo $rs['goods_name'] ?>" /> -->
   <label><input type="radio" name="goods_type" onclick='block()'  value="1" title="现货成品" <?php  if( $rs['goods_type'] == 1 ){ echo "checked";  } ?> disabled="disabled" /> </label>
   <label><input type="radio" name="goods_type" onclick='block()'  value="3" title="款式参数" <?php  if( $rs['goods_type'] == 3 ){ echo "checked";  } ?> disabled="disabled" /> </label>
    <label><input type="radio" name="goods_type" onclick='hid()' id='hid' value="2" title="现货空托" <?php  if( $rs['goods_type'] == 2 ){ echo "checked";  } ?> disabled="disabled" /> </label>
  </td>

</tr>
<tr>  
    <td align="right">缩略图:</td>
  <td>  
    <img src="http://imageserver.echao.com/<?php  echo $rs['goods_thumb'] ?>" id='imgurl' style='width:65px;height:65px;border:1px solid #ccc;float:left;'>
    
    <input type="hidden" name="goods_thumb" id="style_thumb"   placeholder="点击上传图片" class="layui-input"  value="<?php  echo $rs['goods_thumb'] ?>"  style="width:200px;">
    <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>点击选图</button>
  </td>
  
    <td align="right">视频实拍:</td>
  <td>  <div class="picbox_2 p_goods_video">
    <video id="sampleMovie" src="<?php  echo $rs['goods_video'] ?>"  style="width:70px;height:70px;border:1px solid #ccc;float:left;"></video>
     </div>
       <!-- <input type="hidden" name="goods_video" id="goods_video" value="<?=$rs['goods_video']?>" > -->
     <input type="hidden" name="goods_video" id="goods_video"  placeholder="点击上传视频" class="layui-input" value="<?php  echo $rs['goods_video'] ?>"  style="width:200px;">
     <button type="button" id="goods_video_cl" class="layui-btn layui-btn-radius"  style='margin-top:30px;'>点击选视频</button>
     </td>
</tr> 
<tr>
<td align="right">材质:</td>
<td>
<div class="layui-input-inline"  >
<select name="material" >
    <option value="0">请选择材质</option>
  <option value="18K金" <?php if( $rs['material'] == "18K金" ){ echo "selected='selected'"; } ?> > 18K金 </option>
  <option value="18K白" <?php if( $rs['material'] == "18K白" ){ echo "selected='selected'"; } ?> > 18K白 </option>
  <option value="18K红" <?php if( $rs['material'] == "18K红" ){ echo "selected='selected'"; } ?> > 18K红 </option>
  <option value="18K黄" <?php if( $rs['material'] == "18K黄" ){ echo "selected='selected'"; } ?> > 18K黄 </option>
  <option value="PT950" <?php if( $rs['material'] == "PT950" ){ echo "selected='selected'"; } ?> > PT950 </option>  
</select>
</div>
<!-- <input name="material" type="text" id="material"  value="<?php  echo $rs['material'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入材质" class="layui-input" />  -->
</td>
<td align="right">尺寸:</td>
<td><input name="GoodsSize" type="text" id="GoodsSize"  value="<?php  echo $rs['GoodsSize'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入尺寸" class="layui-input" /> </td>
</tr>
<tr>
<td align="right" >金重:</td>
<td><!-- <input name="goldWeight" type="text" id="goldWeight"  value="<?php  echo $rs['goldWeight'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入金重" class="layui-input" /> -->
<div style='width:200px;height:40px;line-height:40px;' ><input name="goldWeight" type="text" id="goldWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入金重" class="layui-input" value="<?php  echo $rs['goldWeight'] ?>" style='width:120px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（g/克）</span></div>
 </td>
<td align="right">主石形状:</td>
<td>
<div class="layui-input-inline"  >
<select name="StoneType" >
  <option value="圆形" <?php if( $rs['StoneType'] == "圆形" ){ echo "selected='selected'"; } ?> > 圆形 </option>
  <option value="梨形" <?php if( $rs['StoneType'] == "梨形" ){ echo "selected='selected'"; } ?> > 梨形 </option>
  <option value="心形" <?php if( $rs['StoneType'] == "心形" ){ echo "selected='selected'"; } ?> > 心形 </option>
  <option value="椭圆形" <?php if( $rs['StoneType'] == "椭圆形" ){ echo "selected='selected'"; } ?> > 椭圆形 </option>
  <option value="橄榄形" <?php if( $rs['StoneType'] == "橄榄形" ){ echo "selected='selected'"; } ?> > 橄榄形 </option>  
  <option value="枕形" <?php if( $rs['StoneType'] == "枕形" ){ echo "selected='selected'"; } ?> > 枕形 </option>  
  <option value="祖母绿形" <?php if( $rs['StoneType'] == "祖母绿形" ){ echo "selected='selected'"; } ?> > 祖母绿形 </option>  
  <option value="三角形" <?php if( $rs['StoneType'] == "三角形" ){ echo "selected='selected'"; } ?> > 三角形 </option>  
  <option value="公主方形" <?php if( $rs['StoneType'] == "公主方形" ){ echo "selected='selected'"; } ?> > 公主方形 </option>  
  <option value="雷蒂恩形" <?php if( $rs['StoneType'] == "雷蒂恩形" ){ echo "selected='selected'"; } ?> > 雷蒂恩形 </option>    
</select>
</div>
<!-- <input name="StoneType" type="text" id="StoneType" value="<?php  echo $rs['StoneType'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石类型" class="layui-input" />  -->

</td>
  </tr> 
  <tr>
<td align="right">主石重量:</td>
<td><!-- <input name="StoneWeight" type="text" id="StoneWeight" value="<?php  echo $rs['StoneWeight'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石重量" class="layui-input"/> --> 
<div style='width:200px;height:40px;line-height:40px;' ><input name="StoneWeight" type="text" id="StoneWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入主石重量" class="layui-input" value="<?php  echo $rs['StoneWeight'] ?>"  style='width:100px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div>
  
<td align="right" class='hid'>主石颜色:</td>
<td class='hid'><input name="Color" type="text" id="Color"  value="<?php  echo $rs['Color'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石颜色" class="layui-input" > </td>

</tr> 
  <tr class='hid'>
<td align="right" >主石净度:</td>
<td><input name="Clarity" type="text" id="Clarity" value="<?php  echo $rs['Clarity'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石净度" class="layui-input" > </td>
</td>
<td align="right" >主石价格:</td>
<td><input name="StonePrice" type="text" id="StonePrice"  value="<?php  echo $rs['StonePrice'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入主石价格" class="layui-input" /> </td>

  </tr>

  <tr>
<td align="right">主石类型:</td>
<td><input name="StoneShape" type="text" id="StoneShape"   value="<?php  echo $rs['StoneShape'] ?>"   lay-verify="title" autocomplete="off" placeholder="请输入主石类型" class="layui-input"/> </td>

<td align="right" >主石数量:</td>
  <td ><input name="StoneNum" type="text" id="StoneNum"  value="<?php  echo $rs['StoneNum'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石数量" class="layui-input" ></td>
</tr> 

<tr>
<td align="right">主石描述:</td>
<td><input name="StoneTxt" type="text" id="StoneTxt"  value="<?php  echo $rs['StoneTxt'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石描述" class="layui-input"/> </td>
  <td align="right" >副石数量:</td>
  <td ><input name="DeStoneNum" type="text" id="DeStoneNum" value="<?php  echo $rs['DeStoneNum'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入副石数量" class="layui-input" ></td>
</tr> 
  <tr>
<td align="right" >副石重量:</td>
<td><!-- <input name="DeStoneWeight" type="text" id="DeStoneWeight" value="<?php  echo $rs['DeStoneWeight'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入副石重量" class="layui-input"> -->
<div style='width:200px;height:40px;line-height:40px;' ><input name="DeStoneWeight" type="text" id="DeStoneWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入副石重量" class="layui-input" value="<?php  echo $rs['DeStoneWeight'] ?>" style='width:100px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div>
 </td>
<td align="right">成本价:</td>
<td><input name="Price" type="text" id="Price" value="<?php  echo $rs['Price'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入成本价" class="layui-input"></td>

</tr>
<tr align="center">
<td colspan="4"> 
<button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
</tr>
</table>
</form>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
//现货空托
var goods_type = <?php echo $goods_type; ?>;
if( goods_type == 2 ){
  $('.hids').css('display','none');
}

if( goods_type == 1 ){
  $('.hids').css('display','none');
}  
if( goods_type == 3 ){
  $('._hids').css('display','none');
} 

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./editpro_goods.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  // form.verify({
  //   title: function(value){
  //     if(value.length < 1){
  //       return '此项为必填项！';
  //     }
  //   }
  //   ,pass: [/(.+){6,12}$/, '密码必须6到12位']
  //   ,content: function(value){
  //     layedit.sync(editIndex);
  //   }
  // });
var hidden = $("#hid").attr('checked');
if( hidden == 'checked' ){
    $('.hid').css('display','none');
}

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
   $('#goods_video_cl').on('click',function(){      
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
        var img=document.getElementById('sampleMovie');
        var input=document.getElementById('goods_video');
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