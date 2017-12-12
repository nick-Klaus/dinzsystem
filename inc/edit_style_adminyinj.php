<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$c_uid = $_SESSION['uid'];
//找出分类的数据
$area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid in (1,0) ");
$area = isset($area) ? $area : array();
//接收需要编辑数据的id号
$editid = $_GET['editid'];
$rs = fetchOne("select * from e_goods_sylte  where id='$editid'");
$json = json_decode($rs['thumb_url'], true);
$json = empty($json) ? array() : $json;

if ($rs['best64'] == 1) {
    $img_url = 'http://imageserver.echao.com/imagespath/';
} else {
    $img_url = 'http://imageserver.echao.com/';
}

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

    </style>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b>款式编辑</b></legend>
</fieldset>
<form class="layui-form" action="">
    <input type='hidden' name='id' value="<?php echo $rs['id'] ?>">
    <input type='hidden' name='uid' value="<?php echo $rs['adduid'] ?>">
    <input type='hidden' name='cls1' value="<?php echo $rs['cls1'] ?>">
    <table class="layui-table">

        <tr>
            <td align="right">品名:</td>
            <td >
                <input name="style_name" type="text" id="style_name" value="<?= $rs['style_name'] ?>" lay-verify="title"
                       autocomplete="off" placeholder="请输入品名" class="layui-input" style='width:200px;'>
            </td>

            <td align="right">款号:</td>
            <td>
                <input name="style_no" type="text" id="style_no" value="<?= $rs['style_no'] ?>" lay-verify="title"
                       autocomplete="off" placeholder="请输入款号" class="layui-input" style='width:200px;'>
            </td>
        </tr>

        <tr>
            <td align="right">印记:</td>
            <td width="300">
                <input type="radio" value="1" name="style_sort" id="style_sort"
                       title="有" <?php if ($rs['style_sort'] == 1) {
                    echo "checked='checked'";
                } ?> />
                <input type="radio" value="0" name="style_sort" id="style_sort"
                       title="无" <?php if ($rs['style_sort'] == 0) {
                    echo "checked='checked'";
                } ?> /></td>

            <td align="right">定制:</td>
            <td >
                <input type="radio" value="0" name="style_mode" id="style_mode"
                       title="中圈" <?php if ($rs['style_mode'] == 0) {
                    echo "checked='checked'";
                } ?> />
                <input type="radio" value="1" name="style_mode" id="style_mode"
                       title="边圈" <?php if ($rs['style_mode'] == 1) {
                    echo "checked='checked'";
                } ?> />
                <input type="radio" value="2" name="style_mode" id="style_mode"
                       title="杯底" <?php if ($rs['style_mode'] == 2) {
                    echo "checked='checked'";
                } ?> />
            </td>
        </tr>

        <tr>
            <td align="right">库存:</td>
            <td>
                <div style='height:30px;line-height:30px;'>
                    <input name="stocks" type="text" id="stocks"  value="<?= $rs['stocks'] ?>"  size="10" lay-verify="title" autocomplete="off" placeholder="请输入库存数量" class="layui-input" style='width:200px;float:left' >
                    件</div></td>

            <td align="right">款式价格:</td>
            <td><input name="MinPrice" type="text" id="MinPrice" value="<?= $rs['MinPrice'] ?>" size="10"
                       lay-verify="title" autocomplete="off" placeholder="最低价格" class="layui-input"
                       style='width:150px;float:left'>
                <input name="MaxPrice" type="text" id="MaxPrice" value="<?= $rs['MaxPrice'] ?>" size="10"
                       lay-verify="title" autocomplete="off" placeholder="最高价格" class="layui-input"
                       style='width:150px;float:left;margin-left:20px;'></td>
        </tr>

        <tr>
            <td align="right">缩略图:</td>
            <td>
                <div>
                    <img id='imgurl' src="<?php echo $img_url . $rs['style_thumb'] ?>"
                         style='height:65px;width:65px;border:1px solid #ccc;float:left;'>
                </div>
                <input type="hidden" name="style_thumb" id="style_thumb" value="<?= $rs['style_thumb'] ?>"
                       lay-verify="title" autocomplete="off" placeholder="请输点击加入图片" class="layui-input"
                       style='width:200px;margin:30px 0px 0px 20px;'>
                <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>
                    点击选图
                </button>
            </td>

            <td align="right">图片:</td>
            <td>
                <div class="picbox_2 p_style_video">
                    <img id="sampleMovie" src="<?php echo $img_url .$rs['style_video'] ?>"
                           style='height:65px;width:65px;border:1px solid #ccc;float:left;'>
                </div>
                <input type="hidden" name="style_video" id="style_video" value="<?= $rs['style_video'] ?>"
                       onClick="open_pic_box('style_video')" lay-verify="title" autocomplete="off" placeholder="点击添加视频"
                       class="layui-input" style='width:200px;margin:30px 0px 0px 20px;'>
                <button type="button" id="style_video_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>
                    点击选图
                </button>
            </td>
        </tr>

        <tr>
            <td align="right">描述:</td>
            <td colspan="3">
                <!-- <textarea class="doc_ta" rows="5"  id="content" style="width:100%" ><?= $rs['content'] ?> -->
                <textarea placeholder="请输入描述内容" class="layui-textarea"
                          name="content"><?php echo $rs['content'] ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">　提交　</button>
            </td>
        </tr>
    </table>

</form>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>



    layui.use(['form', 'layedit', 'laydate'], function () {

        var form = layui.form()
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
        var adminurl = "./editpro_style.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');


        //点击出现弹出层
        $('#style_thumb_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                var img = document.getElementById('imgurl');
                var input = document.getElementById('style_thumb');
                img.src = 'http://imageserver.echao.com/uploadfile/' + src;
                input.value = "/uploadfile/" + src;
                layer.close(index);
            }
        });

//点击出现弹出层
        $('#style_video_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                var img = document.getElementById('sampleMovie');
                var input = document.getElementById('style_video');
                img.src = 'http://imageserver.echao.com/uploadfile/' + src;
                input.value = "/uploadfile/" + src;
                layer.close(index);
            }
        });




        //监听提交
        form.on('submit(demo1)', function (data) {
            //console.log(data);
            $.post(adminurl, data.field, function (json) {
                //console.log(json);
                if (json == 'go') {
                    layer.msg('编辑成功');
                    //关闭子页面
                    parent.location.reload();
                } else {
                    layer.msg('编辑失败', function () {
                    });
                }
            });
            return false;
        });
    });

    layui.use('element', function () {
        var $ = layui.jquery
            , element = layui.element(); //Tab的切换功能，切换事件监听等，需要依赖element模块

        //触发事件
        var active = {
            tabAdd: function () {
                //新增一个Tab项
                element.tabAdd('demo', {
                    title: '新选项' + (Math.random() * 1000 | 0) //用于演示
                    , content: '内容' + (Math.random() * 1000 | 0)
                })
            }
            , tabChange: function () {
                //切换到指定Tab项
                element.tabChange('demo', 1); //切换到第2项（注意序号是从0开始计算）
            }
        };

        $('.site-demo-active').on('click', function () {
            var type = $(this).data('type');
            active[type] ? active[type].call(this) : '';
        });
    });


</script>

</body>
</html>