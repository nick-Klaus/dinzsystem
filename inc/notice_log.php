<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$uid = $_SESSION['uid'];
$notice_title = trim($_GET['notice_title']);

$sql = "select * from e_notice_log";
if( $notice_title ){
    $sql.=" where notice_title like '$notice_title%'";
}

$page_get.="&a=".$a."&notice_title=".$notice_title;
pages($sql,$s,$page_get,10);//数据分页 每页10条


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
    <legend><b>公告日志</b></legend>


    <table class="layui-table" lay-skin="line">
        <form action="">
        <tr  style=' background:#ffffff;'>
            <td style="border:none;"></td><td style="border:none;width:300px;" ><input type="text" name="notice_title" value="<?php echo $notice_title; ?>" placeholder="请输入公告标题" class="layui-input"></td>
            <td colspan="3" style="border:none;"> <button  class="layui-btn"  type="submit" title='查询' >提交查询</button> <a href="./notice_log.php" class="layui-btn"  title='查询' >返回</a></td>
        </tr>
        </form>
        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>用户名</b></td>
            <td><b>公告标题</b></td>
            <td><b>IP地址</b></td>
            <td><b>接收时间</b></td>
            <td><b>操作</b></td>
        </tr>
        <?php
        while($rs=mysql_fetch_array($results_date))
        {
            ?>
            <tr align="center" >
                <td> <?=$rs['username']?></td>
                <td> <?=$rs['notice_title']?></td>
                <td> <?=$rs['ip']?></td>
                <td width="298"><?php echo date('Y-m-d H:i:s',$rs['addtime'])  ?>  </td>
                <td>
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

//ajax 删除数据
function  openpage3( id ){
    var delid = id;
    layer.confirm('数据无价，请谨慎操作！', {
        btn: ['确认','取消'] //按钮
    }, function(){
        $.ajax({
            type: "POST",
            url: "del_notice_log.php",
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