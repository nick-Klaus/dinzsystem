<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$editid = $_GET['editid'];
$sql = "select * from e_fx_members where uid=".$editid;
$res = fetchOne( $sql );

$adduid = $_SESSION['uid'];
$sql1 = "select id,group_name from e_fx_group where adduid=".$adduid;
$res1 = fetchAll($sql1);

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
  <legend><b>编辑会员</b></legend>
</fieldset>

<form  id="form1" >
<input type="hidden" name="uid" value="<?php echo $res['uid'] ?>">
  <div class="layui-form-item">
    <label class="layui-form-label">帐号：</label>
    <div class="layui-input-block">
      <input type="text" name="username" value="<?php echo $res['username'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input">
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">密码：</label>
    <div class="layui-input-block">
      <input type="text" name="userpwd" value="<?php echo $res['userpwd'] ?>" lay-verify="pass" autocomplete="off" placeholder="请输入密码" class="layui-input">
    </div>
    </div>

    <div class="layui-form-item">
        <label class="layui-form-label">姓名：</label>
        <div class="layui-input-block">
            <input type="text" name="nickname" value="<?php echo $res['nickname'] ?>" lay-verify="title" autocomplete="off" placeholder="请输入姓名" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">手机号：</label>
        <div class="layui-input-block">
            <input type="tel" name="mobile_phone"  value="<?php echo $res['mobile_phone'] ?>" lay-verify="phone" placeholder="请输入手机号" autocomplete="off" class="layui-input">
        </div>
    </div>
<!--      省市县三级联动-->
    <div class="layui-form-item" >
        <label class="layui-form-label">所在地：</label>
        <div data-toggle="distpicker"  style="height:40px;line-height:40px;float:left;">

            <select class="form-control" name="prov" id="province1" style="height:30px;border: solid 1px #D9D9D9;"></select>

            <select class="form-control" name="city" id="city1" style="height:30px;border: solid 1px #D9D9D9;"></select>

            <select class="form-control" name="dist" id="district1" style="height:30px;border: solid 1px #D9D9D9;"></select>

        </div>
        <div style="height:40px;line-height:40px;float:left;margin-left: 15px">
            <?php  if( $res['prov'] ){ echo $res['prov']."-".$res['city']."-".$res['dist']; }?>
        </div>
    </div>


    <table>
        <tr><td> <div class="layui-form-item">
                    <label class="layui-form-label">门店：</label>
                    <div class="layui-input-block">
                        <input type="text" name="store_name" value="<?php echo $res['store_name'] ?>"  lay-verify="title" autocomplete="off" placeholder="请输入门店名称" class="layui-input" style="width:190px">
                    </div>
                </div></td><td> <div class="layui-form-item">
                    <label class="layui-form-label">详细地址：</label>
                    <div class="layui-input-block">
                        <input type="text" name="address" lay-verify="title" value="<?php echo $res['address'] ?>" autocomplete="off" placeholder="请输入地址" class="layui-input" style="width:300px">
                    </div>
                </div>
            </td></tr>

              <tr><td><div class="layui-form-item"  >
                    <label class="layui-form-label">邮编：</label>
                    <div class="layui-input-block" >
                        <input type="text" name="txcodes" lay-verify="title" value="<?php echo $res['txcodes'] ?>" autocomplete="off" placeholder="请输入邮编" class="layui-input" style="width:190px">
                    </div>
                </div></td><td><div class="layui-form-item"  >
                    <label class="layui-form-label">邮箱：</label>
                    <div class="layui-input-inline">
                        <input type="text" name="email" lay-verify="email" value="<?php echo $res['email'] ?>" placeholder="请输入电子邮箱" autocomplete="off" class="layui-input" style="width:300px">
                    </div>
              </div></td></tr>
              <tr><td><div class="layui-form-item"  >
                    <label class="layui-form-label">生日：</label>
                    <div class="layui-input-block" >
                        <input type="text" name="birthday" lay-verify="title" value="<?php echo $res['birthday'] ?>" autocomplete="off" placeholder="请输入生日" class="layui-input" style="width:190px">
                    </div>
                </div></td><td><div class="layui-form-item"  >
                    <label class="layui-form-label">性别：</label>
                    <div class="layui-input-inline">
                       <select name="user_sex" style="height:30px;width:190px;border: solid 1px #D9D9D9;">
                            <option value="2" <?php if( $res['user_sex'] == 2 ){ echo "selected='selected'"; } ?>>女</option>
                            <option value="1" <?php if( $res['user_sex'] == 1 ){ echo "selected='selected'"; } ?>>男</option>
                        </select>
                    </div>
              </div></td></tr>

        <tr><td >
                <div class="layui-form-item">
                    <label class="layui-form-label">组别：</label>
                    <div class="layui-input-inline" style="height:40px;line-height:40px;">
                        <select name="groupid" style="height:30px;width:190px;border: solid 1px #D9D9D9;">
                            <option value="">请选择组别</option>
                            <?php
                            foreach ($res1 as $v) {

                                ?>
                                <option value="<?php echo $v['id'] ?>" <?php if( $v['id'] == $res['groupid'] ){ echo "selected='selected'"; } ?> ><?php echo $v['group_name'] ?></option>
                                <?php
                            }

                            ?>
                        </select>
                    </div>
                </div>
            </td>
            <td>

            <div class="layui-form-item hidd"   >
                    <label class="layui-form-label">
                        <?php
                            if( $adduid == 19 ){
                                echo "成本价：";
                            }else{
                                echo "裸石权限：";
                            }
                        ?>
                    </label>
                    <div class="layui-input-inline">
                       <select name="domain" style="height:30px;width:190px;border: solid 1px #D9D9D9;">
                            <option value="0" <?php if( $res['domain'] == 0 ){ echo "selected='selected'"; } ?>>不启用</option>
                            <option value="1" <?php if( $res['domain'] == 1 ){ echo "selected='selected'"; } ?>>启用</option>
                        </select>
                    </div>
              </div>

              </td>
            </tr>
        <tr class="gold" >
            <td >
                <div class="layui-form-item hidd">
                    <label class="layui-form-label">
                        公司编号：
                    </label>
                    <div class="layui-input-inline">
                        <input type="text" name="company_name" lay-verify="title" value="<?php echo $res['company_name'] ?>"
                               autocomplete="off" placeholder="请输入公司编号" class="layui-input" style="width:190px">
                    </div>
                </div>

            </td></tr>
    </table>
<div class="layui-form-item" id='layui-form-item'>
  <label class="layui-form-label">设备ID：</label>
<div class="layui-input-block">
  <input type="text" name="webid"  value="<?php echo $res['webid'] ?>" placeholder="请输入设备ID" class="layui-input">
</div>
</div>

  <div class="layui-form-item layui-form-text">
    <label class="layui-form-label">帐号备注：</label>
    <div class="layui-input-block">
      <textarea placeholder="请输入内容"  class="layui-textarea" name='user_bz' ><?php echo $res['user_bz'] ?></textarea>
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

$(function(){

  var uid = "<?php echo $adduid ?>";
  $('.hidd').css('display','none');
  if( uid > 1 ){
      $('#layui-form-item').css('display','none');
  }
  // 部分客户 不能查看裸石列表 金佳丽 不能查看成本价
  if( uid == 2 || uid == 24|| uid == 19 || uid == 25 || uid == 27 || uid == 3 || uid == 133 || uid == 132 || uid == 32 || uid == 81 || uid == 171 ){
    $('.hidd').css('display','block');
  }
    if( uid != 19 ){
        $('.gold').css('display','none');
    }

});

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./editpro_fx_admin.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');

  // //自定义验证规则
  // form.verify({
  //   title: function(value){
  //     if(value.length < 3){
  //       return '帐号至少得3个字符';
  //     }
  //   }
  //   ,pass: [/(.+){6,12}$/, '密码必须6到12位']
  //   ,content: function(value){
  //     layedit.sync(editIndex);
  //   }
  // });

});

$(function(){

    $("#form1").submit(function(){
        $.ajax({
            cache: true,
            type: "POST",
            url:"./editpro_fx_admin.php",
            data:$("#form1").serialize(),// 你的formid
            async: false,
            error: function(request) {
                console.log('输入有误');
            },
            success: function(data) {
                if( data == 'go' ){
                layer.msg('编辑成功');
                //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('编辑失败,用户名已存在!', function(){
                    });
                    parent.location.reload();
                }
            }
        });
    });
    //省级数据的选中
   var  arr = $("#province1 option").map(function(){return $(this).val();}).get().join(",");
   var  str = "";
   var  num = arr.split(",").indexOf(str);
   var  sele = $("#province1 option").eq(num);
    sele.prop('selected',true);
    $("#city1 option").remove();
    var  str1 = "";
    var option = "<option  value='"+str1+"'>"+str1+"</option>";
    $("#city1").append(option);
    $("#district1 option").remove();
    var  str2 = "";
    var option2 = "<option  value='"+str2+"'>"+str2+"</option>";
    $("#district1").append(option2);

})


</script>

</body>
</html>