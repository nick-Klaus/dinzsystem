<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];

// 定制类型
$qdz_type = $_GET['qdz_type']?$_GET['qdz_type']:1;

$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='$c_uid'" );  
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
     .layui-form-item{
        width:100%;
        height:35px;
        border:1px solid #ccc;
        font-size:14px;
        -webkit-appearance: none;
		margin-top: 15px;
		padding:0px 10px;
     }
    .img_hover:hover{
      transform:scale(3);/*指的是图片放大的倍数*/
    }
   body{
        min-width: 950px;
        overflow: auto;
      }

</style>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
  <legend><b>轻定制款式管理</b></legend>

<table class="layui-table">

<tr><td style="border: none;background:#ffffff;"><a  onclick='openpage1(<?=$qdz_type?>)'   class="layui-btn" ><i class="layui-icon"></i>款式添加</a> <button  onclick="openpage(<?=$qdz_type?>,<?=$c_uid?>)"  class="layui-btn" >
<?php
      switch ($qdz_type)
      {
            case 1:
              echo "添加姓名系列";
              break;
            case 2:
              echo "添加声波系列";
              break;
            case 3:
              echo "添加指纹系列";
              break;
            case 4:
              echo "添加字符系列";
              break;
            case 5:
              echo "添加莫尔斯系列";
              break;
            case 6:
              echo "添加唇纹系列";
              break;
      }
      ?>
</button></td>
    <td colspan="10" style="border: none;background:#ffffff;text-align: center;">
    <a href="./qdz_list.php?qdz_type=1"  class="layui-btn" >姓名系列</a>　
    <a href="./qdz_list.php?qdz_type=2"  class="layui-btn" >声波系列</a>　
    <a href="./qdz_list.php?qdz_type=3"  class="layui-btn" >指纹系列</a>　
    <a href="./qdz_list.php?qdz_type=4"  class="layui-btn" >字符系列</a>　
    <a href="./qdz_list.php?qdz_type=5"  class="layui-btn" >莫尔斯系列</a>　
    <a href="./qdz_list.php?qdz_type=6"  class="layui-btn" >唇纹系列</a></td>
</tr>


<?php
if( $c_uid == 1 ){
    $sql = "select * from e_goods_sylte  where displays = 0 and adduid in ($c_uid , 0 ) and qdz_type='$qdz_type'";
}else{
    $sql = "select * from e_goods_sylte  where displays = 0 and adduid='$c_uid'  and qdz_type='$qdz_type'";
}

if($cls1) $sql.=" and cls1='$cls1' ";
if($cls2) $sql.=" and cls2='$cls2' ";
if($cls3) $sql.=" and cls3='$cls3' ";
if($keys) $sql.=" and (style_no like '$keys%' or factory_no like '$keys%') and displays = 0 ";
$sql.= " order by style_new desc,id desc";
$page_get.="cls1=".$cls1."&cls2=".$cls2."&cls3=".$cls3."&keys=".$keys;
pages($sql,$s,$page_get,10);

?>
  <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
  <td width="260"><b>图片</b></td>
  <td width="150"><b>品名</b></td>
  <td width="150"><b>款号</b></td>
  <td width="150"><b>现货库存</b></td>
  <td colspan="4"><b>款式属性</b></td>
  <td width="100" ><b>定制详情</b></td>
  </tr>
<?php



while($rs=mysql_fetch_array($results_date)) 
{


    if ($rs['best64'] == 1) {
        $img_url = 'http://imageserver.echao.com/imagespath/' . urldecode($rs['style_thumb']);
    } else {
        $img_url = 'http://imageserver.echao.com/' . urldecode($rs['style_thumb']);
    }
    if( !isset($rs['style_thumb']) ){
        $img_url = "../images/timg.jpg";
    }
?>
<tr align="center">
  <td><img  src="<?php echo  $img_url  ?>" style="width:60px;height:60px" class='img_hover'></td>
  <td><?=$rs['style_name']?><?php if( $rs['adduid'] == 0 ){ echo "<font size='1' color='#32AA9E'>(鉴赏)</font>"; }  ?></td>
  <td><?=$rs['style_no']?></td>
  <td > 库存 (<?php echo $rs['stocks'] ?>)</td>
  <td style="width:60px;font-size:12px"><?=$rs['style_sort']?'<span  style="color:red">有银版</span>':'银版'?></td>
  <td style="width:60px;font-size:12px"><?=$rs['style_new']?'<span  style="color:red">新款</span>':'新款'?></td>
  <td style="width:60px;font-size:12px"><?=$rs['style_hot']?'<span  style="color:red">畅销</span>':'畅销'?></td>
  <td style="width:60px;font-size:12px"><?php
      switch ($rs['style_mode'])
      {
          case 0:
              echo "定制";
              break;
          case 1:
              echo "<span style=\"color:red\">可定制</span>";
              break;
          case 2:
              echo "对戒";
              break;
          case 3:
              echo "其它";
              break;
      }
      ?></td>
  <td > <a style="width:40%;" onclick='openpage2(<?php echo $rs['id'] ?>)' title='编辑' class="layui-btn" ><i class="layui-icon"></i></a>   <a style="width:40%;" class="layui-btn layui-btn-danger" onclick='openpage3(<?php echo $rs['id'] ?>)'  title='删除' ><i class="layui-icon"></i></a></td>
  
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


//打开增加页面的弹出层
function  openpage(qdz_type,uid){
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
            content: 'qdz_add.php?qdz_type='+qdz_type
        });
    });
}

//打开增加页面的弹出层
function  openpage1(qdz_type){
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
            content: 'add_style.php?qdz_type='+qdz_type
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

</script>

</body>
</html>