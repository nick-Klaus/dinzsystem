<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$id = $_GET['editid'];
$sql="select * from e_gems where id=".$id;
$res = fetchOne($sql);

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
  <legend><b>彩宝编辑</b></legend>
</fieldset>
<form class="layui-form" action="">


<table class="layui-table" lay-even="" lay-skin="nob">

<input type="hidden" name="id" value="<?=$id?>">
  <tr class="am-active" style="color:#000000">
    <td style="width:100px;text-align:right;">货号：</td><td><input type="text" name="Ref" id="Ref" lay-verify="required" placeholder="请输入货号" autocomplete="off" class="layui-input" value="<?php echo $res['Ref']?>" /></td>

  <td style="width:100px;text-align:right;">图片：</td><td>
  <div class="picbox_2 p_pic" style='width:70px;height:70px;float:left;margin-right:10px;'>
    <img src="http://imageserver.echao.com/<?php echo $res['pic']?>" id='imgurl' style='width:70px;height:70px;border:1px solid #ccc;'>
     </div>
       <!-- <input type="hidden" name="pic" id="pic" value="<?=$rs['pic']?>" onBlur="get(this)"> -->
       <input type="text" name="pic" id="style_thumb" value="<?php echo $res['pic']?>"  placeholder="点击上传图片" class="layui-input"   style="width:150px;margin:30px 0px 0px 0px;">
       </td>
  
  </tr><tr> 
  <td style="width:100px;text-align:right;">材质：</td><td><input type="text" name="category" id="category" lay-verify="required" placeholder="请输入材质" autocomplete="off" class="layui-input" value="<?php echo $res['category']?>" /></td>
  
  <td style="width:100px;text-align:right;">形状：</td><td><input type="text" name="Shape" id="Shape" lay-verify="required" placeholder="请输入形状" autocomplete="off" class="layui-input" value="<?php echo $res['Shape']?>" /></td>
    </tr><tr> 
  <td style="width:100px;text-align:right;">定制类型：</td><td><input type="text" name="style" id="style" lay-verify="required" placeholder="请输入定制类型" autocomplete="off" class="layui-input" value="<?php echo $res['style']?>" /></td>
  
  <td style="width:100px;text-align:right;">等级：</td><td><input type="text" name="Grade" id="Grade" lay-verify="required" placeholder="请输入等级" autocomplete="off" class="layui-input" value="<?php echo $res['Grade']?>" /></td>
</tr><tr> 
  <td style="width:100px;text-align:right;">重量 ct：</td><td><input type="text" name="Size" id="Size" lay-verify="required" placeholder="请输入重量 ct" autocomplete="off" class="layui-input" value="<?php echo $res['Size']?>" /></td>

  <td style="width:100px;text-align:right;">规格：</td><td><input type="text" name="spe" id="spe" lay-verify="required" placeholder="请输入规格" autocomplete="off" class="layui-input" value="<?php echo $res['spe']?>" /></td>
</tr><tr> 
  <td style="width:100px;text-align:right;">价格：</td><td><input type="text" name="Rate" id="Rate" lay-verify="required" placeholder="请输入价格" autocomplete="off" class="layui-input" value="<?php echo $res['Rate']?>" /></td>
  <td style="width:100px;text-align:right;">备注：</td><td><input type="text" name="Bz" id="Bz" lay-verify="required" placeholder="请输入备注" autocomplete="off" class="layui-input" value="<?php echo $res['Bz']?>" /></td>
</tr><tr> 
  <td colspan="4" align="center"><button class="layui-btn" lay-submit="" lay-filter="demo1">　提　交　</button>
</td>
  </tr>
</table>
</form> 
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./editpro_gems.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 3){
        return '这是必填选项';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });

 //点击出现弹出层
   $('#style_thumb').on('click',function(){      
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
        input.value = 'uploadfile/'+src;
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