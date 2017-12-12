<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

 $sql = "select id,catename,webid,pid,adduid,box_default_ico,sort from e_goods_category where  adduid='0' order by times desc ";

$area = fetchAll($sql);
$area = isset($area)?$area:array();


function subtree2($arr,$id=0,$lev=1) {
     $subs = array(); //子孙数组
    foreach ($arr as $v) {
        if ($v['pid'] == $id) {
            $v['lev'] = $lev;
            $subs[] = $v; //举例说array('id'=>1,'name'=>'安徽','parent'=>0),
            $subs = array_merge($subs, subtree2($arr,$v['id'],$lev+1));
        }
    }
    return $subs;
}


$tree = subtree2($area,0,1);

//var_dump( $tree );

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

<fieldset class="layui-elem-field layui-field-title" style="margin:20px 0px 40px 0px;">
    <legend><b>添加产品分类</b></legend>
</fieldset>

<form class="layui-form" action="">
    <input type="hidden" name="jians" value="yes">
    <div class="layui-form-item">
        <label class="layui-form-label">分类名：</label>
        <div class="layui-input-block">
            <input type="text" name="catename" lay-verify="title" autocomplete="off" placeholder="请输入分类名" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item" style='height:42px;line-height:42px;'>
        <label class="layui-form-label">上级分类：</label>
        <div class="layui-input-inline">
            <select name="pid">
                <option value="77">珠宝鉴赏</option>
              <?php  

              foreach ($tree as $k => $v) {
                  
              ?>  
                <option value="<?php echo  $v['id']?>"><?php  if( $v['lev'] > 1 ){ echo "|".str_repeat('－－',$v['lev']-1),$v['catename']; }  ?></option>
              <?php

              }
              ?>  
            </select>

        </div>
        <div style='color:#019F95;'>（*只有主管理帐号才能添加！*）</div>
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
        var adminurl="./addpro_category.php";
       
        //监听提交
        form.on('submit(demo1)', function(data){
            console.log(data);
            $.post(adminurl,data.field,function( json ){
                console.log(json);
                if( json == 'go' ){
                    layer.msg('增加成功');
                    //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('增加失败', function(){
                    });
                }
            });
            return false;
        });
    });

</script>

</body>
</html>