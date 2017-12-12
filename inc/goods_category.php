<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

if( $_SESSION['uid'] ){
    $uid = $_SESSION['uid'];
    $sql = "select categorytype from e_members where uid='$uid'";
    $categorytype = fetchOne($sql)['categorytype'];
    $c_domain = $_SESSION['ch_domain'].$uid;
    // 层级关系拆分 去除最高管理员级
    $arr = explode(",",$c_domain);
	$str = implode(",", array_splice($arr,1)) ;
}else{
    $uid = 1;
}
//找出当前登录用户的倍率信息
if($categorytype == 1){
    //$sql = "select * from e_goods_category where  adduid = '$uid'  order by times desc ";
	$sql = "select * from e_goods_category where  adduid  in ($str) order by times desc ";

}else{
    if( $uid == 1  ){
        $sql = "select id,catename,webid,pid,adduid,box_default_ico,sort from e_goods_category where adduid='$uid' or adduid='0' order by times desc ";
    }else{
        $sql = "select id,catename,webid,pid,adduid,box_default_ico,sort from e_goods_category where adduid='$uid'  order by times desc ";
    }
}

$area = fetchAll($sql);
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
    .editable{color:#FA541F;font-weight:bold;}
</style>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>产品分类管理</b></legend>


<table class="layui-table" lay-even="" lay-skin="nob"  width='500'>
   <tr  style=' background:#ffffff;'>
        <td colspan="6" style='border:none;'>
            <a  id="openpage" onclick="openpage()"  class="layui-btn"><i class="layui-icon"></i> 添加分类</a>
            <?php
            if( $uid == 1 ){
              echo  "<a  id='openpage_son' onclick='openpage_son()'  class='layui-btn'><i class='layui-icon'></i> 添加珠宝鉴赏</a>";
            }
            ?>
        </td>
  </tr>
    <tr>
    <td  width="20%"></td>
     <td width="25%"><font size='3'><b>分 类 名</b></font><font size='1' color='#1AA094'>（*双击橙色字体可修改*）</font></td>
     <td width="15%"><font size='3'><b>分 类 排 序</b></font><font size='1' color='#1AA094'>（*双击修改，升序*）</font></td>
      <td width="25%"><font size='3'><b>默认图标</b></font><font size='1' color='#1AA094'>（*双击图框可修改图片建议尺寸 80*80 *）</font></td>
      <td width="10%"><font size='3'><b>操作</b></font></td>
    </tr>

  <tbody>
    <tr>
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
    <tr align='center'>
        <td ></td>
        <td align='left' ><span id="p<?=$v['id']?>" class="editable spanc1" lang="<?=$uid?>"><?php
           if($v['lev'] == 1){
            echo "<font size='3' color='#1AA094'>".str_repeat('',$v['lev']-1),$v['catename']."</font>";
           }else{
            echo "<span class='editable1' id=".$v['id']."  lang='".$uid."'  >".str_repeat('　　',$v['lev']-1),$v['catename']."</span>";
           }
          ?></span></td>
         <td ><span  class='editable3' id="<?php echo $v['id'] ?>"   lang='<?php echo $uid ?>'  ><?php echo $v['sort'] ?></span></td>
        <td>
        <img  id="<?php echo  $v['id']?>"   lang='"<?php echo $uid ?>"' src="<?php
            if( $v['box_default_ico'] ){
                echo "http://imageserver.echao.com/".$v['box_default_ico'];
            }else{
                echo "../images/timg.jpg";
            }
        ?>" style='width:45px;height:45px;background: #DEDEDE;' class='editable2' >
        </td>
        <td><a class="layui-btn layui-btn-danger"  title='删除' onclick="openpage3( <?php echo $v['id'] ?> )"  ><i class="layui-icon"></i></a></td>
    </tr>
<?php

}
?>
  </tbody>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>
 //点击出现表单，修改分类名
$(function(){
    $(".editable1").dblclick(function(){
        var id = this.id;
        var lang = this.lang;
        var text = $(this).text();
        var txt = $("<input type='text' name='catename' style='text-align:left;width:160px;height:40px;color:#ff0000;'>").val(text);
        $(this).html( txt );
        txt.trigger("focus");
        txt.blur(function(){
        var new_val=txt.val();
        //双击修改后，数据传入后台修改
        $.ajax({
           type: "POST",
           url: "edit_category.php",
           data: "id="+id+"&uid="+lang+"&catename="+new_val,
           success: function(msg){
              if(msg == 'go'){
                layer.msg('修改成功');
                location.reload();
               }
              //else{
              //   layer.msg('修改失败');
              //   location.reload();
              // }
           }
        });
        //修改以后的数据替换input
        $(this).replaceWith( new_val );
        })
    });
//修改排序
$(function(){
    $(".editable3").dblclick(function(){
        var id = this.id;
        var lang = this.lang;
        var text = $(this).text();
        var txt = $("<input type='text' name='sort' style='text-align:left;width:60px;height:40px;color:#ff0000;'>").val(text);
        $(this).html( txt );
        txt.trigger("focus");
        txt.blur(function(){
        var new_val=txt.val();
        //双击修改后，数据传入后台修改
        $.ajax({
           type: "POST",
           url: "edit_category.php",
           data: "id="+id+"&uid="+lang+"&sort="+new_val,
           success: function(msg){
              if(msg == 'go'){
                layer.msg('修改成功');
                location.reload();
              }
              // if( msg  == 'error' ){
              //   layer.msg('没有修改任何数据');
              //   //location.reload();
              // }
           }
        });
        //修改以后的数据替换input
        $(this).replaceWith( new_val );
        })
    });
 });
 //点击出现图片弹出层，修改图片
$(".editable2").dblclick(function(){
        var id = this.id;
        var lang = this.lang;
     var index = layer.open({
        type: 2,
        title: '我的图片库',
        shadeClose: true,
        shade: 0.8,
        area: ['65%', '70%'],
        content: './pic.php',//iframe的url
    });
     //抓取子窗口img的src，加入父窗口中
    window.top.document.image = function(src){
         var url= "uploadfile/"+src;
        $.ajax({
           type: "POST",
           url: "update_category_img.php",
           data: "id="+id+"&uid="+lang+"&url="+url,
           success: function(msg){
            if(msg == 'go'){
                layer.msg('修改成功');
                location.reload();
              }else{
                layer.msg('修改失败');
              }
           }
        });
        layer.close(index);
    }
});
});

function  openpage(){
   layer.config({
        extend: 'extend/layer.ext.js'
    });
    //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
    layer.ready(function() {
    var index = layer.open({
            type: 2,
            skin: 'layui-layer-molv',
            title: '添加产品分类',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['800px', '500px'],
            content: 'add_category.php'
        });
    });
}

 function  openpage_son(){
     layer.config({
         extend: 'extend/layer.ext.js'
     });
     //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
     layer.ready(function() {
         var index = layer.open({
             type: 2,
             skin: 'layui-layer-molv',
             title: '添加珠宝鉴赏',
             fix: false,
             shadeClose: true,
             maxmin: true,
             area: ['800px', '500px'],
             content: 'add_category_son.php'
         });
     });
 }


//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('您确定要删除本条数据吗？数据无价！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_category.php",
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