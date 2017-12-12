<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

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

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend><b>砍价信息</b></legend>
</fieldset>

<?
$id = $_GET['id'];
$sql = "select * from bargain where id='$id'";

$rs = fetchOne($sql);
$json = json_decode($rs['gift_describe'], true);
$json = empty($json) ? array() : $json;


$_json = json_decode($rs['company_introduction_img'], true);
$_json = empty($_json) ? array() : $_json;

$json_logo = json_decode($rs['image_logo'], true);
$json_logo = empty($json_logo) ? array() : $json_logo;

?>
<form class="layui-form" action="">
    <table class="layui-table">

        <input type="hidden" name="id" value="<?= $rs['id'] ?>">
        <input type="hidden" name="image_all" value="banner">
        <tr>
            <td height="35" align="right" width="200">顶部Logo图：</td>

<!--            <td>-->
<!--                <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">-->
<!--                    <img src="--><?//= $rs['image_logo'] ?><!--" id='imgurl' style="width:100%;height:100%">-->
<!--                </div>-->
<!--                <input type="hidden" name="image_logo" id="style_thumb" placeholder="点击上传图片" class="layui-input"-->
<!--                       style="width:300px;" value="--><?//= $rs['image_logo'] ?><!--">-->
<!--                <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style="margin-top:10px;">-->
<!--                    点击选图-->
<!--                </button>-->
<!--            </td>-->
            <td>

                <div class="layui-input-block">
                    <input type="hidden" id="pages_image" name="image_logo" lay-verify="user_bz" readonly="1"
                           autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"
                           value="<?php echo implode(",", $json_logo); ?>">
                    <button type="button" id="pages_logo" class="layui-btn layui-btn-radius">
                        点击选图（上传多张图片可重复点击，尺寸：370*168）
                    </button>
                    <div id='pageall_logo' style='height:135px;'>
                        <?php

                        $arr = json_decode($rs['image_logo'], true);
                        $arr = empty($arr) ? array() : $arr;

                        foreach ($arr as $key => $value) {
                            echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='" . $value . "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage_logo()' href='Javascript: void(0)'   >&times;</a></div>";
                        }

                        ?>
                    </div>

                </div>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">活动标题：</td>
            <td><input name="title" type="text" id="uid" value="<?php echo $rs['title'] ?>" placeholder="活动标题"
                       class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">活动开始时间：</td>
            <td>
                <div class="layui-inline">
                    <input class="layui-input" name="start_time" placeholder="自定义日期格式"
                           onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
                           value="<?php echo $rs['start_time'] ?>">
                </div>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">活动结束时间：</td>
            <td>
                <div class="layui-inline"><input class="layui-input" name="end_time" placeholder="自定义日期格式"
                                                 onclick="layui.laydate({elem: this, istime: true, format: 'YYYY-MM-DD hh:mm:ss'})"
                                                 value="<?php echo $rs['end_time'] ?>">
                </div>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">原价：</td>
            <td><input name="original_price" type="text" value="<?php echo $rs['original_price'] ?>" placeholder="活动原价"
                       class="layui-input"/></td>
        </tr>


        <tr>
            <td height="35" align="right" width="200">底价：</td>
            <td><input name="floor_price" type="text" value="<?php echo $rs['floor_price'] ?>" placeholder="请输入设备备注"
                       class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">砍价次数：</td>
            <td><input name="bargain_times" type="text" value="<?php echo $rs['bargain_times'] ?>" placeholder="砍价次数"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">最低减价：</td>
            <td><input name="min_sale" type="text" value="<?php echo $rs['min_sale'] ?>" placeholder="最低减价"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">最高减价：</td>
            <td><input name="max_sale" type="text" value="<?php echo $rs['max_sale'] ?>" placeholder="最高减价"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">剩余奖品数量：</td>
            <td><input name="new_gift_quantity" type="text" value="<?php echo $rs['new_gift_quantity'] ?>"
                       placeholder="剩余奖品数量" autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">总奖品数量：</td>
            <td><input name="gift_quantity" type="text" value="<?php echo $rs['gift_quantity'] ?>" placeholder="总奖品数量"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">最大报名人数：</td>
            <td><input name="max_people" type="text" value="<?php echo $rs['max_people'] ?>" placeholder="最大报名人数"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">奖品说明：</td>
            <td><textarea class="layui-textarea" name="gift_describe_txt"> <?php echo $rs['gift_describe_txt'] ?>
        </textarea>
            </td>
        </tr>


        <tr>
            <td height="35" align="right" width="200">奖品描述：</td>
            <td>

                <div class="layui-input-block">
                    <input type="hidden" id="pages" name="gift_describe" lay-verify="user_bz" readonly="1"
                           autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"
                           value="<?php echo implode(",", $json); ?>">
                    <button type="button" id="pages_cl" class="layui-btn layui-btn-radius">
                        点击选图（上传多张图片可重复点击，尺寸：370*168）
                    </button>
                    <div id='pageall' style='height:135px;'>
                        <?php

                        $arr = json_decode($rs['gift_describe'], true);
                        $arr = empty($arr) ? array() : $arr;

                        foreach ($arr as $key => $value) {
                            echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='" . $value . "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>";
                        }

                        ?>
                    </div>

                </div>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">活动规则：</td>
            <td><textarea class="layui-textarea" name="activity_rules"> <?php echo $rs['activity_rules'] ?>
        </textarea>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">领奖信息：</td>
            <td><textarea class="layui-textarea" name="award_information"> <?php echo $rs['award_information'] ?>
        </textarea>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">联系人二维码：</td>

            <td>
                <div style="width:70px;height:70px;border:#efefef 1px solid;text-align:center" class="cbox p_mac_logo">
                    <img src="<?= $rs['contact_img'] ?>" id='_imgurl' style="width:100%;height:100%">
                </div>
                <input type="hidden" name="contact_img" id="_style_thumb" placeholder="点击上传图片" class="layui-input"
                       style="width:300px;" value="<?= $rs['contact_img'] ?>">
                <button type="button" id="_style_thumb_cl" class="layui-btn layui-btn-radius" style="margin-top:10px;">
                    点击选图
                </button>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">品牌介绍：</td>
            <td><textarea class="layui-textarea" name="company_introduction"> <?php echo $rs['company_introduction'] ?>
        </textarea>
            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">品牌描述：</td>
            <td>

                <div class="layui-input-block">
                    <input type="hidden" id="_pages" name="company_introduction_img" lay-verify="user_bz" readonly="1"
                           autocomplete="off" placeholder="点击上传图片(可上传多张)" class="layui-input"
                           value="<?php echo implode(",", $_json); ?>">
                    <button type="button" id="_pages_cl" class="layui-btn layui-btn-radius">
                        点击选图（上传多张图片可重复点击，尺寸：370*168）
                    </button>
                    <div id='_pageall' style='height:135px;'>
                        <?php

                        $arr = json_decode($rs['company_introduction_img'], true);
                        $arr = empty($arr) ? array() : $arr;

                        foreach ($arr as $key => $value) {
                            echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='" . $value . "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='_delpage()' href='Javascript: void(0)'   >&times;</a></div>";
                        }

                        ?>
                    </div>

                </div>


            </td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">咨询热线：</td>
            <td><input name="phone_number" type="text" value="<?php echo $rs['phone_number'] ?>" placeholder="咨询热线"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td height="35" align="right" width="200">备注：</td>
            <td><input name="remark" type="text" value="<?php echo $rs['remark'] ?>" placeholder="活动备注"
                       autocomplete="off" class="layui-input"/></td>
        </tr>

        <tr>
            <td width="200">&nbsp;</td>
            <td height="24" align="left">
                <button class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
            </td>
        </tr>
</form>

</table>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

    var inputObj = document.getElementById('pages');
    var mycars = inputObj.value.split(",");//表单内原有的图片地址变为数组
    var parentObj = document.getElementById('pageall');
    var chil1 = parentObj.getElementsByTagName("div");
    function delpage() {
        for (var i = 0; i < chil1.length; i++) {
            chil1[i].index = i;
            chil1[i].onclick = function () {
                var j = this.index;
                parentObj.removeChild(chil1[j]);//清除点击当前的图片
                mycars.splice(j, 1);//清除图片地址在数组中的位置
                inputObj.value = mycars.join(",");//从新把数组符给表单
            };
        }
    }


    var _inputObj = document.getElementById('_pages');
    var _mycars = _inputObj.value.split(",");//表单内原有的图片地址变为数组
    var _parentObj = document.getElementById('_pageall');
    var _chil1 = _parentObj.getElementsByTagName("div");
    function _delpage() {
        for (var i = 0; i < _chil1.length; i++) {
            _chil1[i]._index = i;
            _chil1[i].onclick = function () {
                var _j = this._index;
                _parentObj.removeChild(_chil1[_j]);//清除点击当前的图片
                _mycars.splice(_j, 1);//清除图片地址在数组中的位置
                _inputObj.value = _mycars.join(",");//从新把数组符给表单
            };
        }
    }

    var inputObj_image = document.getElementById('pages_image');
    var mycars_image = inputObj_image.value.split(",");//表单内原有的图片地址变为数组
    var parentObj_image = document.getElementById('pageall_logo');
    var chil1_image = parentObj_image.getElementsByTagName("div");
    function delpage_logo() {
        for (var i = 0; i < chil1_image.length; i++) {
            chil1_image[i].index = i;
            chil1_image[i].onclick = function () {
                var j = this.index;
                parentObj_image.removeChild(chil1_image[j]);//清除点击当前的图片
                mycars_image.splice(j, 1);//清除图片地址在数组中的位置
                inputObj_image.value = mycars_image.join(",");//从新把数组符给表单
            };
        }
    }


    layui.use(['form', 'layedit', 'laydate'], function () {

        var form = layui.form()
            , layer = layui.layer
            , layedit = layui.layedit
            , laydate = layui.laydate;
        var adminurl = "./bargain_updatepro.php";

        //点击出现弹出层
        $('#style_thumb_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: '../../inc/pic_bargain.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                var img = document.getElementById('imgurl');
                var input = document.getElementById('style_thumb');
                img.src = 'http://imageserver.echao.com/uploadfile/' + src;
                input.value = 'http://imageserver.echao.com/uploadfile/' + src;
                layer.close(index);
            }
        });

        //点击出现弹出层
        $('#_style_thumb_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: '../../inc/pic_bargain.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                var img = document.getElementById('_imgurl');
                var input = document.getElementById('_style_thumb');
                img.src = 'http://imageserver.echao.com/uploadfile/' + src;
                input.value = 'http://imageserver.echao.com/uploadfile/' + src;
                layer.close(index);
            }
        });


        //点击添加多张图片 logo
        $('#pages_logo').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic_bargain.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                // var img=document.getElementById('imgurl');
                var input = document.getElementById('pages_image');
                // img.src='../images/'+src;
                mycars_image.push('http://imageserver.echao.com/uploadfile/' + src);
                input.value = mycars_image;

                $("#pageall_logo").append("<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/uploadfile/" + src + "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage_logo()' href='Javascript: void(0)'   >&times;</a></div>");
                layer.close(index);
            }
        });



        //点击添加多张图片
        $('#pages_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic_bargain.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                // var img=document.getElementById('imgurl');
                var input = document.getElementById('pages');
                // img.src='../images/'+src;
                mycars.push('http://imageserver.echao.com/uploadfile/' + src);
                input.value = mycars;

                $("#pageall").append("<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/uploadfile/" + src + "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>");
                layer.close(index);
            }
        });


//点击添加多张图片
        $('#_pages_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic_bargain.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                // var img=document.getElementById('imgurl');
                var _input = document.getElementById('_pages');
                // img.src='../images/'+src;
                _mycars.push('http://imageserver.echao.com/uploadfile/' + src);
                _input.value = _mycars;

                $("#_pageall").append("<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/uploadfile/" + src + "' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='_delpage()' href='Javascript: void(0)'   >&times;</a></div>");
                layer.close(index);
            }
        });


//监听提交
        form.on('submit(demo1)', function (data) {
            //console.log(data);
            $.post(adminurl, data.field, function (json) {
                console.log(json);
                if (json == 'go' || json == 'go1') {
                    layer.msg('编辑成功');
                    //关闭子页面
                    parent.location.reload();
                } else {
                    layer.msg('您没有进行数据操作！', function () {
                    });
                }
            });
            return false;
        });
    });

</script>

</body>
</html>