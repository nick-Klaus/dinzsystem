<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = 1;

$qdz_type = $_GET['qdz_type'] ? $_GET['qdz_type'] : 1;


$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid=" . $c_uid);
$area = isset($area) ? $area : array();
$tcls1 = $_GET['cls1'];
$tcls2 = $_GET['cls2'];
//接收表单传来的值
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

        .layui-form-item select {
            width: 200px;
            height: 35px;
            border: 1px solid #ccc;
            font-size: 14px;
            -webkit-appearance: none;
        }

        .img_hover:hover {
            transform: scale(3); /*指的是放大的倍数*/
        }

        body {
            min-width: 950px;
            overflow: auto;
        }
    </style>
</head>
<body>
<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b>款式管理</b></legend>

    <form name="form1" action="">
        <table class="layui-table">
            <tr style='background:#ffffff;'>
                <td style='border:none;'></td>
                <td colspan="2" style='border:none;'>
                    <!-- <select  name="cls1" id="cls1" data-value="<?= $cls1 ?>" data-first-title="选择分类"  ></select> -->
                    <input type="hidden" name="qdz_type" value="<?= $qdz_type ?>">

                    <div class="layui-form-item" style=" margin-top:15px;text-align:right;width: 100%;">
                        <select name="cls1" id='bigname' style='padding:0px 10px;width:40%;'>
                            <option value="">请选择顶级分类</option>
                            <?php
                            $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid=" . $c_uid);

                            foreach ($arr1 as $v) {
                                ?>
                                <option value="<?php echo $v['id'] ?>" <?php if ($v['id'] == $cls1) {
                                    echo 'selected';
                                } ?> ><?php echo $v['catename']; ?></option>
                                <?php
                            }
                            ?>
                        </select>　　

                        <select name="cls2" id='smallname' style='padding:0px 10px;width:40%;'>
                            <option value="">请选择子级分类</option>

                        </select>
                    </div>
                </td>

                <td colspan="8" style='border:none;'>
                    <!-- <input type="text" name="factory_no" lay-verify="title" autocomplete="off" placeholder="请输入款号" class="layui-input" style='width:300px; float:left; '> -->
                    <input type="text" name="keys" lay-verify="title" autocomplete="off" placeholder="请输入款号或款名"
                           class="layui-input" style='width:30%; float:left;margin:0px 25px 0px 15px;'
                           value="<?php if ($keys) {
                               echo $keys;
                           } ?>">
                    <button type="submit" class="layui-btn" onclick="look()">提交查询</button>
                    <a href='./qdz_add.php?qdz_type=<?= $qdz_type ?>' class="layui-btn" onclick="look()">返回</a>
                </td>
    </form>
    </tr>
    <form method='post' action="style_all.php?qdz_type=<?php echo $qdz_type ?>" id='form2'>
        <?php

        $sql = "select * from e_goods_sylte  where displays = '0' and adduid='1' and qdz_type=0";
        if ($cls1) $sql .= " and cls1='$cls1' ";
        if ($cls2) $sql .= " and cls2='$cls2' ";
        if ($cls3) $sql .= " and cls3='$cls3' ";
        if ($keys) $sql .= " and (style_no like '$keys%' or factory_no like '$keys%') and displays = 0 ";
        $sql .= " order by id desc";
        $page_get .= "&cls1=" . $cls1 . "&cls2=" . $cls2 . "&cls3=" . $cls3 . "&keys=" . $keys . "&qdz_type=" . $qdz_type;

        //选中返回的页数
        if ($_GET['_page']) {
            $s = $_GET['_page'];
        }

        pages($sql, $s, $page_get, 10);
        ?>
        <tr align='center' style="background:#51545F;color:#ffffff;height:45px;">
            <td style='width:45px;'><input type="checkbox" name="" id='checkall'></td>
            <td><b>图片</b></td>
            <td><b>品名</b></td>
            <td><b>款号</b></td>
            <td><b>编辑</b></td>
            <td><b>库存</b></td>
            <td width="200"><b>现货列表</b></td>
        </tr>
        <?php
        while ($rs = mysql_fetch_array($results_date)) {


            ?>
            <tr align="center">
                <td>
                    <input type="checkbox" name="addids[]" value="<?= $rs['id'] ?>" class='checkson'>
                    <input type="hidden" name="page" value="<?php echo $s ?>">
                </td>
                <td><img class='img_hover' class="imgbig"
                         src="http://imageserver.echao.com/<?= $rs['best64'] ? 'imagespath/' : '' ?><?= urldecode($rs['style_thumb']) ?>"
                         style="width:60px;height:60px"></td>
                <td><?= $rs['style_name'] ?></td>
                <td><?= $rs['style_no'] ?></td>
                <td style="line-height:30px">-</td>
                <td> 库存 (<?= $rs['stocks'] ?>)</td>
                <td><a href="javascript:void(0);" class="layui-btn">现货列表</a> <?php
                    //如果登录为主管理帐号uid=1 则没有上架下架

                    $past_id = "select qdz_type,past_id from e_goods_sylte  where displays = '0' and qdz_type='$qdz_type' and adduid=" . $_SESSION['uid'];
                    $past = fetchAll($past_id);
                    $array = array(
                        "past_id" => $rs['id'],
                        "qdz_type" => $qdz_type
                    );
                    //按钮的显示，已经上架则为下架按钮，没上架为下架按钮
                    if (@in_array($array, $past)) {
                        echo "<a href='style_all.php?del=" . $rs['id'] . "&page=" . $s . "&qdz_type=" . $qdz_type . "' onclick='look()' class='layui-btn layui-btn-danger' >下架</a>";
                    } else {
                        echo "<a href='style_all.php?add=" . $rs['id'] . "&page=" . $s . "&qdz_type=" . $qdz_type . "'  onclick='look()' class='layui-btn' >上架</a>";
                    }

                    ?></td>
            </tr>

            <?php
        }

        ?>
        <tr align='center' style=' background:#ffffff;'>
            <td>
                <button  onclick='look()' class='layui-btn' type='submit'>批量上/下架</button>
            </td>
            <td colspan="7"> <?php echo $pageNavi; ?> 共 <span style='color:#009688;'><?php echo $numrows_date; ?></span>
                条
            </td>
        </tr>
    </form>
    </table>
</fieldset>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>
<script>

    //ajax传输顶级分类的id到style_ajax.php
    function getSelectVal() {
        var defval = "<?php echo $tcls2 ?>";
        if ($("#bigname").val() == 0) {
            $("#smallname").css('display', 'none');
        } else {
            $("#smallname").css('display', '');
        }
        $.getJSON("style_ajax.php", {bigname: $("#bigname").val()}, function (json) {
            var smallname = $("#smallname");
            //清空原有的选项
            $("option", smallname).remove();
            $.each(json, function (index, array) {
                //将返回的子级数据加入到子级分类的框中
                if (defval == array['id']) {
                    var option = "<option  selected='selected'  value='" + array['id'] + "'>" + array['catename'] + "</option>"
                } else {
                    var option = "<option   value='" + array['id'] + "'>" + array['catename'] + "</option>";
                }
                smallname.append(option);
            });
        });
    }


    $(function () {
        //触发下拉框变化
        getSelectVal();
        $("#bigname").change(function () {
            getSelectVal();
        });
//点击全选
        $("#checkall").click(function () {
            if (this.checked) {
                $(".checkson").prop("checked", true);
            } else {
                $(".checkson").prop("checked", false);
            }
        });

    });

    //点击按钮的动画效果
    function look() {
        var index = layer.load(0, {shade: false});
        setTimeout(function () {
            layer.close(index);
        }, 1000);
    }


</script>

</body>
</html>