<?php
include "./../fun/eby_admin_api.php";

$company_id = trim($_GET['company_id']);
$sql = "select * from bargain_pay_log where company_id='$company_id'";
$sql.= " order by id desc";
$page_get.="a=".$a;
pages($sql,$s,$page_get,12);//数据分页 每页20条

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
    <legend><b>支付详情</b></legend>
    <table class="layui-table" lay-skin="line">
        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>支付金额</b></td>
            <td><b>续费类型</b></td>
            <td><b>支付时间</b></td>
        </tr>
        <?php

        while($rs=mysql_fetch_array($results_date))
        {

            ?>
            <tr align="center" >
                <td> <?=$rs['pay_price']?></td>
                <td>
                    <?php
                        if( $rs['pay_type'] ==1 ){
                            echo "包年";
                        }else{
                            echo "包月";
                        }
                    ?>
                </td>
                <td><?=$rs['pay_time']?></td>
            </tr>
            <?php

        }
        ?>
        <tr align='center' style=' background:#ffffff;'>
            <td colspan="10"> <?php echo $pageNavi; ?> 共 <span  style='color:#009688;' ><?php echo $numrows_date; ?></span> 条 </td>
        </tr>

    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

</body>
</html>