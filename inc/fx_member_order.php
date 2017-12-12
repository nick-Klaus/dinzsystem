<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$c_domain = $_SESSION['ch_domain'];

if( $c_uid == 1 ){
  $sql = "select a.*,b.username,b.nickname,b.webid,b.mobile_phone,d.uid,d.username as name  from e_order a,e_fx_members b,e_members d where   a.fxuid =b.uid and d.uid=b.webid";
}else{
  $sql = "select a.*,b.username,b.webid,b.nickname,b.mobile_phone,d.uid,d.username as name  from e_order a,e_fx_members b,e_members d where (a.uid in (select c.uid  from e_members c where c.domain like '$c_domain$c_uid,%') or a.uid='$c_uid') and  a.fxuid =b.uid and d.uid=b.webid ";
}


$username = trim($_GET['username']);
if( $username ){
  $sql.= " and  b.username='$username'";
  $page_get.="&a=".$a."&cls1=".$cls1."&cls2=".$cls2."&cls3=".$cls3."&username=".$username;
}else{
  $page_get.="&a=".$a;
}

$sql.= " order by a.id desc";

pages($sql,$s,$page_get,15);

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
    body{
      min-width: 950px;
      overflow: auto;
     }

</style>

</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend><b>订单管理</b></legend>
</fieldset>
<table class="layui-table">
<form action="fx_member_order.php">
  <tr style='background:#ffffff'><td colspan="4" style='border:none;'><a href='./phpexcel_down.php?username=<?php echo $username ?>' class="layui-btn" title="返回">导出订单</a>（在搜索框搜索以后可导出指定会员订单，没有搜索则导出全部订单！）</td> <td  style='border:none;'><!--  -->
  <div class="layui-form-item">
      <input type="text" name="username" lay-verify="title" autocomplete="off" placeholder="请输入下单会员" class="layui-input" style='width:100%;margin-top:15px' value="<?php echo $username ?>"> 
  </div>
  </td>
  <td style='border:none;'><button class="layui-btn" type="submit" title="查询">查询</button><a href='fx_member_order.php' class="layui-btn" title="返回">返回</a></td></tr>
</form>
  <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
    <td><b>状态</b></td>
    <td><b>订单号</b></td>
    <td><b>金额</b></td>
    <td><b>下单时间</b></td>
    <td><b>下单会员</b></td>
    <td width="140"><b>联系人</b></td>
    <td><b>联系电话</b></td>
    <td width="240"><b>操作</b></td>
  </tr>
  
  <?php
$orderarr = array('待处理',"<font color='#FA541F'>已付定金</font>","<font color='#3F48CC'>确认付款</font>","<font color='#5B2507'>确认发货</font>","<font color='#1AA094'>确认收货</font>","<font color='#E31818'>订单完成</font>");

while($rs=mysql_fetch_array($results_date)) 
{


?>


<tr align="center">
  <td><?=$orderarr[$rs['pay_id']]?></td>
  <td><?=$rs['order_no']?></td>

  <td><?=$rs['rmb']?></td>

  <td> <?=date('Y-m-d H:i:s',$rs['times'])?> </td>
  <td><span style="color:#FF5722;"><?=$rs['name']?></span> => <span style="color:#FF5722;"><?=$rs['username']?></span></td>
  <td><?=$rs['nickname']?></td>
  <td style="line-height:30px"><?=$rs['mobile_phone']?></td>
  <td ><a  href='orders_show_web.php?order_no=<?=$rs['order_no']?>' onclick='look()' class="layui-btn" title='编辑订单'><i class="layui-icon">&#xe642;</i></a>
  <?php
  //金嘉利定制的订单打印
  if( $c_uid == 19 ){
    echo '<a href="./print_orders_jaly_new.php?order_no='.$rs['order_no'].'" class="layui-btn" >打印订单</a>';
  }else{
     echo '<a href="./print_orders.php?order_no='.$rs['order_no'].'" class="layui-btn" >打印订单</a>';
  }


  ?>
  <button  onclick='openpage2( "<?=$rs['id']?>" )' class="layui-btn layui-btn-danger" title='删除'><i class="layui-icon"></i></button>
  </td>
</tr>

<?php
}

?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="8"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
</tr>
</table>

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
});

//ajax 删除数据
function  openpage2( id ){
  var delid = id;
  layer.confirm('您确定要删除吗？数据无价！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_fx_member_order.php",
         data: "delid="+delid,
         success: function(msg){
//          alert(msg);
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