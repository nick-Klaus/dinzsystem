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
    body{
      min-width: 950px;
      overflow: auto;
    }
</style>
</head>
<body>
              
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>专题列表管理</b></legend>


<table class="layui-table">

    <tr  style=' background:#ffffff;'>
        <td style='border:none;width:60px; '> <button class="layui-btn" onclick="openpage()" title="添加专题" ><i class="layui-icon"></i> 添加专题</button></td>
        <td colspan="6" style='border:none;' align="center">
            <?php
            $sql_head = "select * from e_user_zt where  zt_type='0' and adduid=".$_SESSION['uid'];
            $row = fetchAll( $sql_head );
            $row = is_array($row)?$row:array();
            foreach ($row as  $k => $v) {
                echo "<span class='layui-btn' style='overflow:hidden;'>
                        <a  href='./special_list.php?zt_type=".$v['id']."'  onclick='look()' class='layui-btn'>".$v['zt_name']."</a>
                        <a onclick='openpage4( ".$v['id']." )'   style='color:#FF6838;width:20px;display:inline-block;font-size:24px;float:right'>&times;</a>
                      </span>";
            }

            ?>
        </td>
        <td style='border:none;width:300px; ' >
            <form class="layui-form" action="">
                <input type="text" name="zt_name"  style='width:40%;float:left;margin-right:20px; ' placeholder="请输入专题类别" lay-verify="required"  autocomplete="off" class="layui-input">
                <button   class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
            </form>
        </td>
    </tr>

<?php

$zt_type = $_GET['zt_type'];
$sql = "select * from e_user_zt ";

  $sql.="  where adduid='$c_uid' and zt_type > 0 ";

if( isset($zt_type) ){  $sql.=" and zt_type=".$zt_type;  }
$sql.= " order by sort asc";
if( isset($zt_type) ){
    $page_get.="&a=".$a."&zt_type=".$zt_type;
}else{
    $page_get.="a=".$a;
}

pages($sql,$s,$page_get,10);

?>
  <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td><b>添加ID</b></td>
  <td><b>专题名称</b></td>
  <td><b>缩略图</b></td>
  <td><b>横幅图</b></td>
  <td><b>专题排序</b><font size='1'>(双击修改，升序)</font></td>
  <td><b>时间</b></td>
  <td><b>专题产品</b></td>
  <td><b>操作</b></td>
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
            echo  "../images/timg.jpg";
        }
    ?>' style='width:70px;height:70px;'></td>
<td><img src='<?php
        if( $rs['zt_benner'] ){
            echo "http://imageserver.echao.com/".$rs['zt_benner'];
        }else{
            echo "../images/timg.jpg";
        }
    ?>' style='width:70px;height:70px;'></td>
<td style="line-height:14px;font-size:12px" width='150'>
<span class='editable1' id="<?php echo $rs['id'] ?>"   lang="<?php echo $rs['adduid'] ?>" ><?php echo $rs['sort'] ?></span>
</td>
<td style="line-height:14px;font-size:12px">
<?=date('Y-m-d H:i:s',$rs['times']);?>
</td>
<td><a href="add_special_cp.php?ztid=<?=$rs['id']?>" onclick='look()'  class="layui-btn" >添加专题产品</a></td>
<? if($rs['adduid']!=$c_uid){?>
<td colspan="2"></td>
<? }else{?>
<td><a  onclick='openpage1(<?=$rs['id']?>)' title='编辑' class="layui-btn" ><i class="layui-icon"></i></a>
<a  class="layui-btn layui-btn-danger" onclick='openpage3(<?=$rs['id']?>)'  title='删除' ><i class="layui-icon"></i></a></td>
<? }?>
</tr>

<?php
}
 
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="12" > <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

//修改排序
$(function(){
    $(".editable1").dblclick(function(){
        var edit_id = this.id;
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
           url: "editpro_special.php",
           data: "edit_id="+edit_id+"&uid="+lang+"&sort="+new_val,
           success: function(msg){ 
              if(msg == 'letgo'){
                layer.msg('修改成功');
                location.reload(); 
              }   
           }
        });
        //修改以后的数据替换input
        $(this).replaceWith( new_val );
        })   
    });
 });


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
  var adminurl="./addpro_special.php";

 
  //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 1){
        return '请输入专题类别名！';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });

//监听提交
form.on('submit(demo1)', function(data){
    console.log(data);
    $.post(adminurl,data.field,function( json ){
         console.log(json);
        if( json == 'go' ){
            layer.msg('增加成功');
            window.location.reload();
        }else{
            layer.msg('增加失败', function(){
            });
        }
    });
    return false;
});
});

//打开添加专题页面的弹出层
function  openpage(){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加专题',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '750px'],
                content: 'add_special.php'
            });
        });
}
//打开编辑专题页面的弹出层
function  openpage1( editid ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑专题',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '750px'],
                content: 'edit_special.php?id='+editid
            });
        });
}

//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('与此对应的专题产品全部删除，请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_special.php",
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

//ajax 删除顶级分类
function  openpage4( id ){
    var delid = id;
    layer.confirm('您确定要删除专题类别吗，请谨慎操作！', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: "del_special.php",
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