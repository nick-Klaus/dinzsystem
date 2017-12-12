<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$adduid = $_SESSION['uid'];
$sql = "select id,group_name from e_fx_group where adduid=".$adduid;
$res = fetchAll($sql);

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
  <legend><b>添加会员</b></legend>
</fieldset>

<form id="form1">
  <div class="layui-form-item">
    <label class="layui-form-label">帐号：</label>
    <div class="layui-input-block">
        <input type="hidden" name="webid"  placeholder="请输入设备ID" class="layui-input"  value="<?php echo $adduid?>">
      <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">密码：</label>
    <div class="layui-input-block">
      <input type="text" name="userpwd" lay-verify="pass" autocomplete="off" placeholder="请输入密码" class="layui-input">
    </div>
    </div>
  <div class="layui-form-item">
    <label class="layui-form-label">姓名：</label>
    <div class="layui-input-block">
      <input type="text" name="nickname" lay-verify="title" autocomplete="off" placeholder="请输入姓名" class="layui-input">
    </div>
  </div>
  <div class="layui-form-item">
    <label class="layui-form-label">手机号：</label>
    <div class="layui-input-block">
      <input type="tel" name="mobile_phone" lay-verify="phone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
    </div>
  </div>
  <!--  省市县三级联动-->
  <div class="layui-form-item" >
    <label class="layui-form-label">所在地：</label>
    <div data-toggle="distpicker"  style="height:40px;line-height:40px;">

      <select class="form-control" name="prov" id="province1" style="height:30px;border: solid 1px #D9D9D9;"></select>

      <select class="form-control" name="city" id="city1" style="height:30px;border: solid 1px #D9D9D9;"></select>

      <select class="form-control" name="dist" id="district1" style="height:30px;border: solid 1px #D9D9D9;"></select>

    </div>
  </div>

<table>
  <tr><td> <div class="layui-form-item">
        <label class="layui-form-label">门店：</label>
        <div class="layui-input-block">
          <input type="text" name="store_name" lay-verify="title" autocomplete="off" placeholder="请输入门店名称" class="layui-input" style="width:190px">
        </div>
      </div></td><td> <div class="layui-form-item">
        <label class="layui-form-label">详细地址：</label>
        <div class="layui-input-block">
          <input type="text" name="address" lay-verify="title" autocomplete="off" placeholder="请输入地址" class="layui-input" style="width:190px">
        </div>
      </div>
    </td></tr>
  <tr><td><div class="layui-form-item"  >
        <label class="layui-form-label">邮编：</label>
        <div class="layui-input-block" >
          <input type="text" name="txcodes" lay-verify="title" autocomplete="off" placeholder="请输入邮编" class="layui-input" style="width:190px">
        </div>
      </div></td><td><div class="layui-form-item"  >
        <label class="layui-form-label">邮箱：</label>
        <div class="layui-input-inline">
          <input type="text" name="email" lay-verify="email" placeholder="请输入电子邮箱" autocomplete="off" class="layui-input">
        </div>
      </div></td></tr>
      <tr><td><div class="layui-form-item"  >
                    <label class="layui-form-label">生日：</label>
                    <div class="layui-input-block" >
                        <input type="text" name="birthday" lay-verify="title" value="" autocomplete="off" placeholder="请输入生日" class="layui-input" style="width:190px">
                    </div>
                </div></td><td><div class="layui-form-item"  >
                    <label class="layui-form-label">性别：</label>
                    <div class="layui-input-inline">
                       <select name="user_sex" style="height:30px;width:190px;border: solid 1px #D9D9D9;">
                            <option value="2">女</option>
                            <option value="1">男</option>
                        </select>
                    </div>
              </div></td></tr>

  <tr><td>
      <div class="layui-form-item">
        <label class="layui-form-label">是否启用：</label>
        <div class="layui-input-block" style="height:40px;line-height:40px;">
          <select  name="usertyp"  style="height:30px;width:150px;border: solid 1px #D9D9D9;">
            <option value="1" >启用</option>
            <option value="0">不启用</option>
          </select>
          <span style='color:#1AA094;font-size:12px;'>（*如果不启用，此会员则为无效会员*）</span>
        </div>
      </div>

    </td><td>

      <div class="layui-form-item">
        <label class="layui-form-label">组别：</label>
        <div class="layui-input-inline" style="height:40px;line-height:40px;">
          <select name="groupid" style="height:30px;width:150px;border: solid 1px #D9D9D9;">
            <option value="">请选择组别</option>
            <?php
            foreach ($res as $v) {
              ?>
              <option value="<?php echo $v['id'] ?>" ><?php echo $v['group_name'] ?></option>
              <?php
            }
            ?>
          </select>
        </div>
      </div>
    </td></tr>
</table>
<!--      <div class="layui-form-item">-->
<!--    <label class="layui-form-label">设备ID：</label>-->
<!--    <div class="layui-input-block">-->
<!--      <input type="text" name="webid"  placeholder="请输入设备ID" class="layui-input" >-->
<!--    </div>-->
<!--    </div>-->
  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">帐号备注：</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容" class="layui-textarea" name='user_bz' ></textarea>
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
<script src="../layui/js/distpicker.data.js"></script>
<script src="../layui/js/distpicker.js"></script>
<script src="../layui/js/main.js"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
 // var adminurl="./addpro_fx_admin.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 1){
        return '此项为必填项！';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });

});

$(function(){

    $("#form1").submit(function(){
        $.ajax({
            cache: true,
            type: "POST",
            url:"./addpro_fx_admin.php",
            data:$("#form1").serialize(),// 你的formid
            async: false,
            error: function(request) {
                console.log('输入有误');
            },
            success: function(data) {
                if( data == 'go' ){
                    layer.msg('添加成功');
                    //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('添加失败，用户名已存在！');

                }
            }
        });
    });
});
</script>

</body>
</html>