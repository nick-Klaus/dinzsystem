<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];

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
     tr:hover{ 
        background:#ABB0C1;
     }
     .frist_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
    .up_page{
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
    .next_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }

    .end_page{
        
        display:inline-block;
        height:30px;
        line-height:30px;
        width:45px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
        margin-right:15px;
     }
     .end_page:hover{
        color:#ffffff;
     }
     .next_page:hover{
        color:#ffffff;
     }
     .up_page:hover{
        color:#ffffff;
     }
     .frist_page:hover{
        color:#ffffff;
     }

     #this_page{
             display:inline-block;
        height:30px;
        line-height:30px;
        width:30px;
        text-align:center;
        background:#009688;
        color:#ffffff;
        border-radius:3px;
     }
</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>会员专题列表</b></legend>
<table class="layui-table">

<?php
$sql = "select * from e_user_zt ";
$sql.="  where adduid > 1 and zt_type > 0 ";
$sql.= " order by sort asc";
pages($sql,$s,$page_get,10);

?>
  <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td><b>添加ID</b></td>
  <td><b>专题名称</b></td>
  <td><b>缩略图</b></td>
  <td><b>横幅图</b></td>
  <td><b>添加时间</b></td>
  <td><b>专题产品</b></td>

  </tr>
  
  <?php

while($rs=mysql_fetch_array($results_date)) 
{

?>


<tr align="center">
<td><?=$rs['adduid']?></td>
<td><?=$rs['zt_name']?></td>
<td><img src='<?php
        if( $rs['zt_logo'] ){
            echo "http://imageserver.echao.com/".$rs['zt_logo'];
        }else{
            echo "../images/timg.jpg";
        }
    ?>' style='width:70px;height:70px;'></td>
<td><img src='<?php
        if( $rs['zt_benner'] ){
            echo "http://imageserver.echao.com/".$rs['zt_benner'];
        }else{
            echo "../images/timg.jpg";
        }
    ?>' style='width:70px;height:70px;'></td>

<td style="line-height:14px;font-size:12px">
<?=date('Y-m-d H:i:s',$rs['times']);?>
</td>
<td><a href="add_special_list.php?ztid=<?=$rs['id']?>" onclick='look()'  class="layui-btn" >查看专题产品</a></td>

</tr>

<?php
}
 
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="11" > <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
//点击按钮的动画效果
function look(){
var index = layer.load(0, {shade: false});
    setTimeout(function(){
         layer.close( index );
    }, 1000);
}

layui.use(['form', 'layedit', 'laydate'], function(){

  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;

});

</script>

</body>
</html>