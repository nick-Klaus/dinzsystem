<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$stu_type = $_GET['stu_type'];

$sql = "select * from e_user_stu where stu_type > 0 and adduid='".$_SESSION['uid']."'";
if( isset($stu_type) ){  $sql.=" and stu_type='".$stu_type."'"; }
$sql.= " order by id asc";
if( isset($stu_type) ){
    $page_get.="a=".$a."&stu_type=".$stu_type;
}else{
    $page_get.="a=".$a;
}
pages($sql,$s,$page_get,10);
//$res = fetchOne( $sql );

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
<fieldset class="layui-elem-field layui-field-title" style="margin:20px;">
  <legend><b>珠宝学院</b></legend>

<table class="layui-table">
 <tr  style=' background:#ffffff;'>
  <td style='border:none;width:60px; '> <a id="openpage" onclick="openpage()"  class="layui-btn"><i class="layui-icon"></i> 添加专题</a> </td>
  <td colspan="3" style='border:none;' align="center">
  <?php
  $sql_head = "select * from e_user_stu where  stu_type='0' and adduid=".$_SESSION['uid'];
  $row = fetchAll( $sql_head );
  $row = is_array($row)?$row:array();
  foreach ($row as  $k => $v) {
   echo "<span class='layui-btn' style='overflow:hidden;'><a  href='./jewelry_college.php?stu_type=".$v['id']."'  onclick='look()' class='layui-btn'>".$v['stu_name']."</a><a onclick='openpage4( ".$v['id']." )'   style='color:#FF6838;width:20px;display:inline-block;font-size:24px;float:right'>&times;</a></span>";

  }
  
  ?>
  
   </td>
  <td style='border:none;width:300px; ' >
    <form class="layui-form" action="">
      <input type="text" name="stu_name"  style='width:200px;float:left;margin-right:20px; ' placeholder="请输入课程项目" lay-verify="required"  autocomplete="off" class="layui-input">
      <button   class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
      </form>
  </td>
</tr>
    <tr style='background:#51545F;color:#ffffff;'>
      <th><b>标题</b></th>
      <th><b>缩略图</b></th>
      <th><b>时间</b></th>
      <th><b>课程列表</b></th>
      <th><b>操作</b></th>
    </tr> 
<?php
while($rs=mysql_fetch_array($results_date)) 
{
?> 
<tr align="center">
<td><?=$rs['stu_name']?></td>
<td><img  src='http://imageserver.echao.com/<?=$rs['stu_logo']?>' style="height:50px;width:60px;"></td>
<td style="line-height:14px;font-size:12px">
<?=date('Y-m-d H:i:s',$rs['times']);?>
</td>
<td><a  class="layui-btn" onclick="look()" href="lesson_list.php?stu_id=<?=$rs['id']?>"><i class="layui-icon"></i> 添加课程</a></td>
<td><a  class="layui-btn"  onclick="openpage2( <?=$rs['id']?> )" ><i class="layui-icon"></i></a><a class="layui-btn layui-btn-danger" onclick="openpage3( <?=$rs['id']?> )"  ><i class="layui-icon"></i></a></td>
</tr>
<?php
}
?>
<tr align='center' style=' background:#ffffff;'>
  <td colspan="5"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table> 


 

</fieldset>
<script src="../layui/layui.js" charset="utf-8"></script>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
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
//打开增加页面的弹出层
function  openpage(){

       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加课程专题',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '680px'],
                content: 'add_lesson.php'
            });
        });
}


//打开增加页面的弹出层
function  openpage2( id ){
       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑课程专题',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '680px'],
                content: 'edit_lesson.php?uid='+id
            });
        });
}

//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('与本专题相关的课程将全部清除，请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_lesson.php",
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

//ajax 顶级分类
function  openpage4( id ){
    var delid = id;
    layer.confirm('确定删除本课程项目吗，请谨慎操作！', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: "del_lesson.php",
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


layui.use(['form', 'layedit', 'laydate'], function(){


  var form = layui.form()
  ,layer = layui.layer
  ,layedit = layui.layedit
  ,laydate = layui.laydate;
  var adminurl="./addpro_lesson.php";

 //自定义验证规则
  form.verify({
    title: function(value){
      if(value.length < 2){
        return '项目名称至少为2个字符！';
      }
    }
    ,pass: [/(.+){6,12}$/, '密码必须6到12位']
    ,content: function(value){
      layedit.sync(editIndex);
    }
  });
  
 //监听提交
   form.on('submit(demo1)', function(data){
    //console.log(data);
    $.post(adminurl,data.field,function( json ){
       // console.log(json);
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
</script>
</body>
</html>