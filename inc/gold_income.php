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
            <!-- http://weixin.echao.com/app/index.php?i=4&c=entry&do=modules&m=ims_t_wisdom&webid=<?php echo $_GET['webid']; ?>   -->
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>管理金生钱</b></legend>

<iframe src="http://weixin.echao.com/app/index.php?i=4&c=entry&webid=<?php echo $_GET['webid'] ?>&do=manage&m=t_wisdom" name="right" style='width:100%;height:900px;border:none;'></iframe> 

</fieldset>



</body>
</html>