<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];
$sql = "select * from e_members  where uid=".$_GET['uid'];
$rs = fetchOne($sql);
$domain = $rs['domain'];
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
  <legend><b>编辑管理员</b></legend>
</fieldset>

<form class="layui-form" action="">
<input type="hidden" name="uid" value="<?=$rs['uid']?>">
  <div class="layui-form-item">
    <label class="layui-form-label">帐号：</label>
    <div class="layui-input-block">
      <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入帐号" class="layui-input" value="<?=$rs['username']?>" >
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">密码：</label>
    <div class="layui-input-block">
      <input type="text" name="password" lay-verify="pass" autocomplete="off" placeholder="请输入密码" class="layui-input" value="<?=$rs['password']?>"  >
    </div>
  </div>
    <div class="layui-form-item">
    <label class="layui-form-label">备注：</label>
    <div class="layui-input-block">
      <input type="text" name="user_bz" lay-verify="user_bz" autocomplete="off" placeholder="请输入备注" class="layui-input" value="<?=$rs['user_bz']?>"  >
    </div>
  </div>

<div class="layui-form-item"  style='height:30px;line-height:30px;'>
        <?
        if($domain)
         {
        ?>   
        <label class="layui-form-label">管理路径：</label>     
                 
        <div class="layui-input-block">
     
                     <?
                    // echo "select username from e_members where uid in (".$domain."0)";
                     $arr = fetchAll("select username from e_members where uid in (".$domain."0)");
                     for($i=0;$i<count($arr);$i++)
                     {
                        if($i>0) echo ' < ';
                        echo   "<span style='color:#1AA094;'>".$arr[$i]['username']."</span>";
                     }
                     ?>
              <?
              }
              ?>
     </div>
  </div>             
             

  <div class="layui-form-item">

  <div class="layui-form-item hid">
      <label class="layui-form-label">开通时间：</label>
      <div class="layui-inline">
        <input class="layui-input" name='regdate' placeholder="自定义日期格式" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo date('Y-m-d H:i:s',$rs['regdate'])?>">
      </div>
  </div>

    <div class="layui-inline"  style='height:45px;line-height:45px;'>
      <label class="layui-form-label">上级ID：</label>
      <div class="layui-input-inline" >
        <input type="number" name="cuid" lay-verify="number" autocomplete="off" class="layui-input" value="<?=$rs['cuid']?>" >
      </div>
      <span style='color:#009E94;' >（*上级id不能为0*）</span>
    </div>
    <div class="layui-form-item " >
      <label class="layui-form-label">菜单类型：</label>
      <div class="layui-input-inline">
          <input type="text" name="auth_type"  autocomplete="off" placeholder="请输入菜单类型" class="layui-input"  value="<?php echo $rs['auth_type']?$rs['auth_type']:1; ?>">
      </div>
      <label class="layui-form-label" style="color:#1AA094;width:500px;margin-left: -100px;">（1.只买设备,2.只买APP,3.两者都有,4.只买端口,5.上传款式账号）</label>
  </div>
 
 <div class="layui-form-item hid">
      <label class="layui-form-label">数据标识：</label>
      <div class="layui-input-inline">
          <input type="text" name="maydiakeys"  autocomplete="off" placeholder="请输入数据标识(关键字标识)" class="layui-input"  value="<?php echo $rs['maydiakeys'] ?>">
      </div>
      <label class="layui-form-label" style="color:#1AA094;">（关键字）</label>
  </div>
  <div class="layui-form-item hid">
      <label class="layui-form-label">数据标识：</label>
      <div class="layui-input-inline">
          <input type="text" name="maydiatable"  autocomplete="off" placeholder="请输入数据标识(表格标识)"  class="layui-input"  value="<?php echo $rs['maydiatable'] ?>">
      </div>
      <label class="layui-form-label" style="color:#1AA094;">（表 格）</label>
  </div>
  <div class="layui-form-item hid">
      <label class="layui-form-label">微信uid：</label>
      <div class="layui-input-inline">
          <input type="text" name="wei_uid"  autocomplete="off" placeholder="定制商城微信支付uid"  class="layui-input"  value="<?php echo $rs['wei_uid'] ?>">
      </div>
      
  </div>
 <div class="layui-form-item hid">
    <label class="layui-form-label">款式分类：</label>
    <div class="layui-input-block">
      <input type="radio" name="categorytype" value="0" title="系统数据" <?php if($rs['categorytype']=='0'){echo 'checked';}?>/ />
      <input type="radio" name="categorytype" value="1" title="全部数据" <? if($rs['categorytype']=='1'){echo 'checked';}?>/>
      <input type="radio" name="categorytype" value="2" title="除系统数据以外的全部数据" <? if($rs['categorytype']=='2'){echo 'checked';}?>/>
      <input type="radio" name="categorytype" value="3" title="自定义数据" <? if($rs['categorytype']=='3'){echo 'checked';}?>/>
    </div>
  </div>
  
  
    <div class="layui-form-item hid" >
    <label class="layui-form-label">裸石数据：</label>
    <div class="layui-input-block">
      <input type="radio" name="diamond_data_typ" value="0" title="B2B裸石数据" <?php if($rs['diamond_data_typ']=='0'){echo 'checked';}?> />
      <input type="radio" name="diamond_data_typ" value="2" title="B2C裸石数据" <?php if($rs['diamond_data_typ']=='2'){echo 'checked';}?> />
       <input type="radio" name="diamond_data_typ" value="1" title="B2C数据+自定义" <?php if($rs['diamond_data_typ']=='1'){echo 'checked';}?> />
      <input type="radio" name="diamond_data_typ" value="3" title="自定义数据" <?php if($rs['diamond_data_typ']=='3'){echo 'checked';}?> />
    </div>
  </div>
  <div class="layui-form-item hid" >
      <label class="layui-form-label">款式数据：</label>
      <div class="layui-input-block">
          <input type="radio" name="datatype" value="0" title="系统数据" <?php if($rs['datatype']=='0'){echo 'checked';}?> />
          <input type="radio" name="datatype" value="1" title="全部数据" <?php if($rs['datatype']=='1'){echo 'checked';}?> />
          <input type="radio" name="datatype" value="2" title="除系统数据以外的全部数据" <?php if($rs['datatype']=='2'){echo 'checked';}?> />
          <input type="radio" name="datatype" value="3" title="自定义数据" <?php if($rs['datatype']=='3'){echo 'checked';}?> />
      </div>
  </div>
  
   <div class="layui-form-item hid" >
    <label class="layui-form-label">营销.引流：</label>
    <div class="layui-input-block">
      <input type="radio" name="marketing" value="0" title="系统数据" <?php if($rs['marketing']=='0'){echo 'checked';}?> />
      <input type="radio" name="marketing" value="1" title="全部数据" <?php if($rs['marketing']=='1'){echo 'checked';}?> />
      <input type="radio" name="marketing" value="2" title="除系统数据以外的全部数据" <?php if($rs['marketing']=='2'){echo 'checked';}?> />
      <input type="radio" name="marketing" value="3" title="自定义数据" <?php if($rs['marketing']=='3'){echo 'checked';}?> />
    </div>
  </div>
     
      <div class="layui-form-item hid" >
          <label class="layui-form-label">培训：</label>
          <div class="layui-input-block">
              <input type="radio" name="train" value="0" title="系统数据" <?php if($rs['train']=='0'){echo 'checked';}?> />
              <input type="radio" name="train" value="1" title="全部数据" <?php if($rs['train']=='1'){echo 'checked';}?> />
              <input type="radio" name="train" value="2" title="除系统数据以外的全部数据" <?php if($rs['train']=='2'){echo 'checked';}?> />
              <input type="radio" name="train" value="3" title="自定义数据" <?php if($rs['train']=='3'){echo 'checked';}?> />
          </div>
      </div>

      <div class="layui-form-item hid"  >
          <label class="layui-form-label">专题套系：</label>
          <div class="layui-input-block">
              <input type="radio" name="thematic_sets" value="0" title="系统数据" <?php if($rs['thematic_sets']=='0'){echo 'checked';}?> />
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
     if( hidd != 1 ){
         $(".hid").css("display","none");
     }

 })

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="editpro_admin.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 1){
        return '帐号不能为空';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });

 //监听提交
   form.on('submit(demo1)', function(data){
   // console.log(data);
    $.post(adminurl,data.field,function( json ){
     // console.log(json);
        if( json == 'go' ){
            layer.msg('修改成功');
            //关闭子页面
            parent.location.reload();             
        }else{
            layer.msg('修改失败,上级id不能为0', function(){  
            });  
            console.log(json);
        }   
    });
    return false;
  }); 
});

</script>

</body>
</html>