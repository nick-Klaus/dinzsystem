<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

if( $_GET['look_uid'] ){
    $uid = $_GET['look_uid'];
}else{
    $uid = $_SESSION['uid'];  
}
$sql = "select categorytype,domain from e_members where uid='$uid'";

$res = fetchOne($sql);

$domain = $res['domain'];

$categorytype = $res['categorytype'];

//找出当前登录用户的倍率信息
 if( $categorytype  == 0 ){
          //系统数据
          $area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='1'");

      }elseif( $categorytype  == 1 ){
          //全部数据
          $area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid in(1,$uid) ");

      }else{
        //除系统以外和自定义数据
          $area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='$uid'");
      }
//$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='1'");  

$area = isset($area)?$area:array();


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
</head>
<style>
    .layui-table td1{border:none;}
    .am-u-sm-4 {margin-top:10px;height:20px;}
    .am-u-sm-8 {margin-top:10px;height:20px;}
    .editable{color:#FA541F;}
</style>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>货品倍率</b></legend>

 
<table class="layui-table" lay-even="" lay-skin="nob"  width='500'>

  <thead>
    <tr >
    <td></td>
     <td><font size='3'><b>类 别<b></font></td>  
      <td colspan='2' ><font size='4'><b>折 扣</b></font></td>
      
    </tr> 
  </thead>
  <tbody>
    <tr>
    <td  width='300'></td>
    <td align='left' width='300' ><div class="am-g">
     <div class="am-u-sm-4"><b>  裸钻：</b></div>
    <div class="am-u-sm-4">  重量 < 0.3ct </div>
    <div class="am-u-sm-4">  0.3ct >= 重量 < 0.39ct </div> 
    <div class="am-u-sm-4">  0.4ct >= 重量 < 0.49ct </div>     
    <div class="am-u-sm-4">  0.5ct >= 重量 < 0.59ct </div>     
    <div class="am-u-sm-4">  0.6ct >= 重量 < 0.69ct </div>    
    <div class="am-u-sm-4">  0.7ct >= 重量 < 0.79ct </div>    
    <div class="am-u-sm-4">  0.8ct >= 重量 < 0.89ct </div>     
    <div class="am-u-sm-4">  0.9ct >= 重量 < 0.99ct </div>     
    <div class="am-u-sm-4">  1.0ct >= 重量 < 1.99ct </div>
    <div class="am-u-sm-4">  2.0ct >= 重量 < 2.99ct </div>
    <div class="am-u-sm-4">  重量 >= 3ct </div>
</div></td>
      <td align='left' width="300">
      <div class="am-u-sm-8  spanc1" id="p01" lang="<?=$uid?>"></div><!-- <?php echo show_zk_s($uid,'p0','')*100?> -->
      <div class="am-u-sm-8 editable spanc1" id="p01" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p01','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p02" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p02','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p03" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p03','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p04" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p04','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p05" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p05','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p06" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p06','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p07" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p07','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p08" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p08','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p09" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p09','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p10" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p10','')*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p11" lang="<?=$uid?>"><?php echo show_zk_s($uid,'p11','')*100?></div>
      </td>
      <td align='left' style='line-height:30px;' >
        <? if($uid==1){?>
         <!-- <?=show_zk($uid,'p0',$domain)?> --> <br> 

        <?=show_zk($uid,'p01',$domain)?><br>

        <?=show_zk($uid,'p02',$domain)?><br>

        <?=show_zk($uid,'p03',$domain)?><br>

        <?=show_zk($uid,'p04',$domain)?><br />

        <?=show_zk($uid,'p05',$domain)?> <br>

        <?=show_zk($uid,'p06',$domain)?><br>

        <?=show_zk($uid,'p07',$domain)?><br>

        <?=show_zk($uid,'p08',$domain)?><br>

        <?=show_zk($uid,'p09',$domain)?><br/>

        <?=show_zk($uid,'p10',$domain)?><br/>

        <?=show_zk($uid,'p11',$domain)?><br/>
        <? }?>
        </td>
    </tr>
<?php
//无限级分类
function subtree2($arr,$id=0,$lev=1) {
     $subs = array(); //子孙数组
    foreach ($arr as $v) {
        if ($v['pid'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; //举例说array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs, subtree2($arr,$v['id'],$lev+1));
        }
    }
    return $subs;
}
$tree = subtree2($area,0,1);
foreach ($tree as $v) {
     
?>   
    <tr>
        <td></td>
        <td align='left' style='height:24px;'><?php if( $v['lev'] == 1 ){  echo '<b>'.str_repeat('　　',$v['lev']-1),$v['catename'].'　:'.'</b>';}else{ echo str_repeat('　　',$v['lev']-1),$v['catename'].'　:'; } ?></td>
        <td>
        <span id="p<?=$v['id']?>" class="editable spanc1" lang="<?=$uid?>"><?php if( $v['lev'] == 2 ){ echo show_zk_s($uid,'p'.$v['id'],'')*100;} ?></span>
        </td>
        <td><? if($uid==1){?><?php if( $v['lev'] == 2 ){ echo show_zk($uid,'p'.$v['id'],$domain); } ?><? }?></td>
    </tr>
<?php 

} 
?>
  </tbody>
</table>  
</fieldset>    
<script src="../layui/layui.js" charset="utf-8"></script>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>
//   $(function(){
//     $(".editable").dblclick(function(){
//         var id = this.id;
//         var lang = this.lang;
//         var text = $(this).text();
//         var txt = $("<input type='text' name='new_data' style='width:60px;height:20px;color:#ff0000;'>").val(text);
//         $(this).html( txt );
//         txt.trigger("focus"); 
//         txt.blur(function(){
//         var new_val=txt.val();
//         //双击修改后，数据传入后台修改
//         $.ajax({
//            type: "POST",
//            url: "edit_member_zk.php",
//            data: "clsid="+id+"&uid="+lang+"&zk="+new_val,
//            success: function(msg){   
//                 if( msg == "go" ){
//                    layer.msg('修改成功', {  time: 1000,  });
//                     location.reload();
//                 }else{
//                    layer.msg('修改失败', {  time: 1000,  });
//                 }                   
//            }
//         });
//         //修改以后的数据替换input
//         $(this).replaceWith( new_val );
//         })   
//     });
// });

</script>

</body>
</html>