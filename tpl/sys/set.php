<?php
    include "./../../fun/eby_admin_api.php";
    include "./../../fun/phpfile.php";
    $uid = $_SESSION[ 'uid' ];
    $row = fetchOne ( "select * from e_members where uid=" . $uid );
    $row_huilv = fetchOne ( "select * from e_global_set" );

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset = "utf-8">
    <title>ADD</title>
    <meta name = "renderer" content = "webkit">
    <meta http-equiv = "X-UA-Compatible" content = "IE=edge,chrome=1">
    <meta name = "viewport" content = "width=device-width, initial-scale=1, maximum-scale=1">
    <meta name = "apple-mobile-web-app-status-bar-style" content = "black">
    <meta name = "apple-mobile-web-app-capable" content = "yes">
    <meta name = "format-detection" content = "telephone=no">

    <link rel = "stylesheet" href = "./../../layui/css/layui.css?t=1479413779832" media = "all">
    <link rel = "stylesheet" href = "./../../layui/css/global.css?t=1479413779832" media = "all">
    <script src = "./../../layui/jquery.min.js" charset = "utf-8"></script>
    <script src = "./../../layui/layui.js" charset = "utf-8"></script>

</head>
<body>

<fieldset class = "layui-elem-field layui-field-title" style = "margin: 20px;">
    <legend><b>系统配置</b></legend>
    <form class = "layui-form" action = "" style = "margin-top:20px">
        <input type = "hidden" name = "uid" value = "<?php echo $row[ 'uid' ] ?>" />
        <div class = "layui-form-item">
            <label class = "layui-form-label">后台Logo</label>
            <div class = "layui-input-block">
                <div style = "height:100px;width:100px; border:1px solid #ccc; margin:0px 0px 15px 0px;">
                    <img id = 'imgurl' style = "height:100px;width:100px;"
                         src = "<?php
                             if( $row[ 'style_thumb' ] ){
                                 echo "http://imageserver.echao.com/".$row[ 'style_thumb' ];
                             }else{
                                 echo "../../images/timg.jpg";
                             }
                         ?>">
                </div>
                <input type = "hidden" id = "style_thumb" name = "style_thumb"
                       value = "<?php echo $row[ 'style_thumb' ] ?>" lay-verify = "required" readonly = "1"
                       autocomplete = "off" placeholder = "点击上传图片" class = "layui-input" style = "width:300px;">
                <button type = 'button' id = "style_thumb_cl" class = "layui-btn layui-btn-radius">点击选图片</button>
            </div>
        </div>
        <div class = "layui-form-item">
            <label class = "layui-form-label">帐号</label>
            <div class = "layui-input-inline">
                <input type = "text" name = "username" lay-verify = "required" placeholder = "请输入帐号"
                       autocomplete = "off" class = "layui-input" value = "<?php echo $row[ 'username' ] ?>" disabled>
            </div>
        </div>
        <div class = "layui-form-item">
            <label class = "layui-form-label">密码</label>
            <div class = "layui-input-inline">
                <input type = "password" name = "password" lay-verify = "required" placeholder = "请输入密码"
                       autocomplete = "off" class = "layui-input" value = "<?php echo $row[ 'password' ] ?>">
            </div>
        </div>
        <div class = "layui-form-item">
            <label class = "layui-form-label">联系人</label>
            <div class = "layui-input-inline">
                <input type = "tel" name = "member_name" class = "layui-input"
                       value = "<?php echo $row[ 'member_name' ] ?>">
            </div>
        </div>
        <div class = "layui-form-item">
            <label class = "layui-form-label">电话</label>
            <div class = "layui-input-inline">
                <input type = "text" name = "member_phone" placeholder = "请输入手机号" class = "layui-input"
                       value = "<?php echo $row[ 'member_phone' ] ?>">
            </div>
        </div>


        <div class = "layui-form-item hid">
            <label class = "layui-form-label">数据标识</label>
            <div class = "layui-input-inline">
                <input type = "text" name = "maydiakeys" placeholder = "请输入数据标识(关键字标识)" class = "layui-input"
                       value = "<?php echo $row[ 'maydiakeys' ] ?>">
            </div>
            <label class = "layui-form-label" style = "color:#1AA094;">（关键字）</label>
        </div>
        <div class = "layui-form-item hid">
            <label class = "layui-form-label">数据标识</label>
            <div class = "layui-input-inline">
                <input type = "text" name = "maydiatable" autocomplete = "off" placeholder = "请输入数据标识(表格标识)"
                       class = "layui-input" value = "<?php echo $row[ 'maydiatable' ] ?>">
            </div>
            <label class = "layui-form-label" style = "color:#1AA094;">（表 格）</label>
        </div>

        <div class = "layui-form-item hid">
            <label class = "layui-form-label">款式分类</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "categorytype" value = "0"
                       title = "系统数据" <?php if ( $row[ 'categorytype' ] == '0' ) {
                    echo 'checked';
                } ?>/ />
                <input type = "radio" name = "categorytype" value = "1"
                       title = "全部数据" <? if ( $row[ 'categorytype' ] == '1' ) {
                    echo 'checked';
                } ?>/>
                <input type = "radio" name = "categorytype" value = "2"
                       title = "除系统数据以外的全部数据" <? if ( $row[ 'categorytype' ] == '2' ) {
                    echo 'checked';
                } ?>/>
                <input type = "radio" name = "categorytype" value = "3"
                       title = "自定义数据" <? if ( $row[ 'categorytype' ] == '3' ) {
                    echo 'checked';
                } ?>/>
            </div>
        </div>


        <div class = "layui-form-item hid">
            <label class = "layui-form-label">裸石数据</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "diamond_data_typ" value = "0"
                       title = "B2B裸石数据" <?php if ( $row[ 'diamond_data_typ' ] == '0' ) {
                    echo 'checked';
                } ?> checked = 'checked' />
                <input type = "radio" name = "diamond_data_typ" value = "2"
                       title = "B2C裸石数据" <?php if ( $row[ 'diamond_data_typ' ] == '2' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "diamond_data_typ" value = "1"
                       title = "B2C数据+自定义" <?php if ( $row[ 'diamond_data_typ' ] == '1' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "diamond_data_typ" value = "3"
                       title = "自定义数据" <?php if ( $row[ 'diamond_data_typ' ] == '3' ) {
                    echo 'checked';
                } ?> />
            </div>
        </div>
        <div class = "layui-form-item hid">
            <label class = "layui-form-label">款式数据</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "datatype" value = "0"
                       title = "系统数据" <?php if ( $row[ 'datatype' ] == '0' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "datatype" value = "1"
                       title = "全部数据" <?php if ( $row[ 'datatype' ] == '1' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "datatype" value = "2"
                       title = "除系统数据以外的全部数据" <?php if ( $row[ 'datatype' ] == '2' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "datatype" value = "3"
                       title = "自定义数据" <?php if ( $row[ 'datatype' ] == '3' ) {
                    echo 'checked';
                } ?> />
            </div>
        </div>

        <div class = "layui-form-item hid">
            <label class = "layui-form-label">营销.引流</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "marketing" value = "0"
                       title = "系统数据" <?php if ( $row[ 'marketing' ] == '0' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "marketing" value = "1"
                       title = "全部数据" <?php if ( $row[ 'marketing' ] == '1' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "marketing" value = "2"
                       title = "除系统数据以外的全部数据" <?php if ( $row[ 'marketing' ] == '2' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "marketing" value = "3"
                       title = "自定义数据" <?php if ( $row[ 'marketing' ] == '3' ) {
                    echo 'checked';
                } ?> />
            </div>
        </div>


        <div class = "layui-form-item hid">
            <label class = "layui-form-label">培训</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "train" value = "0" title = "系统数据" <?php if ( $row[ 'train' ] == '0' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "train" value = "1" title = "全部数据" <?php if ( $row[ 'train' ] == '1' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "train" value = "2"
                       title = "除系统数据以外的全部数据" <?php if ( $row[ 'train' ] == '2' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "train" value = "3" title = "自定义数据" <?php if ( $row[ 'train' ] == '3' ) {
                    echo 'checked';
                } ?> />
            </div>
        </div>

        <div class = "layui-form-item hid">
            <label class = "layui-form-label">专题套系</label>
            <div class = "layui-input-block">
                <input type = "radio" name = "thematic_sets" value = "0"
                       title = "系统数据" <?php if ( $row[ 'thematic_sets' ] == '0' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "thematic_sets" value = "1"
                       title = "全部数据" <?php if ( $row[ 'thematic_sets' ] == '1' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "thematic_sets" value = "2"
                       title = "除系统数据以外的全部数据" <?php if ( $row[ 'thematic_sets' ] == '2' ) {
                    echo 'checked';
                } ?> />
                <input type = "radio" name = "thematic_sets" value = "3"
                       title = "自定义数据" <?php if ( $row[ 'thematic_sets' ] == '3' ) {
                    echo 'checked';
                } ?> />
            </div>
        </div>


        <div class = "layui-form-item">
            <div class = "layui-inline">
                <label class = "layui-form-label">结算汇率</label>
                <div class = "layui-input-block">
                    <input type = "text" name = "huilv" lay-verify = "required" autocomplete = "off"
                           class = "layui-input" value = "<?php if ( $row[ 'huilv' ] ) {
                        echo $row[ 'huilv' ];
                    } else {
                        echo $row_huilv[ 'huilv' ];
                    } ?>">
                </div>
            </div>
        </div>
        <div class = "layui-form-item">
            <label class = "layui-form-label">订单通知</label>
            <div class = "layui-input-block" style = 'height:40px; line-height:40px;'>
                <input type = "text" name = "order_notice" autocomplete = "off" placeholder = "请在此填入公众号回复内容"
                       class = "layui-input" value = "<?php echo $row[ 'order_notice' ] ?>"
                       style = 'width:185px;float:left;'> <span style = 'color:#33AB9F;margin-left:20px;'>*请关注公众号 jinghannet 后发送:“ORDER_NOTICE#定制系统#<?php echo $row[ 'uid' ] ?>
                                                                                                          ”,系统将会返回订单通知内容*</span>
            </div>
        </div>
        <div class = "layui-form-item">
            <div class = "layui-input-block">
                <button class = "layui-btn" lay-submit = "" lay-filter = "demo1">立即提交</button>
                <!-- <a  href='./../../inc/gold_income.php?webid=<?php echo $row[ 'webid' ] ?>' class="layui-btn">金生钱</a> -->
            </div>
        </div>
    </form>
</fieldset>
<script>
    //如果登录的uid不是1则隐藏div
    $(function () {
        var hidd = "<?php echo $uid ?>";
        if (hidd > 1) {
            $(".hid").css("display", "none");
        }
    })


    layui.use(['element', 'form', 'layedit', 'laydate'], function () {
        var element = layui.element();
        var form = layui.form();
        var adminurl = "../../inc/member_update.php";
        //,layer = layui.layer;

        // 自定义验证规则
        // form.verify({
        //   title: function(value){
        //     if(value.length < 5){
        //       return '标题至少得5个字符啊';
        //     }
        //   }
        //   ,pass: [/(.+){6,12}$/, '密码必须6到12位']
        //   ,content: function(value){
        //     layedit.sync(editIndex);
        //   }
        // });


        //点击出现弹出层
        $('#style_thumb_cl').on('click', function () {
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: '../../inc/pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function (src) {
                var img = document.getElementById('imgurl');
                var input = document.getElementById('style_thumb');
                img.src = 'http://imageserver.echao.com/uploadfile/' + src;
                input.value = 'uploadfile/' + src;
                layer.close(index);
            }
        });

        //监听提交
        form.on('submit(demo1)', function (data) {
            //console.log(data);
            var index = layer.load(0, {shade: false});
            $.post(adminurl, data.field, function (json) {
                if (json == "go") {
                    //配置一个透明的询问框
                    layer.msg('修改成功', {
                        time: 1000, //1s后自动关闭
                        btn: []
                    });
                    layer.close(index);
                }
            });
            return false;
        });
    });

</script>


</body>
</html>