<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$title = trim($_GET['title']);
$bargain_id = trim($_GET['bargain_id']);
$sql = "select a.*,b.id as userid from bargain a left join bargain_user b on a.id=b.bargain_id where a.openid=b.openid and a.admin_id=1";
$sql .= " and a.id='$bargain_id' ";
if ($title) {
    $sql .= " and a.title  like '%$title%' ";
}

$sql .= " order by a.id desc";
$page_get .= "a=" . $a . "&title=" . $title;
pages($sql, $s, $page_get, 12);//数据分页 每页20条


?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>砍价详情</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="../layui/css/layui.css" media="all">
    <link rel="shortcut icon" href="../images/title.png">

    <style>
        tr:hover {
            background: #ABB0C1;
        }

        .frist_page {

            display: inline-block;
            height: 30px;
            line-height: 30px;
            width: 45px;
            text-align: center;
            background: #009688;
            color: #ffffff;
            border-radius: 3px;
        }

        .up_page {

            display: inline-block;
            height: 30px;
            line-height: 30px;
            width: 45px;
            text-align: center;
            background: #009688;
            color: #ffffff;
            border-radius: 3px;
        }

        .next_page {

            display: inline-block;
            height: 30px;
            line-height: 30px;
            width: 45px;
            text-align: center;
            background: #009688;
            color: #ffffff;
            border-radius: 3px;
        }

        .end_page {

            display: inline-block;
            height: 30px;
            line-height: 30px;
            width: 45px;
            text-align: center;
            background: #009688;
            color: #ffffff;
            border-radius: 3px;
            margin-right: 15px;
        }

        .end_page:hover {
            color: #ffffff;
        }

        .next_page:hover {
            color: #ffffff;
        }

        .up_page:hover {
            color: #ffffff;
        }

        .frist_page:hover {
            color: #ffffff;
        }

        #this_page {
            display: inline-block;
            height: 30px;
            line-height: 30px;
            width: 30px;
            text-align: center;
            background: #009688;
            color: #ffffff;
            border-radius: 3px;
        }

        body {
            min-width: 1530px;
            overflow: auto;
        }
    </style>

</head>
<body>
<fieldset class="layui-elem-field layui-field-title " style="margin: 20px 20px 0px 20px;">
    <legend><b>砍价活动详情</b></legend>

    <table class="layui-table" lay-skin="line">
        <form action=''>
            <tr style=' background:#ffffff;'>
                <td style='text-align:center;border:none;' colspan="13">
                    <input type="text" value="<?php echo $bargain_id ?>" name="bargain_id" placeholder="请输入活动编号"
                           style="width:200px;height:23px;padding:5px;margin-right: 5px; ">
<!--                    <input type="text" value="--><?php //echo $title ?><!--" name="title" placeholder="请输入活动标题"-->
<!--                           style="width:200px;height:23px;padding:5px;margin-right: 5px; ">-->
                    <button type='submit' onclick="show()" class="layui-btn">提交查询</button>
                    <a href='./agent_details.php' onclick="show()" class="layui-btn"> 返 回 </a></td>
            </tr>
        </form>
        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>活动编号</b></td>
            <td><b>活动链接</b></td>
            <td><b>顶部LOGO</b></td>
            <td width="350"><b>标题</b></td>
            <td><b>原价</b></td>
            <td><b>底价</b></td>
            <td><b>砍价次数</b></td>
            <td><b>查看人数</b></td>
            <td><b>分享人数</b></td>
            <td><b>参与人数</b></td>
            <td><b>砍到底价人数</b></td>
            <td><b>操作</b></td>
        </tr>
        <?php

        while ($rs = mysql_fetch_array($results_date)) {

            $url = urlencode("http://weixin.echao.com/web_activity/bargain/" . $rs['template'] . ".html?userid=" . $rs['userid'] . "&actid=" . $rs['id']);
            ?>
            <tr align="center">
                <td><?= $rs['id'] ?></td>
                <td width="160">
                    <img style="width: 140px;height:140px" src='http://api.echao.com/qrcode/?value=<?php echo $url ?>'
                         style='width:100%;'>
                </td>
                <td><img src="<?= $rs['image_logo'] ?>" height='80'></td>
                <td> <?= $rs['title'] ?></td>
                <td> <?= $rs['original_price'] ?></td>
                <td> <?= $rs['floor_price'] ?></td>
                <td> <?= $rs['bargain_times'] ?></td>
                <td> <?= $rs['user_ck'] ?></td>
                <td> <?= $rs['user_fx'] ?></td>
                <td> <?= $rs['user_cj'] ?></td>
                <td style="color: #ff0000"><strong><?= $rs['user_floor'] ?></strong></td>
                <td width="350">
                    <a class="layui-btn" onclick="openpage1( <?= $rs['id'] ?> )">参加用户</a>
                </td>
            </tr>
            <?php

        }
        ?>
        <tr align='center' style='background:#ffffff;'>
            <td colspan="13"> <?php echo $pageNavi; ?> 共 <span
                        style='color:#009688;'><?php echo $numrows_date; ?></span> 条
            </td>
        </tr>

    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>
    function show() {
        var index = layer.load(0, {shade: false});
    }
    //打开参加砍价用户页面的弹出层
    function openpage1(id) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '参加砍价的用户',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1050px', '800px'],
                content: 'bargain_user.php?id=' + id
            });
        });
    }

</script>

</body>
</html>