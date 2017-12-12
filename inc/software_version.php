<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];

$sql = "select * from soft_version_name";

$page_get.="&a=".$a;
pages($sql,$s,$page_get,10);//数据分页 每页20条

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
    <legend><b>软件版本</b></legend>


    <table class="layui-table" lay-skin="line">

            <tr  style=' background:#ffffff;'>
                <td colspan="4" style="border:none;" ><a  id='openpage' onclick='openpage()'  class='layui-btn' ><i class='layui-icon'></i> 添加新版本</a></td>
            </tr>
         <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>版本名称</b></td>
            <td><b>版本文件</b></td>
            <td><b>更新帐号</b></td>
            <td><b>更新时间</b></td>
            <td width="150"><b>操作</b></td>
        </tr>
        <?php

        while($rs=mysql_fetch_array($results_date))
        {

            ?>
            <tr align="center" >
                <td> <?=$rs['version_name']?></td>
                <td> <?=$rs['version_folder']?></td>
                <td > <?=$rs['addid']?></td>
                <td ><?php echo date('Y-m-d H:i:s',$rs['addtime'])  ?>  </td>
                <td><button  onclick="openpage2( <?=$rs['id']?> )" class="layui-btn" title='编辑'><i class="layui-icon">&#xe642;</i></button>
                    <button  class="layui-btn layui-btn-danger" onclick='openpage3( <?=$rs['id']?> )'  title='删除' ><i class="layui-icon"></i></button>
                </td>
            </tr>

            <?php

        }
        ?>
        <tr align='center' style=' background:#ffffff;'>
            <td colspan="6"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
        </tr>

    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>

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
                title: '添加新版本',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '580px'],
                content: 'add_version.php'
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
                title: '编辑版本内容',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '600px'],
                content: 'edit_version.php?editid='+id
            });
        });
    }

//ajax 删除数据
function  openpage3( id ){
    var delid = id;
    layer.confirm('数据无价，请谨慎操作！', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: "del_version.php",
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