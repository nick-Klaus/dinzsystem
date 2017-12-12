<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$c_domain = $_SESSION['ch_domain'];
$keys = trim($_GET['openid']);
$_uid = trim($_GET['uid']);
$mac_remark = trim($_GET['mac_remark']);
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
    </style>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b>设备管理</b></legend>


    <?php
    function get_mac_info($macid)
    {
        $sqlinfo = "select mac_tit from e_mac_set where macid=$macid";
        return (fetchOne($sqlinfo));
    }

    require_once '../fun/ip.php';


    function get_ip($ip)
    {
        if ($ip) {
            $setip = new cls_ipAddress("../inc/qqwry.dat");
            $location = $setip->getlocation($ip);
            $str = $location['area'];
            $str = iconv("gb2312", "utf-8//IGNORE", $str); //这边纯真IP数据库获取到的gb2312格式的文字,要先转成UTF8
            preg_match_all('/(.*?)省(.*?)市/', $str, $userLocation);

            //print_r($userLocation);

            if (is_array($userLocation)) {
                $province = $userLocation[1][0];
                $city = $userLocation[2][0];
            }
            $username = "<span style='color:#f60;font-size:10px'>" . $province . "省" . $city . '市<br>(' . $ip . ')</span>';
            return ($username);
        }
    }

    ?>
    <script src="./../assets/js/jquery.cxselect.js"></script>
    <table>
        <tr style='background:#ffffff;'>
            <? if ($c_uid == 1) { ?>
                <form class="layui-form" action="" id='form1'>
                    <td width="100" align="right">添加设备：</td>
                    <td width="53" align="center">UID</td>
                    <td width="200"><input name="uid" type="text" lay-verify="title" autocomplete="off"
                                           placeholder="请输入管理UID" class="layui-input"/></td>
                    <td width="20"></td>
                    <td>
                        <button id='button' class="layui-btn" lay-submit="" lay-filter="demo1"><i
                                    class="layui-icon"></i>添加
                        </button>
                    </td>
                </form>
            <? } ?>
            <td width="145"></td>
            <form action="./box_list.php">
                <td width="260"><input name="openid" type="text" lay-verify="title" autocomplete="off"
                                       placeholder="请输入机器码" class="layui-input" value="<?php echo $keys; ?>"/>

                </td>
                <td width="260"><input name="uid" type="text" lay-verify="title" autocomplete="off"
                                       placeholder="请输入管理UID" class="layui-input" value="<?php echo $_uid; ?>"/></td>
                <td width="260"><input name="mac_remark" type="text" lay-verify="title" autocomplete="off"
                                       placeholder="请输入设备备注" class="layui-input" value="<?php echo $mac_remark; ?>"/>
                </td>
                <td width="1000"><input type="submit" class="layui-btn" value="查询"></td>
            </form>
        </tr>
    </table>
    <table class="layui-table">
        <?php
        if ($c_uid == 1)
            $sql = "select a.*,b.username,b.uid,b.user_bz from e_mac_code a,e_members b where (a.uid in (select b.uid from e_members b where b.domain like '$c_uid,%') or a.uid='$c_uid') and a.uid=b.uid ";
        elseif ($c_uid == 4)
            $sql = "select a.*,b.username,b.uid,b.user_bz  from e_mac_code a,e_members b where (a.uid in (select b.uid from e_members b where b.domain like '$c_domain$c_uid,%') or a.uid='$c_uid')  and a.uid=b.uid ";
        else
            $sql = "select a.*,b.username,b.uid,b.user_bz  from e_mac_code a,e_members b where (a.uid in (select b.uid from e_members b where b.domain like '$c_domain$c_uid,%') or a.uid='$c_uid') and a.uid=b.uid  ";
        if ($keys) {
            $sql .= " and  a.openid like '%$keys%'";
        }

        if ($_uid) {
            $sql .= " and  b.uid='$_uid' ";
        }

        if ($mac_remark) {
            $sql .= " and  a.mac_remark  like '%$mac_remark%' ";
        }

        $sql .= "  order by a.lasttime desc";

        $page_get .= "&a=" . $a . "&uid=" . $_uid . "&keys=" . $keys . "&mac_remark=" . $mac_remark;
        pages($sql, $s, $page_get, 13);

        ?>
        <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
            <td><b>机器码</b></td>

            <td><b>激活时间</b></td>
            <td><b>服务开始时间</b></td>
            <td><b>服务结束时间</b></td>
            <td><b>MAC</b></td>
            <td><b>激活IP</b></td>
            <td width="100"><b>最后活动时间</b></td>
            <td><b>活动IP</b></td>
            <td><b>操作</b></td>
            <td><b>版本</b></td>
            <td width="30"><b>状态</b></td>
            <td><b>管理帐号</b></td>
            <td colspan="7">管理</td>
        </tr>

        <?php

        while ($rs = mysql_fetch_array($results_date)) {
            ?>
            <tr>
                <td>
                    <?= $rs['openid'] ?>
                    <?php
                    if ($rs['id']) {
                        if( $c_uid == 4 || $c_uid == 1 ){
                            echo '<br><font style="font-size:9px;color:#ff6600">' . $rs['mac_remark'] . '</font>';
                        }else{
                            echo '<br><font style="font-size:9px;color:#ff6600">' . $rs['user_remark'] . '</font>';
                        }
                    }
                    ?>
                </td>

                <td><?= $rs['checktime'] ? date('Y-m-d H:i:s', $rs['checktime']) : '' ?></td>
                <td><?= $rs['startTime'] ? date('Y-m-d', $rs['startTime']) : '' ?></td>
                <td><?= $rs['endTime'] ? date('Y-m-d', $rs['endTime']) : '' ?></td>
                <td><?= $rs['mac'] ?></td>
                <td><?= get_ip($rs['ip']) ?></td>
                <td><?= $rs['lasttime'] ? date('Y-m-d H:i:s', $rs['lasttime']) : '' ?></td>
                <td><?= get_ip($rs['intelip']) ?></td>
                <td><?= $rs['apicode'] ?></td>
                <td><?= $rs['version'] ?></td>
                <td>
                    <?= $rs['yznum'] ? '正常' : '未激活' ?>
                </td>
                <td> <? if ($c_uid == 1) { ?><?= $rs['uid'] ?><? } ?> (<?= $rs['username'] ?>)</td>
                <td>
                    <?php
                    if ($rs['yznum'] == 1) {
                        echo "<a  class='layui-btn layui-btn-small' onclick='openpage4(" . $rs['id'] . ")' >重置</a>";
                    } else {
                        echo "<a  class='layui-btn layui-btn-small layui-btn-danger' onclick='openpage5(" . $rs['id'] . ")' >恢复</a>";
                    }

                    ?>
                </td>

                <td><a class='layui-btn layui-btn-small' onclick="openpage(<?= $rs['id'] ?>)">配置</a></td>
                <td><a class="layui-btn layui-btn-small" onclick="openpage1(<?= $rs['id'] ?>,'1',<?= $rs['uid'] ?>)">品牌介绍</a>
                </td>
                <td><a class="layui-btn layui-btn-small"
                       onclick="openpage1(<?= $rs['id'] ?>,'2',<?= $rs['uid'] ?>)">幻灯片</a></td>
                <td><a class="layui-btn layui-btn-small"
                       onclick="openpage3(<?= $rs['id'] ?>,'3',<?= $rs['uid'] ?>)">视频</a></td>
            </tr>
            <?php
        }

        ?>
        <tr align='center' style=' background:#ffffff;'>
            <td colspan="16"> <?php echo $pageNavi; ?> 共 <span
                        style='color:#009688;'><?php echo $numrows_date; ?></span> 条
            </td>
        </tr>
    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
    //点击按钮的动画效果
    function look() {
        var index = layer.load(0, {shade: false});
        setTimeout(function () {
            layer.close(index);
        }, 1000);
    }

    layui.use(['form', 'layedit', 'laydate'], function () {

        var form = layui.form()
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
        var adminurl = "./add_box.php";

// ajax 提交添加uid的表单
        $("#form1").submit(function () {
            $.ajax({
                cache: true,
                type: "POST",
                url: "./add_box.php",
                data: $('#form1').serialize(),// 你的formid
                async: false,
                error: function (request) {
                    alert("Connection error");
                },
                success: function (data) {
                    if (data == 'go') {
                        layer.msg('增加成功');
                        //关闭子页面
                        window.location.reload();
                    } else {
                        layer.msg('增加失败', function () {
                        });
                    }
                }
            });

        });

    });


    //打开配置页面的弹出层
    function openpage(id) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '设备配置',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '750px'],
                content: 'box_update.php?id=' + id
            });
        });
    }
    //打开品牌页面的弹出层
    function openpage1(macid, type, uid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '幻灯片',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '650px'],
                content: 'brand_update.php?id=' + macid + '&type_id=' + type + '&uid=' + uid
            });
        });
    }

    //打开视频页面的弹出层
    function openpage3(macid, type, uid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '视频',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '650px'],
                content: 'brand_video.php?id=' + macid + '&type_id=' + type + '&uid=' + uid
            });
        });
    }

    //ajax 改变机器状态
    function openpage4(id) {
        var delid = id;
        layer.confirm('确定要重置此台机器吗？重置后机器将无法使用！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "boxpro_update.php",
                data: "delid=" + delid + "&state=0",
                success: function (msg) {
                    if (msg == 'go1') {
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

    function openpage5(id) {
        var delid = id;
        layer.confirm('确定要恢复此台机器吗？恢复后机器将正常使用！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "boxpro_update.php",
                data: "delid=" + delid + "&state=1",
                success: function (msg) {
                    if (msg == 'go1') {
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