<?php
    //include "../fun/eby_admin_api.php";
    //include "../fun/phpfile.php";
    //
    //$sql = "select * from e_goods_sylte where adduid=176 ";
    //$arr = fetchAll( $sql );

    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    $uid = $_SESSION['uid'];
    $username = trim($_GET['username']);
    $look_uid = trim($_GET['look_uid']);
    $cuid =  trim($_GET['cuid']);
    if( $uid == 1 ){
        $sql = "select a.*,(select count(b.id) from e_mac_code b where b.uid=a.uid) as macnum from e_members a ";
        if( $username || $look_uid || $cuid ){
            if( $cuid ){ $sql.= " where cuid='{$cuid}' "; }else{ $sql.= " where  a.cuid >= 1 "; }
            if( $username ){ $sql.= " and username  like '%$username%' "; }
            if( $look_uid ){ $sql.= " and  uid='{$look_uid}' "; }
        }
    }else{
        $sql = "select a.*,(select count(b.id) from e_mac_code b where b.uid=a.uid) as macnum from e_members a where a.cuid=".$uid;
        if( $username || $look_uid ){
            $sql.= " and username  like '%$username%' and uid='%$look_uid%' ";
        }
    }

    $sql.= " order by a.uid desc";
    $page_get.="a=".$a."&username=".$username."&look_uid=".$look_uid."&cuid=".$cuid;
    pages($sql,$s,$page_get,12);//数据分页 每页20条

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
        .layui-table .tr_hover:hover{
            background:#ABB0C1;
        }
        .frist_page{
            display:inline-block;
            height:30px;
            line-height:30px;
            width:45px;
            text-align:center;
            background:#009688;
            color:#ffffff;
            border-radius:3px;
        }

        .up_page{

            display:inline-block;
            height:30px;
            line-height:30px;
            width:45px;
            text-align:center;
            background:#009688;
            color:#ffffff;
            border-radius:3px;
        }
        .next_page{

            display:inline-block;
            height:30px;
            line-height:30px;
            width:45px;
            text-align:center;
            background:#009688;
            color:#ffffff;
            border-radius:3px;
        }

        .end_page{

            display:inline-block;
            height:30px;
            line-height:30px;
            width:45px;
            text-align:center;
            background:#009688;
            color:#ffffff;
            border-radius:3px;
            margin-right:15px;
        }
        .end_page:hover{
            color:#ffffff;
        }
        .next_page:hover{
            color:#ffffff;
        }
        .up_page:hover{
            color:#ffffff;
        }
        .frist_page:hover{
            color:#ffffff;
        }

        #this_page{
            display:inline-block;
            height:30px;
            line-height:30px;
            width:30px;
            text-align:center;
            background:#009688;
            color:#ffffff;
            border-radius:3px;
        }
        body{
            min-width: 850px;
            overflow: auto;
        }
    </style>

</head>
<body>
<fieldset class="layui-elem-field layui-field-title " style="margin: 20px 20px 0px 20px;">
<!--    <legend><b>设备管理员</b></legend>-->
<!---->
<!---->
<!--    <table class="layui-table" lay-skin="line">-->
<!--        <form  action=''>-->
<!--            <tr  style=' background:#ffffff;'>-->
<!--                <td style='border:none;' >-->
<!--                    --><?php
//                        if( $uid == 1 || $uid == 4 ){
//                            echo "<a  id='openpage' onclick='openpage()'  class='layui-btn' ><i class='layui-icon'></i> 添加管理员</a>";
//                        }
//
//                    ?>
<!--                </td>-->
<!--                <td style='text-align:center;border:none;' colspan="9">-->
<!--                    <input type="text" value="--><?php //echo $look_uid ?><!--" name="look_uid"  placeholder="请输入管理ID" style="width:200px;height:23px;padding:5px;margin-right: 5px; ">-->
<!--                    <input type="text" value="--><?php //echo $username ?><!--" name="username"  placeholder="请输入帐号名" style="width:200px;height:23px;padding:5px;margin-right: 5px;">-->
<!--                    --><?php
//                        if( $uid == 1 ){
//                            ?>
<!--                            <input type="text" value="--><?php //echo $cuid?><!--" name="cuid"  placeholder="请输入上级ID" style="width:200px;height:23px;padding:5px;margin-right: 5px;">-->
<!--                            --><?php
//                        }
//                    ?>
<!--                    <button type='submit' onclick="show()" class="layui-btn">提交查询</button><a href='./admin_list.php' onclick="show()" class="layui-btn"> 返 回 </a></td>-->
<!--            </tr>-->
<!--        </form>-->
<!--        <tr align="center" style=' background:#51545F;height:50px;color:#ffffff;'>-->
<!--            <td><b>管理ID</b></td>-->
<!--            <td><b>帐号</b></td>-->
<!--            <td><b>密码</b></td>-->
<!--            <td><b>备注</b></td>-->
<!--            <td><b>设备数量</b></td>-->
<!--            <td><b>开通时间</b></td>-->
<!--            <td><b>上级ID</b></td>-->
<!--            <td><b>管理路径</b></td>-->
<!--            <td><b>菜单类型</b></td>-->
<!--            <td width="350"><b>操作</b></td>-->
<!--        </tr>-->
<!--        --><?php
//
//            while($rs=mysql_fetch_array($results_date))
//            {
//
//                ?>
<!--                <tr align="center"  class="tr_hover">-->
<!--                    <td> --><?//=$rs['uid']?><!--</td>-->
<!--                    <td> --><?//=$rs['username']?><!--</td>-->
<!--                    <td>******</td>-->
<!--                    <td> --><?//=$rs['user_bz']?><!--</td>-->
<!--                    <td> --><?//=$rs['macnum']?><!-- 台</td>-->
<!--                    <td> --><?php //echo date('Y-m-d H:i:s',$rs['regdate'])?><!-- </td>-->
<!--                    <td>--><?//=$rs['cuid']?><!--</td>-->
<!--                    <td>-->
<!--                        --><?php
//                            if(  $rs['domain'] ){
//                                // echo "select username from e_members where uid in (".$domain."0)";
//                                $arr = fetchAll("select username from e_members where uid in (".$rs['domain']."0)");
//                                for($i=0;$i<count($arr);$i++)
//                                {
//                                    if($i>0) echo ' < ';
//                                    echo   "<span style='color:#1AA094;'>".$arr[$i]['username']."</span>";
//                                }
//                            }
//                        ?>
<!--                    </td>-->
<!--                    <td> --><?php //echo $rs['auth_type'];?><!--</td>-->
<!--                    <td width="350">-->
<!--                        --><?php
//                            if( $uid == 1 || $uid == 4 ){
//                                echo '<button onclick="openpage2('.$rs['uid'].')" class="layui-btn" title="编辑"><i class="layui-icon">&#xe642;</i></button>';
//                            }
//                            if( $uid == 1 ){
//                                echo '
//            <a class="layui-btn"  onclick="show()"" href="marketing_list.php?uid='.$rs['uid'].'">营销</a>
//            <a class="layui-btn"  onclick="show()"" href="store_promotion.php?uid='.$rs['uid'].'">店面促销</a>';
//                            }
//                        ?>
<!--                        <a class="layui-btn"  onclick="openpage1( --><?//=$rs['uid']?>// )" >倍率</a></td>
//                    </td>
//                </tr>
//
//                <?php
//
//            }
//        ?>
<!--        <tr align='center' style=' background:#ffffff;'>-->
<!--            <td colspan="10">-->
<!---->
<!--            </td>-->
<!--        </tr>-->
<!---->
<!--    </table>-->

</fieldset>
<div id="demo3"></div>
<script src="../layui/layui.js" charset="utf-8"></script>
<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layer/layer.js"></script>
<script src="../layui/layer/extend/layer.ext.js"></script>

<script>
    layui.use(['laypage', 'layer'], function(){
        var laypage = layui.laypage
            ,layer = layui.layer;
        //自定义首页、尾页、上一页、下一页文本
        laypage.render({
            elem: '#demo3'
            ,count: 100
            ,first: '首页'
            ,last: '尾页'
            ,prev: '<em>←</em>'
            ,next: '<em>→</em>'
        });

    });
</script>
<script>

    function  show(){
        var index = layer.load(0, {shade: false});
    }

    //打开增加页面的弹出层
    function  openpage(){
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '添加管理员',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1050px', '800px'],
                content: 'add_admin.php'
            });
        });
    }

    //打开折扣页面的弹出层
    function  openpage1( look_uid ){
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '折扣',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1000px', '800px'],
                content: 'system_rate.php?look_uid='+look_uid
            });
        });
    }


    //打开编辑页面的弹出层
    function  openpage2( id ){
        layer.config({
            extend: 'extend/layer.ext.js'
        });
        //页面一打开就执行，放入ready是为了layer所需配件（css、扩展模块）加载完毕
        layer.ready(function() {
            var index = layer.open({
                type: 2,
                skin: 'layui-layer-molv',
                title: '编辑管理员',
                fix: false,
                shadeClose: true,
                maxmin: true,
                area: ['1050px', '800px'],
                content: 'edit_admin.php?uid='+id
            });
        });
    }

</script>

</body>
</html>