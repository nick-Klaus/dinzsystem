<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];  
$ch_domain = $_SESSION['ch_domain'];

$lxr = trim($_GET['lxr']);
$sql = "";
if( $lxr ){
    $sql .= " and a.lxr like '%$lxr%'";
}
$mob = trim($_GET['mob']);
if( $mob ){
    $sql .= " and a.mob like '%$mob%'";
}
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$start =  strtotime($start_date);
$end   =  strtotime($end_date);
if( $start_date && $end_date ){
    $sql .= " and a.times BETWEEN  $start and $end ";
}
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
     body{
      min-width: 1000px;
      overflow: auto;
      }
     
</style>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>订单管理</b></legend>


<?
if($delid)
{
   $sql = "delete from  e_order  where order_no = '$delid'";
    mysql_query($sql,$db) or db_error();
    header("Location:".$_SERVER['HTTP_REFERER']);
}
function get_mac_info($macid)
{
    $sqlinfo = "select mac_tit from e_mac_set where macid=$macid";
    return(fetchOne($sqlinfo));
}
?>
<table class="layui-table" >
<?php
if($ch_domain == 0){

$sql_sum = "select SUM(a.rmb) as rmball from e_order_mac a,e_mac_code b,e_members d where (a.uid in (select c.uid from e_members c where c.domain like '$uid,%') or b.uid='$uid') and  a.macid=b.id  and b.uid=d.uid " .$sql. " order by a.id desc";
$sql = "select a.*,b.openid,b.id as macid,b.uid,b.mac_remark,d.user_bz,b.user_remark from e_order_mac a,e_mac_code b,e_members d where (a.uid in (select c.uid from e_members c where c.domain like '$uid,%') or b.uid='$uid') and  a.macid=b.id  and b.uid=d.uid " .$sql. " order by a.id desc";

}else{

$sql_sum = "select SUM(a.rmb) as rmball  from e_order_mac a,e_mac_code b,e_members d where (a.uid in (select c.uid from e_members c where c.domain like '$ch_domain$uid,%') or b.uid='$uid') and  a.macid=b.id and b.uid=d.uid  " .$sql. " order by a.id desc";

$sql = "select a.*,b.openid,b.id as macid,b.uid,b.mac_remark,d.user_bz,b.user_remark  from e_order_mac a,e_mac_code b,e_members d where (a.uid in (select c.uid from e_members c where c.domain like '$ch_domain$uid,%') or b.uid='$uid') and  a.macid=b.id and b.uid=d.uid  " .$sql. " order by a.id desc";


}
/*
$sql = "select a.*,b.openid from e_order a,e_mac_code b where a.macid=b.id ";
if($uid!=1) $sql.= " and a.uid = '$uid'";
$sql.= " order by a.id desc";
*/
$page_get.="&a=".$a."&lxr=".$lxr."&mob=".$mob."&start_date=".$start_date."&end_date=".$end_date;
pages($sql,$s,$page_get,10);
$num =  fetchOne($sql_sum); // 统计定单的总金额
?>
    <tr><td colspan="8" style='background:#ffffff;border: none'>
    <table width="100%">
        <tr style='background:#ffffff;'>
            <form action="./orders_list.php">
                <td width="260" style="border: none">
                    订单总额：<span style="color: #ff0000;font-weight: bold"><?php echo $num['rmball']?$num['rmball']:0; ?></span> 元
                </td>
                <td width="200" style="border: none"><input name="lxr" type="text" lay-verify="title" autocomplete="off"
                                       placeholder="请输入联系人" class="layui-input" value="<?php echo $lxr; ?>"/></td>
                <td width="200" style="border: none"><input name="mob" type="text" lay-verify="title" autocomplete="off" placeholder="请输入联系电话" class="layui-input" value="<?php echo $mob; ?>"/>
                </td>
                <td width="200" style="border: none">
                     <input class="layui-input" name='start_date' placeholder="请输入开始时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $start_date?>">
                </td>
                <td width="200" style="border: none">
                    <input class="layui-input" name='end_date' placeholder="请输入结束时间" onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})" value="<?php echo $end_date?>">
                </td>
                <td style="border: none"><input type="submit" class="layui-btn" value="查询"></td>
            </form>
        </tr>
    </table>
    </td></tr>
  <tr  style='background:#51545F;color:#ffffff;'>
    <th>订单状态</th>
    <th>订单号</th>
    <th>金额</th>
    <th>联系人</th>
    <th>联系电话</th>
    <th>下单时间</th>
    <th>下单设备</th>
    <th width="280">管理</th>
  </tr>
  
<?php

while($rs=mysql_fetch_array($results_date)) 
{

?>

<tr align='center'>
    <td><?php 
    switch ( $rs['pay_id'] ) {
        case '0':
        echo '<b>待处理</b>';          
        break;
        case '1': 
        echo "<font color='#22B14C'><b>已经确认</b></font>";         
        break;
        case '2':  
        echo "<font color='#3F48CC'><b>确认付款</b></font>";        
        break;
        case '3':  
        echo "<font color='#FF7F27'><b>确认发货</b></font>";        
        break;
        case '4':
        echo "<font color='#A349A4'><b>确认收货</b></font>";          
        break;
        case '5': 
        echo "<font color='#ED1C24'><b>订单完成</b></font>";         
        break;
      }  
    ?></td>  
    <td><?=$rs['order_no']?></td>
    <td><?=$rs['rmb']?></td>
    <td><?=$rs['lxr']?></td>
  <td ><?=$rs['mob']?></td>
  <td> <?=date('Y-m-d H:i:s',$rs['times'])?> </td>
  <td>
  <?=$rs['openid']?>
  <div style=' height:34px;line-height:34px;'>
  <?php
  echo '<font style="font-size:9px;color:#ff6600">'.get_mac_info($rs['macid'])['mac_tit'].'</font>';
  if( $uid == 1 || $uid == 4){
      echo '<font style="font-size:9px;color:#ff6600">'.$rs['user_bz'].$rs['mac_remark'].'</font>';
  }else{
      echo '<font style="font-size:9px;color:#ff6600">'.$rs['user_remark'].'</font>';
  }
  ?>
  </div>
  </td>
    <td width="350">
    <a  class="layui-btn" onclick="look()" title='详情' href="orders_show.php?order_no=<?=$rs['order_no']?>" ><i class="layui-icon"></i></a>
    <a href="./print_orders_mac.php?order_no=<?=$rs['order_no']?>" class="layui-btn" >打印订单</a>
    <?php
    if( $uid == 201 ){
        echo "<a href='print_orders_meiyi.php?order_no=".$rs['order_no']."' class='layui-btn' >打印</a>";
    }
    ?>
    <a class="layui-btn layui-btn-danger" title='删除' onclick='openpage3( "<?=$rs['id']?>" )'  ><i class="layui-icon"></i></a>
    </td>
</tr>

<?php
}
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="8"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

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
    var adminurl="editpro_admin.php";
    //创建一个编辑器
    var editIndex = layedit.build('LAY_demo_editor');
});

//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('您确定要删除本条数据吗？数据无价！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_order.php",
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