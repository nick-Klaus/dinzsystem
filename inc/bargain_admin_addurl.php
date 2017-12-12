<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$remark = $_GET['remark'];

$sql = "select * from bargain_admin_addurl";
if( $remark ){
    $sql .= " where remark like '%{$remark}%'";
}
$page_get.="a=".$a . "&remark=" . $remark;
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
    <legend><b>注册二维码</b></legend>

    <table class="layui-table" lay-skin="line">
        <form action=''>
            <tr style=' background:#ffffff;'>
                <td style='text-align:center;border:none;' colspan="6">
                    <input type="text" value="<?php echo $remark ?>" name="remark" placeholder="请输入二维码备注"
                           style="width:300px;height:23px;padding:5px;margin-right: 5px; ">
                    <button type='submit' onclick="show()" class="layui-btn">提交查询</button>
                    <a href='./bargain_admin_addurl.php' onclick="show()" class="layui-btn"> 返 回 </a></td>
            </tr>
        </form>
        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
            <td><b>编号</b></td>
            <td><b>二维码</b></td>
            <td><b>链接</b></td>
            <td><b>注册人数</b></td>
            <td><b>备注</b></td>
            <td width="230"><b>操作</b></td>
        </tr>
        <?php

        while($rs=mysql_fetch_array($results_date)) {
            ?>
            <tr align="center">
                <td> <?php echo sprintf("%04d", $rs['id']) ?></td>
                <td > <img style="width: 140px;height:140px" src='<?php echo $rs['img_url'] ?>'
                          style='width:100%;'> </td>
                <td width="150"><?= $rs['img_url'] ?></td>
                <td>
                    <?php
                        $sql = "select id from bargain_admin where recommender=".sprintf("%04d", $rs['id']);
                        echo getTotalRows($sql);
                    ?>
                </td>
                <td><?= $rs['remark'] ?> </td>
                <td>
                    <a class="layui-btn" onclick="openpage2( <?= $rs['id'] ?> )">编辑</a>
                    <a class="layui-btn" onclick="openpage( <?= $rs['id'] ?> )">注册人员</a>
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

    function  show(){
        var index = layer.load(0, {shade: false});
    }


    //打开参加用户页面的弹出层
    function openpage(id) {
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
                content: 'bargain_admin_list.php?id=' + id
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
                title: '编辑注册信息',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['800px', '600px'],
                content: 'bargain_admin_addurledit.php?uid='+id
            });
        });
    }

</script>

</body>
</html>