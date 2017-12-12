<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$stu_id = $_GET['stu_id'];
$sql = "select * from  e_user_stu_list  where stu_id=" . $stu_id . " and adduid=" . $_SESSION['uid'];
$sql .= " order by lesson_sort asc";
$page_get .= "&a=" . $a . "&stu_id=" . $stu_id;
pages($sql, $s, $page_get, 10);
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
    <link rel="stylesheet" href="../layui/css/layui.css" media="all">

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
            overflow: auto;
        }
    </style>


</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend><b>珠宝学院</b></legend>
</fieldset>
<table class="layui-table">
    <tr style=' background:#ffffff;'>
        <td colspan="6" style="border:none;"><a id="openpage" onclick="openpage( <?php echo $_GET['stu_id'] ?> )"
                                                class="layui-btn"><i class="layui-icon"></i> 添加课程</a>
        </td>
    </tr>
    <tr style='background:#51545F;color:#ffffff;'>
        <th><b>标题</b></th>
        <th><b>缩略图</b></th>
        <th><b>时间</b></th>
        <th><b>类型</b></th>
        <th><b>排序</b><font size='1'>（*双击修改，升序*）</font></th>
        <th><b>操作</b></th>
    </tr>
    <?php

    while ($rs = mysql_fetch_array($results_date)) {
        ?>
        <tr align="center">
            <td><?= $rs['stu_tit'] ?></td>
            <td><img src='http://imageserver.echao.com/<?= $rs['stu_pic'] ?>' style="height:50px;width:60px;"></td>

            <td style="line-height:14px;font-size:12px">
                <?= date('Y-m-d H:i:s', $rs['times']); ?>
            </td>
            <td><?= $rs['stu_type'] ? '视频' : '幻灯片' ?></td>
            <td width="150"><span class='editable3' id="<?php echo $rs['id'] ?>"><?= $rs['lesson_sort'] ?></span></td>
            <td>
                <a class="layui-btn" onclick="openpage2( <?= $rs['id'] ?> )"><i class="layui-icon"></i></a>
                <a class="layui-btn layui-btn-danger" onclick="openpage3( <?= $rs['id'] ?> )"><i class="layui-icon"></i></a>
                <?php
                echo "<button class=\"layui-btn\" onclick=\"openpage4( '" . $rs['video_url'] . "' ) \">视频播放</button>";
                ?>
            </td>
        </tr>

        <?php
    }

    ?>

    <tr align='center' style=' background:#ffffff;'>
        <td colspan="6"> <?php echo $pageNavi; ?> 共 <span style='color:#009688;'><?php echo $numrows_date; ?></span> 条
        </td>
    </tr>
</table>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>

    //修改排序
    $(function () {
        $(".editable3").dblclick(function () {
            var id = this.id;
            var lang = this.lang;
            var text = $(this).text();
            var txt = $("<input type='text' name='sort' style='text-align:left;width:40px;height:40px;color:#ff0000;'>").val(text);
            $(this).html(txt);
            txt.trigger("focus");
            txt.blur(function () {
                var new_val = txt.val();
                //双击修改后，数据传入后台修改
                $.ajax({
                    type: "POST",
                    url: "editpro_lesson_list.php",
                    data: "sort_id=" + id + "&sort=" + new_val,
                    success: function (msg) {
                        if (msg == 'go') {
                            layer.msg('修改成功');
                            location.reload();
                        }
                        // if( msg  == 'error' ){
                        //   layer.msg('没有修改任何数据');
                        //   //location.reload();
                        // }
                    }
                });
                //修改以后的数据替换input
                $(this).replaceWith(new_val);
            })
        });
    });

    //打开增加页面的弹出层
    function openpage(stu_id) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加课程',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '800px'],
                content: 'add_lesson_list.php?stu_id=' + stu_id
            });
        });
    }

    //打开编辑页面的弹出层
    function openpage2(id) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑课程',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '820px'],
                content: 'edit_lesson_list.php?stu_id=' + id
            });
        });
    }

    //打开视频播放页面
    function openpage4(url) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.open({
            type: 2,
            title: false,
            area: ['630px', '360px'],
            shade: 0.8,
            closeBtn: 0,
            shadeClose: true,
            content: url
        });
    }

    //http://www.zhangxinxu.com/study/media/cat.mp4
    //ajax 删除数据
    function openpage3(id) {
        var delid = id;
        layer.confirm('您确定要删除本条数据吗？数据无价！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "del_lesson_list.php",
                data: "delid=" + delid,
                success: function (msg) {
                    if (msg == 'go') {
                        layer.msg('删除成功', {time: 1000,});
                        window.location.reload();
                    } else {
                        layer.msg('删除失败', {time: 1000,});
                    }
                }
            });
        }, function () {
        });
    }


</script>
</body>
</html>