<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
//会员组和会员的折扣
$uid1 = $_SESSION['uid'];
if( $_GET['group_id'] ){
  $group_id = $_GET['group_id'];
}

$sql = "select * from e_member_group_zk where group_id='$group_id' and uid='$uid1'";
$group_res = fetchOne($sql);
$uid = $group_res['uid'];
if( !$group_res ){
    //分组的倍率在e_member_zk不存在则加入系统的倍率
    $sy_sql = "select * from e_member_group_zk where uid='1' and group_id='0'";
    $system = fetchAll($sy_sql);
    $system_arr = array();
    foreach ($system as $k => $v) {
      $v['uid'] = $uid1;
      $v['group_id'] = $group_id;
      unset($v['id']);
      insert($v,'e_member_group_zk');
    }  
}
 function look_zk($uid,$clsid,$group_id ){

    //当前组所在的uid的所有折扣数据
    $date_sql1 = "select * from e_member_group_zk where uid='$uid' and  clsid='$clsid' and group_id='$group_id'";
    $date1 = fetchOne( $date_sql1 )['zk']/100;
    if( $date1 ){
      return  $date1;
    }else{
      return  1;
    }
}

//找出所有的类别
$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='1'");  
$area = isset($area)?$area:array();
//ajax传来需要修改的倍率 
$clsid1=$_POST['clsid'];
$groupid=$_POST['group_id'];
$zk1=$_POST['zk'];
if( $clsid1  &&  $groupid ){

  $where="clsid='".$clsid1."'  and  group_id='".$groupid."'";
  $sql = "select * from  e_member_group_zk where ".$where;
  if(is_array( fetchOne($sql) )){
     update(array( "zk"=> $zk1 ),'e_member_group_zk',$where);
  }else{
      $arr = array(
        "zk"=> $zk1,
        "clsid"=> $clsid1,
        "group_id"=> $groupid,
        "uid"=> $uid1,
        );
     insert( $arr,"e_member_group_zk");
  }
  
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
</head>
<style>
    .layui-table td1{border:none;}
    .am-u-sm-4 {margin-top:10px;height:20px;}
    .am-u-sm-8 {margin-top:10px;height:20px;}
    .editable{color:#FA541F;}
</style>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>会员组倍率</b></legend>

 
<table class="layui-table" lay-even="" lay-skin="nob"  width='500'>

  <thead>
    <tr >
    <td></td>
     <td><font size='3'><b>类 别<b></font></td>  
      <td colspan='2' ><font size='4'><b>折 扣</b></font><font size='1' color='#1AA094'>（*双击可修改*）</font></td>
      
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
    <div class="am-u-sm-4">   2.0ct >= 重量 < 2.99ct </div>
    <div class="am-u-sm-4">   重量 >= 3ct </div>
</div></td>
       <td align='left' width="300">
      <div class="am-u-sm-8 editable spanc1" id="p0" lang="<?=$group_id?>"><?php echo look_zk($uid,'p0',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p01" lang="<?=$group_id?>"><?php echo look_zk($uid,'p01',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p02" lang="<?=$group_id?>"><?php echo look_zk($uid,'p02',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p03" lang="<?=$group_id?>"><?php echo look_zk($uid,'p03',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p04" lang="<?=$group_id?>"><?php echo look_zk($uid,'p04',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p05" lang="<?=$group_id?>"><?php echo look_zk($uid,'p05',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p06" lang="<?=$group_id?>"><?php echo look_zk($uid,'p06',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p07" lang="<?=$group_id?>"><?php echo look_zk($uid,'p07',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p08" lang="<?=$group_id?>"><?php echo look_zk($uid,'p08',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p09" lang="<?=$group_id?>"><?php echo look_zk($uid,'p09',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p10" lang="<?=$group_id?>"><?php echo look_zk($uid,'p10',$group_id)*100?></div>
      <div class="am-u-sm-8 editable spanc1" id="p11" lang="<?=$group_id?>"><?php echo look_zk($uid,'p11',$group_id)*100?></div>
      </td>
      <td align='left' style='line-height:30px;' >
        
        <?=look_zk($uid,'p0',$group_id)?> <br>

        <?=look_zk($uid,'p01',$group_id)?><br>

        <?=look_zk($uid,'p02',$group_id)?><br>

        <?=look_zk($uid,'p03',$group_id)?><br>

        <?=look_zk($uid,'p04',$group_id)?><br/>

        <?=look_zk($uid,'p05',$group_id)?> <br>

        <?=look_zk($uid,'p06',$group_id)?><br>

        <?=look_zk($uid,'p07',$group_id)?><br>

        <?=look_zk($uid,'p08',$group_id)?><br>

        <?=look_zk($uid,'p09',$group_id)?><br/>

        <?=look_zk($uid,'p10',$group_id)?><br/>

        <?=look_zk($uid,'p11',$group_id)?><br/>
        
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
        <span id="p<?=$v['id']?>" class="editable spanc1" lang="<?php echo $group_id; ?>"><?php if( $v['lev'] == 2 ){ echo look_zk($uid,'p'.$v['id'],$group_id)*100;} ?></span>
        </td>
        <td><? if($uid==1){?><?php if( $v['lev'] == 2 ){ echo look_zk($uid,'p'.$v['id'],$group_id); } ?><? }?></td>
    </tr>
<?php 

} 
?>
  </tbody>
</table>  
</fieldset>    
<script src="../layui/layui.js" charset="utf-8"></script>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script>
  $(function(){
    $(".editable").dblclick(function(){
        var id = this.id;
        var lang = this.lang;
        var text = $(this).text();
        var txt = $("<input type='text' name='new_data' style='width:60px;height:20px;color:#ff0000;'>").val(text);
        $(this).html( txt );
        txt.trigger("focus"); 
        txt.blur(function(){
        var new_val=txt.val();
        //双击修改后，数据传入后台修改
        $.ajax({
           type: "POST",
           url: "group_zk.php",
           data: "clsid="+id+"&group_id="+lang+"&zk="+new_val,
           success: function(msg){
            location.reload();          
           }
        });
        //修改以后的数据替换input
        $(this).replaceWith( new_val );
        })   
    });
});

</script>

</body>
</html>