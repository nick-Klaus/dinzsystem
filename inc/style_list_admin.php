<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid=" . $c_uid);
$area = isset($area) ? $area : array();
$tcls1 = $_GET['cls1'];
$tcls2 = $_GET['cls2'];
//款号
$keys = trim($_GET['keys']);
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

        .layui-form-item {
            width: 100%;
            height: 35px;
            border: 1px solid #ccc;
            font-size: 14px;
            -webkit-appearance: none;
            margin-top: 15px;
            padding: 0px 10px;
        }

        .img_hover:hover {
            transform: scale(3); /*指的是图片放大的倍数*/
        }
        body {
            min-width: 1300px;
            overflow: auto;
        }

    </style>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b>款式管理</b></legend>

    <form action="" id='form1'>
        <table class="layui-table">
            <tr style='background:#ffffff;'>
                <td colspan="3" style='border:none;'>
                    <a style="width:30%;" onclick='openpage()' class="layui-btn"><i class="layui-icon"></i>款式添加</a>
                    <a style="width:30%;" onclick='openpage5()' class="layui-btn"><i class="layui-icon"></i>添加珠宝鉴赏</a>
                    <a style="width:30%;" onclick='openpage7()' class="layui-btn"><i class="layui-icon"></i>添加珠宝印记</a>
                </td>
                <td style='border:none;'>
                    <select name="cls1" id='bigname' class="layui-form-item" style="margin-top:32px;">
                        <option value=""> 请选择顶级分类</option>
                        <?php
                        $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and  adduid  in (1,0) ");
                        foreach ($arr1 as $v) {
                            ?>
                            <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $cls1) {
                                echo 'selected';
                            } ?> > <?php echo $v['catename']; ?></option>
                            <?php
                        }
                        ?>
                    </select>　
                    　
                </td>
                <td colspan="2" style='border:none;'>
                    <!-- 二级联动的子级 -->
                    <select name="cls2" id='smallname' class="layui-form-item">
                    </select>
                </td>

                <td colspan="5" style='border:none;'>
                    <!-- <input type="text" name="factory_no" lay-verify="title" autocomplete="off" placeholder="请输入款号" class="layui-input" style='width:300px; float:left; '> -->
                    <input type="text" name="keys" id='keys' lay-verify="title" autocomplete="off" placeholder="请输入款号"
                           class="layui-input" style='width:300px; float:left;margin:0px 15px 0px 15px;'
                           value="<?php echo $keys; ?>">
                    <button class="layui-btn" lay-submit="" id='form2' onclick="look()">提交查询</button>
                    <!-- <a href='./style_list_admin.php' class="layui-btn" onclick="look()" >返回</a> -->
                </td>
    </form>
    </tr>
    <?php
    if ($c_uid == 1) {
        $sql = "select * from e_goods_sylte  where displays = 0 and qdz_type=0 and adduid in ($c_uid , 0 ) ";
    } else {
        $sql = "select * from e_goods_sylte  where displays = 0 and qdz_type=0 and adduid='$c_uid'  ";
    }

    if ($cls1) $sql .= " and cls1='$cls1' ";
    if ($cls2) $sql .= " and cls2='$cls2' ";
    if ($cls3) $sql .= " and cls3='$cls3' ";
    if ($keys) $sql .= " and (style_no like '$keys%' or factory_no like '$keys%') and displays = 0 ";
    $sql .= " order by style_new desc,id desc";
    $page_get .= "cls1=" . $cls1 . "&cls2=" . $cls2 . "&cls3=" . $cls3 . "&keys=" . $keys;
    pages($sql, $s, $page_get, 10);
    ?>
    <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
        <td width="100"><b>图片</b></td>
        <td width="150"><b>品名</b></td>
        <td width="150"><b>款号</b></td>
        <td width="150"><b>现货库存</b></td>
        <td colspan="4"><b>款式属性</b></td>
        <td><b>现货列表</b></td>
        <td width="140"><b>定制详情</b></td>
        <td><b>向上排序</b></td>
    </tr>
    <?php


    while ($rs = mysql_fetch_array($results_date)) {
        if ($rs['best64'] == 1) {
            $img_url = 'http://imageserver.echao.com/imagespath/' . urldecode($rs['style_thumb']);
        } else {
            $img_url = 'http://imageserver.echao.com/' . urldecode($rs['style_thumb']);
        }
        if( !isset($rs['style_thumb']) ){
            $img_url = "../images/timg.jpg";
        }
        ?>
        <tr align="center">
            <td><img src="<?php echo $img_url ?>" style="width:60px;height:60px" class='img_hover'></td>
            <td><?= $rs['style_name'] ?><?php if ($rs['adduid'] == 0) {
                    echo "<font size='1' color='#32AA9E'>(鉴赏)</font>";
                } ?></td>
            <td><?= $rs['style_no'] ?></td>
            <td> 库存 (<?php echo $rs['stocks'] ?>)</td>
            <td style="width:60px;font-size:12px"><?= $rs['style_sort'] ? '<span  style="color:red">有银版</span>' : '银版' ?></td>
            <td style="width:60px;font-size:12px"><?= $rs['style_new'] ? '<span  style="color:red">新款</span>' : '新款' ?></td>
            <td style="width:60px;font-size:12px"><?= $rs['style_hot'] ? '<span  style="color:red">畅销</span>' : '畅销' ?></td>
            <td style="width:60px;font-size:12px"><?php
                switch ($rs['style_mode']) {
                    case 0:
                        echo "定制";
                        break;
                    case 1:
                        echo "<span style=\"color:red\">可定制</span>";
                        break;
                    case 2:
                        echo "对戒";
                        break;
                    case 3:
                        echo "其它";
                        break;
                }
                ?></td>
            <td>
                <a href="spot_list.php?style_no=<?= $rs['style_no'] ?>&style_name=<?= $rs['style_name'] ?>&adduid=<?= $rs['adduid'] ?>&cls2=<?= $rs['cls2'] ?>"
                   onclick='openpage4("<?= $rs['style_no'] ?>","<?= $rs['id'] ?>")' class="layui-btn">现货列表</a></td>
            <td>
                <?php
                if( $rs['cls1'] == 346 ){
                    echo "<a style=\"width:40%;\" onclick='openpage8(".$rs['id'].")' title='编辑123' class=\"layui-btn\"><i class=\"layui-icon\"></i></a>";
                }else{
                    echo "<a style=\"width:40%;\" onclick='openpage2(".$rs['id'].")' title='编辑' class=\"layui-btn\"><i class=\"layui-icon\"></i></a>";
                }

                ?>


                <a style="width:40%;" class="layui-btn layui-btn-danger"
                                                            onclick='openpage3(<?php echo $rs['id'] ?>)' title='删除'><i
                            class="layui-icon"></i></a></td>
            <td style="font-size:24px;">
                <button onclick='openpage6(<?php echo $rs['id'] ?>,<?php echo $rs['style_new'] ?>)' title='向上排序'
                        class="layui-btn"><b>↑</b></button>
            </td>
        </tr>

        <?php
    }

    ?>

    <tr align='center' style=' background:#ffffff;'>
        <td colspan="11"> <?php echo $pageNavi; ?> 共 <span style='color:#009688;'><?php echo $numrows_date; ?></span> 条
        </td>
    </tr>
    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>

    //ajax传输顶级分类的id到style_ajax.php
    function getSelectVal() {
        var defval = "<?php echo $tcls2 ?>";
        var smallname = $("#smallname");
        var topid = $("#bigname").val();
        var option = "";
        if (topid === "") {
            $("option", smallname).remove();
            option = "<option   value=''>请选择子级分类</option>";
            smallname.append(option);
        }
        $.getJSON("style_ajax.php", {bigname: topid}, function (json) {
            //清空原有的选项
            $("option", smallname).remove();
            $.each(json, function (index, array) {
                //将返回的子级数据加入到子级分类的框中
                if (defval == array['id']) {
                    option = "<option  selected='selected'  value='" + array['id'] + "'>" + array['catename'] + "</option>"
                } else {
                    option = "<option   value='" + array['id'] + "'>" + array['catename'] + "</option>";
                }
                smallname.append(option);
            });
        });
    }

    //触发下拉框变化
    $(function () {
        getSelectVal();
        $("#bigname").change(function () {
            getSelectVal();
        });

    });

    //点击按钮的动画效果
    function look() {
        var index = layer.load(0, {shade: false});
        setTimeout(function () {
            layer.close(index);
        }, 1000);
    }
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
                title: '款式添加',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '800px'],
                content: 'add_style.php'
            });
        });
    }

//打开增加页面的弹出层
function openpage5() {
    layer.config({
        extend: 'extend/layer.ext.js'
    });
    //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
    layer.ready(function () {
        var index = layer.open({
            type: 2,
            skin: 'layui-layer-molv',
            title: '款式添加',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['1200px', '800px'],
            content: 'add_style_son.php'
        });
    });
}

//打开增加页面的弹出层
function openpage7() {
    layer.config({
        extend: 'extend/layer.ext.js'
    });
    //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
    layer.ready(function () {
        var index = layer.open({
            type: 2,
            skin: 'layui-layer-molv',
            title: '印记添加',
            fix: false,
            shadeClose: true,
            maxmin: true,
            area: ['900px', '700px'],
            content: 'add_style_yingj.php'
        });
    });
}

    //打开编辑页面的弹出层 edit_style_adminyinj.php
    function openpage2(editid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '款式编辑',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1200px', '800px'],
                content: 'edit_style_admin.php?editid=' + editid
            });
        });
    }

    //打开印记编辑页面的弹出层
    function openpage8(editid) {
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function () {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '款式编辑',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['900px', '700px'],
                content: 'edit_style_adminyinj.php?editid=' + editid
            });
        });
    }

    //ajax 删除数据
    function openpage3(id) {
        var delid = id;
        layer.confirm('与之对应的现货列表都将删除，请谨慎操作！', {
            btn: ['确认', '取消'] //按钮
        }, function () {
            $.ajax({
                type: "POST",
                url: "del_style.php",
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
    //ajax 加排序
    function openpage6(id, style_new) {
        var delid = id;
        if (style_new) {
            $.ajax({
                type: "POST",
                url: "editpro_style.php",
                data: "delid=" + delid + "&new_no=" + style_new,
                success: function (msg) {
                    if (msg == 'go') {
                        layer.msg('修改成功', {time: 1000,});
                        window.location.reload();
                    } else {
                        layer.msg('货品不是新款推荐！', {time: 1000,});
                    }
                }
            });
        } else {
            layer.msg('货品不是新款推荐！', {time: 1000,});
        }

    }

    //ajax 找到现货列表的最大值和最小值
    function openpage4(style_no, id) {
        $.ajax({
            type: "POST",
            url: "style_min_max.php",
            data: "style_no=" + style_no + "&id=" + id,
            success: function (msg) {
            }
        });
    }
</script>

</body>
</html>