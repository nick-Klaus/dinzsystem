<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

if( $_GET['uid'] ){
  $uid = $_GET['uid'];
}else{
  $uid = $_SESSION['uid'];
}

$sql = "select * from e_mac_service where service_type='0' and adduid=".$uid;
$sql.= " order by id desc";
$page_get.="&a=".$a;
pages($sql,$s,$page_get,10);

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
  <legend><b>营销管理</b></legend>

<table class="layui-table">
 <tr  style=' background:#ffffff;'>
      <td colspan="6" style='border:none;'><a  id="openpage" onclick="openpage('<?php echo $uid ?>')"  class="layui-btn"><i class="layui-icon"></i> 添加配置</a>
      </td>
</tr>
    <tr style='background:#51545F;color:#ffffff;'>
      <th><b>标题</b></th>
      <th><b>图标</b></th>
      <th><b>链接地址</b></th>
      <th><b>操作</b></th>
    </tr> 
  
  <?php
while($rs=mysql_fetch_array($results_date)){

?>
<tr align='center'>
    <td><?=$rs['service_tit']?></td>
    <td><img src="http://imageserver.echao.com/<?=$rs['service_logo']?>" alt="" style='width:65px;height:50px;'></td>
    <td><input name="service_url" type="text" id="service_url" value="<?=$rs['service_url']?>" style="width:100%; height:30px;" /></td>
    <td width='200'><a  class="layui-btn"  onclick="openpage2( <?=$rs['id']?> )" ><i class="layui-icon"></i></a><a class="layui-btn layui-btn-danger" onclick="openpage3( <?=$rs['id']?> )"  ><i class="layui-icon"></i></a>
     </td>
    <!--<td><span class="dellist" lang="?a=<?=$a?>&delid=<?=$rs['id']?>"><i class="am-icon-close"></i></span></td>-->
</tr>

<?php
}
?>

<tr align='center' style=' background:#ffffff;'>
  <td colspan="4"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>  
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>
//打开增加页面的弹出层
function  openpage( uid ){

       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加营销配置',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1050px', '800px'],
                content: 'add_marketing.php?uid='+uid
            });
        });
}
//打开编辑页面的弹出层
function  openpage2( id ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑营销配置',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1050px', '800px'],
                content: 'edit_marketing.php?uid='+id
            });
        });
}

//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('确定要删除本条数据吗？数据无价请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_marketing.php",
         data: "delid="+delid,
         success: function(msg){
            if(msg  == 'go' ){
                layer.msg('删除成功', {  time: 1000,  });
                 window.location.reload();
            }else{
                layer.msg('删除失败', {  time: 1000,  });
            }
         }
      });
  }, function(){
  });
}




</script>
</body>
</html>