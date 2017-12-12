<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];

$nickname = trim($_GET['nickname']);
$company_name = trim($_GET['company_name']);
$sql = "select a.*,b.username as aduser,m.id,m.group_name from e_members b,e_fx_members a  left join e_fx_group m on a.groupid=m.id where  a.webid=b.uid and (a.webid in (select c.uid from e_members c where c.domain like '%,$c_uid,%') or a.webid='$c_uid'  )";
if( $nickname ){
    $sql .= " and a.nickname like '%$nickname%'";
}
if( $company_name ){
    $sql .= " and a.company_name like '%$company_name%'";
}
$sql .= " order by uid desc";
$page_get .= "&a=" . $a. "&nickname=" . $nickname. "&company_name=" . $company_name;
pages($sql, $s, $page_get, 10);


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
        body {
            padding: 10px;
        }

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
            min-width: 800px;
            overflow: auto;
        }

    </style>

</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend><b>添加会员</b></legend>
</fieldset>

<table class="layui-table">
    <form action=''>
        <tr style=' background:#ffffff;'>
            <td style="text-align:left;background:#ffffff;border:none;">
                <a class="layui-btn" href="javascript:void(0);" onclick="openpage()"><i class="layui-icon"></i> 添加会员</a>
            </td>
            <td style='text-align:center;border:none;' colspan="8">
                <input type="text" value="<?php echo $nickname ?>" name="nickname" placeholder="请输入昵称"
                       style="width:300px;height:23px;padding:5px;margin-right: 5px; ">
                <?php
                    if( $c_uid == 19 ){
                        echo '<input type="text" value="'.$company_name.'" name="company_name" placeholder="请输入公司名称"
                       style="width:300px;height:23px;padding:5px;margin-right: 5px; " >';
                    }
                ?>
                <button type='submit' onclick="show()" class="layui-btn">提交查询</button>
                <a href='./fx_member.php' onclick="show()" class="layui-btn"> 返 回 </a></td>
    </tr>
    </form>

    <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>
        <td><b>UID</b></td>
        <td><b>帐号</b></td>
        <td><b>昵称</b></td>
        <td><b>webid</b></td>
        <td><b>所在分组</b></td>
        <td><b>备注</b></td>
        <td width='150'><b>登录权限</b><font size='1'>（点击可修改）</font></td>
        <td><b>倍率</b></td>
        <td width='150'><b>操作</b></td>
    </tr>

    <?php

    while ($rs = mysql_fetch_array($results_date)) {

        ?>
        <tr align="center">
            <td> <?= $rs['uid'] ?></td>
            <td><span style="color:#f60"><?= $rs['aduser'] ?></span> => <span
                        style="color:#f60"><?= $rs['username'] ?></span></td>
            <td> <?= $rs['nickname'] ?></td>
            <td> <?= $rs['webid'] ?> </td>
            <td><font color='#32AA9E'><b><?= $rs['group_name'] ?></b></font></td>
            <td> <?= $rs['user_bz'] ?> </td>
            <td> <?php

                if ($rs['usertyp'] > 0) {
                    echo "<a href='javascript:void(0)' onclick='openpage4( " . $rs['uid'] . "," . $rs['usertyp'] . ")' style='color:#1AA094;'><b>已启用</b></a>";
                } else {
                    echo "<a href='javascript:void(0)' onclick='openpage4( " . $rs['uid'] . "," . $rs['usertyp'] . ")' style='color:#ff0000;'><b>未启用</b></a>";
                }

                ?>
            </td>
            <td>
                <?php

                if ($rs['groupid']) {
                    echo '<button  onclick="openpage3( ' . $rs['id'] . ' )" class="layui-btn" title="折扣">倍率</button>';
                } else {
                    echo '<button  onclick="openpage5( ' . $rs['webid'] . ' )" class="layui-btn" title="折扣">倍率</button>';
                }

                ?>


            </td>
            <td width="50">
                <button onclick="openpage1( <?= $rs['uid'] ?> )" class="layui-btn" title='编辑'><i class="layui-icon">&#xe642;</i>
                </button>
                <button onclick="openpage2( <?= $rs['uid'] ?> )" class="layui-btn layui-btn-danger" title='删除'><i
                            class="layui-icon"></i></button>
            </td>
        </tr>
        <?php
    }

    ?>
    <tr align='center' style=' background:#ffffff;'>
        <td colspan="9"> <?php echo $pageNavi; ?> 共 <span style='color:#009688;'><?php echo $numrows_date; ?></span> 条
        </td>
    </tr>
</table>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
    function show() {
        var index = layer.load(0, {shade: false});
    }
    layui.use(['form', 'layedit', 'laydate'], function () {

        var form = layui.form()
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
        var adminurl = "./addpro_special_cp.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function (value) {
                if (value.length < 1) {
                    return '款号不能为空';
                }
            }
            , pass: [/(.+){6,12}$/, '密码必须6到12位']
            , content: function (value) {
                layedit.sync(editIndex);
            }
        });
    });

    //打开增加页面的弹出层
    function openpage() {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加会员',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1100px', '780px'],
                content: 'add_fx_admin.php'
            });
        });
    }
    //打开编辑页面的弹出层
    function openpage1(editid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑会员',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '780px'],
                content: 'edit_fx_admin.php?editid=' + editid
            });
        });
    }

    //打开所在分组的倍率弹出层
    function openpage3(group_id) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '会员组倍率',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '780px'],
                content: 'group_member_zk.php?group_id=' + group_id
            });
        });
    }


    //打开所在分组的倍率弹出层
    function openpage5(webid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '会员组倍率',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '780px'],
                content: 'system_rate_member.php?look_uid=' + webid
            });
        });
    }


    //ajax 删除数据
    function openpage2(id) {
        var delid = id;
        layer.confirm('您确定要删除此会员吗？请谨慎操作！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "del_fx_admin.php",
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


    //ajax 删除数据
    function openpage4(edit_uid, type) {

        layer.confirm('您确定要修改此会员权限吗？', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "editpro_fx_admin.php",
                data: "edit_uid=" + edit_uid + "&usertyp=" + type,
                success: function (msg) {
                    if (msg == 'go') {
                        layer.msg('修改成功', {time: 1000,});
                        window.location.reload();
                    } else {
                        layer.msg('修改失败', {time: 1000,});
                    }
                }
            });
        }, function () {
        });
    }


</script>

</body>
</html>