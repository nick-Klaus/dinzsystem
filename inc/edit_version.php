<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
$editid = $_GET['editid'];

$sql = "select * from soft_version_name where id='$editid'";

$res =  fetchOne($sql);

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

        body{
            padding:10px;
        }

    </style>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
    <legend><b>编辑版本内容</b></legend>
</fieldset>

<form class="layui-form" action="">
    <input type="hidden" name="id" value="<?php echo $res['id'] ?>" />
    <div class="layui-form-item">
        <label class="layui-form-label">版本名称：</label>
        <div class="layui-input-block">
            <input type="text" name="version_name" lay-verify="title" value="<?php echo $res['version_name'] ?>" autocomplete="off" placeholder="请输入版本名称" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">版本文件：</label>
        <div class="layui-input-block">
            <input type="text" name="version_folder" lay-verify="title" value="<?php echo $res['version_folder'] ?>"  autocomplete="off" placeholder="请输入版本文件" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit="" lay-filter="demo1" >立即提交</button>
        </div>
    </div>
</form>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>

    layui.use(['form', 'layedit', 'laydate'], function(){

        var form = layui.form()
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
        var adminurl="./editpro_version.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //自定义验证规则
        form.verify({
            title: function(value){
                if(value.length < 3){
                    return '此项为必填选项，最少三个字符！';
                }
            }
            ,pass: [/(.+){6,12}$/, '密码必须6到12位']
            ,content: function(value){
                layedit.sync(editIndex);
            }
        });

        //监听提交
        form.on('submit(demo1)', function(data){
            //console.log(data);
            $.post(adminurl,data.field,function( json ){
                console.log(json);
                if( json == 'go' ){
                    layer.msg('编辑成功！');
                    //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('增加失败!', function(){
                    });
                }
            });
            return false;
        });
    });

</script>

</body>
</html>