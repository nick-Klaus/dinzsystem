<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_GET['uid'];
$sql = "select * from bargain_admin_addurl  where id=".$id;
$rs = fetchOne($sql);

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
    <legend><b>编辑注册信息</b></legend>
</fieldset>

<form class="layui-form" action="">
    <input type="hidden" name="id" value="<?=$rs['id']?>">
    <input type="hidden" name="addurl" value="imgurl">
    <div class="layui-form-item">
        <label class="layui-form-label">备注：</label>
        <div class="layui-input-block">
            <input type="text" name="remark" lay-verify="title" autocomplete="off" placeholder="请输入备注" class="layui-input" value="<?=$rs['remark']?>" >
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
        var adminurl="bargain_template_updatepro.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');

        //监听提交
        form.on('submit(demo1)', function(data){
             // console.log(data);
            $.post(adminurl,data.field,function( json ){
               //  console.log(json);
                if( json == 'go' ){
                    layer.msg('修改成功');
                    //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('修改失败,上级id不能为0', function(){
                    });
                    console.log(json);
                }
            });
            return false;
        });
    });

</script>

</body>
</html>