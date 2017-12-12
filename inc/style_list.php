<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$sql = "select cuid,auth_type,categorytype from e_members where uid='$c_uid'";
$_auth_res = fetchOne($sql);
$categorytype = $_auth_res['categorytype'];
$cuid = $_auth_res['cuid'];
$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid=".$c_uid);  

$area = isset($area)?$area:array();
$tcls1 = $_GET['cls1'];
$tcls2 = $_GET['cls2'];
//款号
$keys = trim($_GET['keys']);
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
     .layui-form-item select{
          width:200px;
          height:35px;
         border:1px solid #ccc;
         font-size:14px;
         -webkit-appearance: none;
     }
    .img_hover:hover{
      transform:scale(3);/*指的是放大的倍数*/
    }
    body{
      min-width: 950px;
      overflow: auto;
    }

</style>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>款式管理</b></legend>

<form  action="" id='form1'>
<table class="layui-table">
<tr style='background:#ffffff;'>
<td style='border:none;'> <a  onclick='openpage()'   class="layui-btn" ><i class="layui-icon"></i>款式添加</a></td>
<td colspan="2" style='border:none;'>
  <div class="layui-form-item" style=" margin-top:15px;text-align:right;width:100% ">
  <select name="cls1" id='bigname' style='padding:0px 10px;width: 40%;'>
  <option value=""> 请选择顶级分类</option>
<?php


 if( $categorytype == 0 ){
          $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid='1'");
      }elseif( $categorytype == 1 ){
          $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid in(1,$c_uid) ");
      }else{
          $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid='$c_uid)'");
      }

foreach ($arr1 as $v) {
?>
         <option value="<?php echo $v['id'] ?>"  <?php  if( $v['id'] ==  $cls1){ echo 'selected'; } ?>  > <?php echo $v['catename']; ?></option>
 <?php
}
 ?>      
 </select>　　


<!-- 二级联动的子级 -->
  <select name="cls2" id='smallname' style='padding:0px 10px;width: 40%;'>
  <option value="">请选择子级分类</option>
   
 </select>
</div>
</td>

<td  colspan="7" style='border:none;'>
<!-- <input type="text" name="factory_no" lay-verify="title" autocomplete="off" placeholder="请输入款号" class="layui-input" style='width:300px; float:left; '> -->
<input type="text" name="keys" id='keys' lay-verify="title" autocomplete="off" placeholder="请输入款号或款名" class="layui-input" style='width:30%; float:left;margin:0px 25px 0px 15px;' value="<?php if( $keys ){ echo $keys; }?>" >
<button  class="layui-btn" lay-submit=""  id='form2' onclick="look()" >提交查询</button>
<a href='./style_list.php' class="layui-btn" onclick="look()" >返回</a>
</td>
</form>
</tr>
<?php
if( $c_uid > 1 ){
  $sql = "select * from e_goods_sylte  where displays = 0 and adduid='$c_uid' and qdz_type=0";
}else{
  $sql = "select * from e_goods_sylte  where adduid > 1 ";
}


if($cls1) $sql.=" and cls1='$cls1' ";
if($cls2) $sql.=" and cls2='$cls2' ";
if($cls3) $sql.=" and cls3='$cls3' ";
if($keys) $sql.=" and (style_no like '$keys%' or factory_no like '$keys%') and displays = 0 ";
$sql.= " order by style_new desc,id desc";
$page_get.="&cls1=".$cls1."&cls2=".$cls2."&cls3=".$cls3."&keys=".$keys;
pages($sql,$s,$page_get,10);

?>
  <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td><b>图片</b></td>
  <td><b>品名</b></td>
  <td><b>款号</b></td>
  <td ><b>现货库存</b></td>
  <td colspan="4"><b>款式属性</b></td>
  <td><b>现货列表</b></td>
  <td width="260"><b>定制详情</b></td>
  <td><b>向上排序</b></td>
  </tr>
<?php
while($rs=mysql_fetch_array($results_date)) 
{

    if( $rs['best64'] == 1 ){
        $img_url = 'http://imageserver.echao.com/imagespath/'.urldecode($rs['style_thumb']);
    }else{
        $img_url = 'http://imageserver.echao.com/'.urldecode($rs['style_thumb']);
    }

?>
<tr align="center">
  <td><img src="<?php echo $img_url?>" style="width:60px;height:60px" class='img_hover'></td>
  <td><?=$rs['style_name']?></td>
  <td><?=$rs['style_no']?></td>
  <td > 库存 (<?php echo $rs['stocks']?>)</td>
  <td style="font-size:12px"><?=$rs['style_sort']?'<span  style="color:red">有银版</span>':'银版'?></td>
  <td style="font-size:12px"><?=$rs['style_new']?'<span  style="color:red">新款</span>':'新款'?></td>
  <td style="font-size:12px"><?=$rs['style_hot']?'<span  style="color:red">畅销</span>':'畅销'?></td>
  <td style="font-size:12px"><?=$rs['style_mode']?'<span style="color:red">可定制</span>':'定制'?></td>
  <td><a href="spot_list.php?style_no=<?=$rs['style_no']?>&style_name=<?=$rs['style_name']?>&cls2=<?=$rs['cls2']?>" onclick='openpage4("<?=$rs['style_no']?>","<?=$rs['id']?>")'  class="layui-btn" >现货列表</a></td>
  <td >
      <a onclick='openpage2(<?php echo $rs['id'] ?>)' title='编辑' class="layui-btn" ><i class="layui-icon"></i></a>
      <?php
        if( $_auth_res['auth_type'] == 5 ){
            echo " <a onclick='openpage5( ".$rs['id'].",".$cuid." )' title='添加到管理者' class=\"layui-btn\" >添加到管理者</a>";
        }
      ?>
      <a  class="layui-btn layui-btn-danger" onclick='openpage3(<?php echo $rs['id'] ?>)'  title='删除' ><i class="layui-icon"></i></a>
  </td>
  <td style="font-size:24px;"><button onclick='openpage6(<?php echo $rs['id'] ?>,<?php echo $rs['style_new'] ?>)' title='向上排序' class="layui-btn" ><b>↑</b></button></td>
</tr>

<?php
}
 
?>

<tr align='center' style=' background:#ffffff;'>
  <td colspan="11"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
  </tr>
</table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>

//ajax传输顶级分类的id到style_ajax.php
  function getSelectVal(){ 
  	var defval = "<?php echo $tcls2 ?>";
  	if($("#bigname").val() == 0 ){
	    $("#smallname").css('display','none');
	  }else{
	    $("#smallname").css('display','');
	}
    $.getJSON("style_ajax.php",{bigname:$("#bigname").val()},function(json){    
    var smallname = $("#smallname"); 
     //清空原有的选项 
     $("option",smallname).remove();
    $.each(json,function(index,array){
      //将返回的子级数据加入到子级分类的框中
	     if( defval == array['id'] ){
	      	var  option = "<option  selected='selected'  value='"+array['id']+"'>"+array['catename']+"</option>"
	      }else{
	      	var option = "<option   value='"+array['id']+"'>"+array['catename']+"</option>";
	    }
      smallname.append(option); 
    }); 
  }); 
} 

//触发下拉框变化
$(function(){ 
  getSelectVal(); 
  $("#bigname").change(function(){ 
    getSelectVal(); 
  }); 

}); 

//点击按钮的动画效果
function look(){
var index = layer.load(0, {shade: false});
    setTimeout(function(){
         layer.close( index );
    }, 1000);
}

//ajax 删除数据
function  openpage5( editid,cuid ){
    layer.config({
        extend: 'extend/layer.ext.js'
    });
    //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
    layer.ready(function() {
        var index = layer.open({
            type: 2,
            skin: 'layui-layer-molv',
            title: '款式编辑',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['1200px', '800px'],
            content: 'edit_style.php?editid='+editid+"&cuid="+cuid
        });
    });

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
                title: '款式添加',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '800px'],
                content: 'add_style.php'
            });
        });
}
//打开编辑页面的弹出层
function  openpage2( editid ){

       layer.config({
            extend: 'extend/layer.ext.js'
        });  
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
        var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '款式编辑',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '800px'],
                content: 'edit_style.php?editid='+editid
            });
        });
}


//ajax 加排序
function  openpage6( id,style_new ){
  var delid = id;
  if( style_new ){
      $.ajax({
         type: "POST",
         url: "editpro_style.php",
         data: "delid="+delid+"&new_no="+style_new,
         success: function(msg){
            if(msg  == 'go' ){
                layer.msg('修改成功', {  time: 1000,  });
                 window.location.reload();
            }else{
                layer.msg('货品不是新款推荐！', {  time: 1000,  });
            }
         }
      });
  }else{
      layer.msg('货品不是新款推荐！', {  time: 1000,  });
  }
      
}

//ajax 删除数据
function  openpage3( id ){
  var delid = id;
  layer.confirm('与之对应的现货列表都将删除，请谨慎操作！', {
    btn: ['确认','取消'] //按钮
  }, function(){
     $.ajax({
         type: "POST",
         url: "del_style.php",
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

//ajax 找到现货列表的最大值和最小值
function  openpage4( style_no , id ){
    $.ajax({
        type: "POST",
        url: "style_min_max.php",
        data: "style_no="+style_no+"&id="+id,
        success: function(msg){
        }
    });
}

</script>

</body>
</html>