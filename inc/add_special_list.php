<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$ztid = $_GET['ztid'];

if($ztid)
{
  $sql = "select * from e_user_zt where id=$ztid";
  $rs = fetchOne($sql);
  $uid = $rs['adduid'];
}
$addfo = 'http://imageserver.echao.com/';

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
    <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
<style>

body{
    padding:10px;
}

</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b><?php echo $rs['zt_name']?></b></legend>



<table >
<tr>
<td colspan="5">
<?php

$sql = "select a.id,b.style_no,b.style_name,b.style_thumb,b.best64 from e_user_zt_goods a,e_goods_sylte b where a.ztid='$ztid' and a.style_no=b.style_no";
$rs = fetchAll($sql);
for($i=0;$i<count($rs);$i++)
{
?>

<table width="200" border="0" cellspacing="0" cellpadding="0" style="float:left;margin:10px">
  <tr>
    <td height="200" align="center">
  
  <img src="http://imageserver.echao.com/<?=$rs[$i]['best64']?'imagespath/':''?><?=urldecode($rs[$i]['style_thumb'])?>" style="width:180px;height:180px">
  </td>
  </tr>
  <tr>
    <td height="25" align="center"><?=$rs[$i]['style_name']?> (<?=$rs[$i]['style_no']?>)</td>
  </tr>
 
</table>
<?
}
?></td>
</tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_special_cp.php";
  //创建一个编辑器
  var editIndex = layedit.build('LAY_demo_editor');
 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 1){
        return '款号不能为空';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });





</script>

</body>
</html>