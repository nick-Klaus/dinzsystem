<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$style_no =  $_SESSION['style_no'];
$style_name = $_SESSION['style_name'];
$adduid = $_GET['adduid'];
$goods_type = $_GET['goods_type'];
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
  <legend><b>添加<?php if( $goods_type == 1 ){ echo "现货成品"; }elseif( $goods_type == 2 ){echo "现货空托";}else{echo "情侣戒参数"; } ?></b></legend>
</fieldset>

<form class="layui-form" action="">  
 <table class="layui-table">  
<tr>
<td colspan="4">
款号：<span style='color:#019F95;' ><?=$style_no?></span>　<!-- 款名：<span style='color:#019F95;' ><?=$style_name?></span> -->
</td>
</tr>
<input type="hidden" name="style_no" value="<?=$style_no?>">
<input type="hidden" name="adduid" value="<?=$adduid?>">
<input type="hidden" name="goods_type" value="<?=$goods_type?>">
<tr>
  <td width="100" align="right">货号:</td>
  <td width="200" ><input name="goods_no" type="text" id="goods_no"  lay-verify="title" autocomplete="off" placeholder="请输入货号" class="layui-input"/></td>
  
  <td class="hids" width="100" align="right">款名:</td>
  <td class="hids"> 
   <input type="radio" name="goods_name"  value="男款" title="男款"> 　
   <input type="radio" name="goods_name"  value="女款" title="女款" >
  </td>

</tr>
<tr>  
    <td align="right">缩略图:</td>
  <td>  
    <img src="../images/timg.jpg" id='imgurl' style='width:65px;height:65px;border:1px solid #ccc;float:left;'>
    <input type="hidden" name="goods_thumb" id="style_thumb"   placeholder="点击上传图片" class="layui-input" autocomplete="off"  style="width:150px;">
    <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>点击选图</button>
  </td>
  
    <td align="right">视频实拍:</td>
  <td>  
    <video id="sampleMovie" src=""  style="width:65px;height:65px;border:1px solid #ccc; float:left;" align="center"></video>
     <input type="hidden" name="goods_video" id="goods_video"  placeholder="点击上传视频" class="layui-input"   style="width:150px;">
     <button type="button" id="goods_video_cl" class="layui-btn layui-btn-radius"  style='margin-top:30px;'>点击选视频</button>
     </td>
</tr> 
<tr>
<td align="right">材质:</td>
<td>
<div class="layui-input-inline"  >
<select name="material" >
    <option value="0">请选择材质</option>
    <option value="18K金"> 18K金 </option>
  <option value="18K白"> 18K白 </option>
  <option value="18K红"> 18K红 </option>
  <option value="18K黄"> 18K黄 </option>
  <option value="PT950"> PT950 </option>  
</select>
</div>

</td>
<td align="right">尺寸:</td>
<td><input name="GoodsSize" type="text" id="GoodsSize"   lay-verify="title" autocomplete="off" placeholder="请输入尺寸" class="layui-input" /> </td>
</tr>
<tr>
<td align="right" >金重:</td>
<td>
<div style='width:200px;height:40px;line-height:40px;' ><input name="goldWeight" type="text" id="goldWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入金重" class="layui-input" style='width:100px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（g/克）</span></div>
</td>
<td align="right">主石形状:</td>
<td>
<div class="layui-input-inline"  >
<select name="StoneType" >
  <option value="圆形"  > 圆形 </option>
  <option value="梨形"  > 梨形 </option>
  <option value="心形"> 心形 </option>
  <option value="椭圆形"> 椭圆形 </option>
  <option value="橄榄形"> 橄榄形 </option>  
  <option value="枕形"> 枕形 </option>  
  <option value="祖母绿形"> 祖母绿形 </option>  
  <option value="三角形"> 三角形 </option>  
  <option value="公主方形"> 公主方形 </option>  
  <option value="雷蒂恩形"> 雷蒂恩形 </option>    
</select>
</div>

</td>
  </tr> 
  <tr>
 <td align="right">主石重量:</td>
<td>
<div style='width:200px;height:40px;line-height:40px;' ><input name="StoneWeight" type="text" id="StoneWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入主石" class="layui-input" style='width:100px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div>
 </td>
<td align="right"><span class="hid" >主石颜色:</span></td>
<td><input name="Color" type="text" id="Color"   placeholder="请输入主石颜色" class="layui-input  hid" > </td>
</tr> 
<tr class="hid" >
<td align="right" >主石净度:</td>
 <td  ><input name="Clarity" type="text" id="Clarity"    placeholder="请输入主石净度" class="layui-input" > </td>
<td align="right" >主石价格:</td>
<td><input name="StonePrice" type="text" id="StonePrice"    placeholder="请输入主石价格" class="layui-input" /> </td>
</tr>

  <tr>
<td align="right">主石类型:</td>
<td><input name="StoneShape" type="text" id="StoneShape"    lay-verify="title" autocomplete="off" placeholder="请输入主石类型" class="layui-input"/> </td>

<td align="right" >主石数量:</td>
  <td ><input name="StoneNum" type="text" id="StoneNum"   lay-verify="title" autocomplete="off" placeholder="请输入主石数量" class="layui-input" ></td>
</tr> 

  <tr>
<td align="right">主石描述:</td>
<td><input name="StoneTxt" type="text" id="StoneTxt"    lay-verify="title" autocomplete="off" placeholder="请输入主石描述" class="layui-input"/> </td>

<td align="right" >副石数量:</td>
  <td ><input name="DeStoneNum" type="text" id="DeStoneNum"   lay-verify="title" autocomplete="off" placeholder="请输入副石数量" class="layui-input" ></td>
</tr> 


<tr>
<td align="right" >副石重量:</td>
<td>
<div style='width:200px;height:40px;line-height:40px;' ><input name="DeStoneWeight" type="text" id="DeStoneWeight"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入副石" class="layui-input" style='width:100px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div> </td>
<td align="right">成本价:</td>
<td><input name="Price" type="text" id="Price"   lay-verify="title" autocomplete="off" placeholder="请输入成本价" class="layui-input"></td>

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
//现货成品
function block(){
   $('.hid').css('display','');
}
//现货空托
var goods_type = <?php echo $goods_type; ?>;
if( goods_type == 2 ){
  $('.hid').css('display','none');
  $('.hids').css('display','none');
}

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_goods.php";
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
    console.log(data);
    $.post(adminurl,data.field,function( json ){
        console.log(json);
        if( json == 'go' ){
            layer.msg('增加成功');
            //关闭子页面
            parent.location.reload();  
        }else{
            layer.msg('增加失败，请检查填写是否完整！', function(){
            });  
        }   
    });
    return false;
  }); 
});

</script>

</body>
</html>