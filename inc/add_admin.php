<?php
include "./../fun/eby_admin_api.php";
$uid = $_SESSION['uid'];
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
  <legend><b>添加管理员</b></legend>
</fieldset>

<form class="layui-form" action="">
  <div class="layui-form-item">
    <label class="layui-form-label">帐号：</label>
    <div class="layui-input-block">
      <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">密码：</label>
    <div class="layui-input-block">
      <input type="text" name="password" lay-verify="pass" autocomplete="off" placeholder="请输入密码" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">备注：</label>
    <div class="layui-input-block">
      <input type="text" name="user_bz" lay-verify="user_bz" autocomplete="off" placeholder="请输入备注" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <div class="layui-inline"  style='height:45px;line-height:45px;'>
      <label class="layui-form-label">上级ID：</label>
      <div class="layui-input-inline" >
        <input type="number" name="cuid" placeholder="请输入上级id" autocomplete="off" class="layui-input">
      </div>
      <span style='color:#009E94;' >（*上级id不能为0*）</span>
    </div>

    <div class="layui-form-item hids" >
      <label class="layui-form-label">菜单类型：</label>
      <div class="layui-input-inline">
          <input type="text" name="auth_type"  autocomplete="off" placeholder="请输入菜单类型" class="layui-input"  value="">
      </div>
      <label class="layui-form-label" style="color:#1AA094;width:260px;">（1.只买设备,2.只买APP,3.两者都有）</label>
  </div>

    <div class="layui-form-item hid">
      <label class="layui-form-label">数据标识：</label>
      <div class="layui-input-inline">
          <input type="text" name="maydiakeys"  autocomplete="off" placeholder="请输入数据标识(关键字标识)" class="layui-input"  value="">
      </div>
      <label class="layui-form-label" style="color:#1AA094;">（关键字）</label>
  </div>
  <div class="layui-form-item hid">
      <label class="layui-form-label">数据标识：</label>
      <div class="layui-input-inline">
          <input type="text" name="maydiatable"  autocomplete="off" placeholder="请输入数据标识(表格标识)"  class="layui-input"  value="">
      </div>
      <label class="layui-form-label" style="color:#1AA094;">（表 格）</label>
  </div>
 
 <div class="layui-form-item hid">
    <label class="layui-form-label">款式分类：</label>
    <div class="layui-input-block">
      <input type="radio" name="categorytype" value="0" title="系统数据" checked='checked' />
      <input type="radio" name="categorytype" value="1" title="全部数据" <? if($rs['categorytype']=='1'){echo 'checked';}?>/>
      <input type="radio" name="categorytype" value="2" title="除系统数据以外的全部数据" <? if($rs['categorytype']=='2'){echo 'checked';}?>/>
      <input type="radio" name="categorytype" value="3" title="自定义数据" <? if($rs['categorytype']=='3'){echo 'checked';}?>/>
    </div>
  </div>
  
  
    <div class="layui-form-item hid" >
    <label class="layui-form-label">裸石数据：</label>
    <div class="layui-input-block">
      
      <input type="radio" name="diamond_data_typ" value="0" title="B2B裸石数据" <?php if($rs['diamond_data_typ']=='0'){echo 'checked';}?> checked='checked' />
      <input type="radio" name="diamond_data_typ" value="2" title="B2C裸石数据" <?php if($rs['diamond_data_typ']=='2'){echo 'checked';}?> />
       <input type="radio" name="diamond_data_typ" value="1" title="B2C数据+自定义" <?php if($rs['diamond_data_typ']=='1'){echo 'checked';}?> />
      <input type="radio" name="diamond_data_typ" value="3" title="自定义数据" <?php if($rs['diamond_data_typ']=='3'){echo 'checked';}?> />
    </div>
  </div>
  <div class="layui-form-item hid" >
      <label class="layui-form-label">款式数据：</label>
      <div class="layui-input-block">
          <input type="radio" name="datatype" value="0" title="系统数据" checked='checked' />
          <input type="radio" name="datatype" value="1" title="全部数据" <?php if($rs['datatype']=='1'){echo 'checked';}?> />
          <input type="radio" name="datatype" value="2" title="除系统数据以外的全部数据" <?php if($rs['datatype']=='2'){echo 'checked';}?> />
          <input type="radio" name="datatype" value="3" title="自定义数据" <?php if($rs['datatype']=='3'){echo 'checked';}?> />
      </div>
  </div>
  
   <div class="layui-form-item hid" >
    <label class="layui-form-label">营销.引流：</label>
    <div class="layui-input-block">
      <input type="radio" name="marketing" value="0" title="系统数据" checked='checked' />
      <input type="radio" name="marketing" value="1" title="全部数据" <?php if($rs['marketing']=='1'){echo 'checked';}?> />
      <input type="radio" name="marketing" value="2" title="除系统数据以外的全部数据" <?php if($rs['marketing']=='2'){echo 'checked';}?> />
      <input type="radio" name="marketing" value="3" title="自定义数据" <?php if($rs['marketing']=='3'){echo 'checked';}?> />
    </div>
  </div>
    

      <div class="layui-form-item hid" >
          <label class="layui-form-label">培训：</label>
          <div class="layui-input-block">
              <input type="radio" name="train" value="0" title="系统数据" checked='checked' />
              <input type="radio" name="train" value="1" title="全部数据" <?php if($rs['train']=='1'){echo 'checked';}?> />
              <input type="radio" name="train" value="2" title="除系统数据以外的全部数据" <?php if($rs['train']=='2'){echo 'checked';}?> />
              <input type="radio" name="train" value="3" title="自定义数据" <?php if($rs['train']=='3'){echo 'checked';}?> />
          </div>
      </div>

      <div class="layui-form-item hid"  >
          <label class="layui-form-label">专题套系：</label>
          <div class="layui-input-block">
              <input type="radio" name="thematic_sets" value="0" title="系统数据" checked='checked' />
              <input type="radio" name="thematic_sets" value="1" title="全部数据" <?php if($rs['thematic_sets']=='1'){echo 'checked';}?> />
              <input type="radio" name="thematic_sets" value="2" title="除系统数据以外的全部数据" <?php if($rs['thematic_sets']=='2'){echo 'checked';}?> />
              <input type="radio" name="thematic_sets" value="3" title="自定义数据" <?php if($rs['thematic_sets']=='3'){echo 'checked';}?> />
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

 $(function(){
    var hidd = "<?php echo $uid ?>";
     if( hidd != 1  ){
         $(".hid").css("display","none");
     }
    
 })


layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_admin.php";
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
    console.log(data);
    $.post(adminurl,data.field,function( json ){
      console.log(json);
        if( json == 'go' ){
            layer.msg('增加成功');
            //关闭子页面
            parent.location.reload();  
        }else{
            layer.msg('增加失败,上级id不能为0或用户名已存在', function(){  
            });  
        }   
    });
    return false;
  }); 
});

</script>

</body>
</html>