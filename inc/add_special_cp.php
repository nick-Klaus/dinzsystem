<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$ztid = $_GET['ztid'];

if ($ztid) {
    $sql = "select * from e_user_zt where id=$ztid";
    $rs = fetchOne($sql);
    $uid = $rs['adduid'];
}
$addfo = 'http://imageserver.echao.com/';

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
    <link rel="stylesheet" href="../assets/css/amazeui.min.css"/>
    <style>

        body {
            padding: 10px;
            overflow-y: scroll;
        }

    </style>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b><?php echo $rs['zt_name'] ?></b></legend>
</fieldset>
<form class="layui-form" action="">
    <table >
            <!-- <input type="hidden" name="act" value="add_zt_cp"> -->
            <input type="hidden" name="ztid" value="<?= $ztid ?>">
            <input type="hidden" name="adduid" value="<?= $uid ?>">
            <tr>
                <td width="100" align="right"><font size='3'><b>款号</b>：</font></td>
                <td width="20"></td>
                <td width="200">
                    <input name="style_no" type="text" lay-verify="required" placeholder="请输入输入款号"  autocomplete="off" class="layui-input">
                </td>
                <td width="20"></td>
                <td>
                    <button class="layui-btn" lay-submit="" lay-filter="demo1" title="添加专题产品"><i  class="layui-icon"></i>添加 </button>
                </td>
    </form>
    </tr>
    <tr >
        <td colspan="5"  id="#LAY_demo3">
            <?php
            $sql = "select a.id,b.style_no,b.style_name,b.style_thumb,b.best64 from e_user_zt_goods a,e_goods_sylte b where a.ztid='$ztid' and a.style_no=b.style_no";
            $rs = fetchAll($sql);
            for ($i = 0; $i < count($rs); $i++) {
                ?>
                <table width="200" border="0" cellspacing="0" cellpadding="0" style="float:left;margin:10px" >
                    <tr>
                        <td height="200" align="center">
                            <img src="http://imageserver.echao.com/<?= $rs[$i]['best64'] ? 'imagespath/' : '' ?><?= urldecode($rs[$i]['style_thumb']) ?>"
                                 style="width:180px;height:180px">
                        </td>
                    </tr>
                    <tr>
                        <td height="25" align="center"><?= $rs[$i]['style_name'] ?> (<?= $rs[$i]['style_no'] ?>)</td>
                    </tr>
                    <tr>
                        <td height="25" align="center"><span onclick="openpage3( <?= $rs[$i]['id'] ?> )"><i  class="am-icon-close"></i></span></td>
                    </tr>
                </table>
                <?
            }
            ?>
        </td>
    </tr>
    </table>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
    layui.use('flow', function(){
        var flow = layui.flow;
        flow.lazyimg({
            elem: '#LAY_demo3 img'
            ,scrollElem: '#LAY_demo3' //一般不用设置，此处只是演示需要。
        });
    });
</script>
<script>
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

        //监听提交
        form.on('submit(demo1)', function (data) {
            //console.log(data);
            $.post(adminurl, data.field, function (json) {
                //console.log(json);
                if (json == 'go') {
                    layer.msg('增加成功');
                    window.location.reload();
                } else {
                    layer.msg('增加失败，款号不能重复！', function () {
                    });
                }
            });
            return false;
        });
    });
    //ajax 删除数据
    function openpage3(id) {
        var delid = id;
        layer.confirm('您确定要删除本条数据吗？数据无价！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "del_special_cp.php",
                data: "delid=" + delid,
                success: function (msg) {
                    //alert(msg);
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