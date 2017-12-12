<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$sql = "select * from bargain_admin where recommender=".sprintf("%04d", $_GET['id']);

$page_get.="a=".$a;
pages($sql,$s,$page_get,10000);

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
            min-width: 850px;
            overflow: auto;
        }
    </style>

</head>
<body>
<fieldset class="layui-elem-field layui-field-title " style="margin: 20px 20px 0px 20px;">
    <legend><b>砍价活动用户</b></legend>

    <table class="layui-table" lay-skin="line">
        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>序号</b></td>
            <td><b>公司名称</b></td>
            <td><b>电话号码</b></td>
            <td><b>服务开始时间</b></td>
            <td><b>服务结束时间</b></td>
            <td><b>注册时间</b></td>
            <td><b>ip地址</b></td>
        </tr>
        <?php
        $i = 1;
        while($rs=mysql_fetch_array($results_date))
        {

            ?>
            <tr align="center" >
                <td > <?php echo $i++?></td>
                <td > <?=$rs['company_name']?></td>
                <td> <?=$rs['phone']?> </td>
                <td> <?=$rs['start_time']?></td>
                <td> <?=$rs['end_time']?></td>
                <td> <?=$rs['addtime']?></td>
                <td> <?=$rs['ip']?></td>
            </tr>

            <?php

        }
        ?>

    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>


</body>
</html>