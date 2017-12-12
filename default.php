<?php
include "./fun/eby_admin_api.php";
include "./fun/phpfile.php";
$uid = $_SESSION['uid'];
$row = fetchOne("select * from e_members where uid=" . $uid);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>定制系统</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" href="./images/title.png">
    <link rel="stylesheet" href="./layui/css/layui.css?t=1479413779832" media="all">
    <link rel="stylesheet" href="./layui/css/global.css?t=1479413779832" media="all">
    <script src="./layui/jquery.min.js" charset="utf-8"></script>
    <script src="./layui/layui.js" charset="utf-8"></script>

</head>

<body>
<div class="layui-layout layui-layout-admin">
    <div class="layui-header header header-demo">
        <div class="layui-main">

            <ul class="layui-nav">
                <li class="layui-nav-item ">
                    <a href="javascript:void(0);"></a>
                </li>
                <li class="layui-nav-item layui-this">
                    <a href="javascript:void(0);"></a>
                </li>
            </ul>
        </div>
    </div>
    <div class="layui-side layui-bg-black">
        <!-- admin_nav -->
        <div class="layui-side-scroll ">

            <ul class="layui-nav layui-nav-tree">
                <!-- 设备显示 -->
                <li class="layui-nav-item layui-nav-itemed auth_hid5 zocai">
                    <a href="javascript:void(0);">基础设置</a>
                    <dl class="layui-nav-child">
                        <dd class="sys_set"><a class="href" src="./tpl/sys/set.php" href="javascript:void(0);">系统配置</a>
                        </dd>
                        <?php
                        if ($row['cuid'] != 4) {
                            echo '<dd><a class="href " src="./inc/system_rate.php"  href="javascript:void(0);">系统倍率</a></dd>';
                        }
                        echo "<dd><a  class='href' src='./inc/admin_list.php' href='javascript:void(0);'>管理成员</a></dd>";
                        if ($uid == 1) {
                            echo "<dd><a  class=\"href\" src=\"./inc/admin_notice.php\"  href=\"javascript:void(0);\">系统公告</a></dd>
                                  <dd><a  class=\"href\" src=\"./inc/notice_log.php\"  href=\"javascript:void(0);\">公告日志</a></dd>";
                        }
                        ?>
                    </dl>
                </li>
                <li class="layui-nav-item auth_hid5 zocai"><a class="href" src="./inc/goods_category.php" href="javascript:void(0);">款式分类</a></li>
                <li class="layui-nav-item  zocai">
                    <a href="javascript:;">款式</a>
                    <dl class="layui-nav-child">
                        <dd>
                            <!-- 主管理员uid=1能看见所有会员的款式，会员只能看自己的款式 -->
                            <?php
                            if ($uid == 1) {
                                echo "<a class='href' src='./inc/style_list_admin.php'  href='javascript:void(0);'>本地款式</a>";
                            } else {
                                echo "<a class='href' src='./inc/style_list_user.php' href='javascript:void(0);'>系统款式</a>";
                            }
                            ?>
                        </dd>
                        <?php
                        if ($row['auth_type'] == 5) {
                            echo "<dd><a class='href' src='./inc/style_list_boss.php'  href='javascript:void(0);'>上级款式</a></dd>";
                        }
                        ?>
                        <dd>
                            <!-- 主管理员uid=1能看见所有会员的款式，会员只能看自己的款式 -->
                            <?php
                            if ($uid == 1) {
                                echo "<a class='href' src='./inc/style_list_member.php'  href='javascript:void(0);'>会员款式</a>";
                            } else {
                                echo "<a class='href' src='./inc/style_list.php'  href='javascript:void(0);'>我的款式</a>";
                            }
                            ?>
                        </dd>
                        <?php
                        if ($row['auth_type'] != 5) {
                            echo "<dd ><a class=\"href\" src=\"./inc/qdz_list.php\" href=\"javascript:void(0);\">轻定制款式</a></dd>";
                        }
                        ?>
                        <?php
                        if ($uid == 1) {
                            echo '<dd><a  class="href" src="./inc/special_list.php" href="javascript:void(0);">我的专题</a></dd>
      		                <dd><a  class="href" src="./inc/special_list_member.php" href="javascript:void(0);">会员专题</a></dd>';
                        } else {
                            echo '<dd  class="hid"><a  class="href" src="./inc/special_list_admin.php" href="javascript:void(0);">系统专题</a></dd>
      		                <dd  class="hid"><a  class="href" src="./inc/special_list.php" href="javascript:void(0);">我的专题</a></dd> ';
                        }
                        ?>
                    </dl>
                </li>
                <!-- 设备显示 -->
                <li class="layui-nav-item hid zocai">
                    <a href="javascript:;">设备</a>
                    <dl class="layui-nav-child">
                        <dd><a class="href" src="./inc/box_list.php" href="javascript:void(0);">设备列表</a></dd>
                        <dd><a class="href" src="./inc/orders_list.php" href="javascript:void(0);">设备订单</a></dd>

                        <?php
                        if ($uid == 1) {
                            echo "<dd><a class='href' src='./inc/marketing_list.php'  href='javascript:void(0);'>营销配置</a></dd>
                              <dd><a class='href' src='./inc/store_promotion.php'  href='javascript:void(0);'>店面促销</a></dd>
                              <dd><a  class='href' src='./inc/jewelry_college.php'  href='javascript:void(0);'>培训课程</a></dd>
                              <dd><a  class=\"href\" src=\"./inc/software_version.php\"  href=\"javascript:void(0);\">软件版本</a></dd>
                            ";
                        }
                        ?>
                    </dl>
                </li>

                <!-- 设备显示 暂时没用到-->
                <!-- <li class="layui-nav-item hid">
                  <a href="javascript:void(0);">库存</a>
                  <dl class="layui-nav-child">
                    <dd><a href="javascript:void(0);">裸石库存</a></dd>
                    <dd><a href="javascript:void(0);">彩钻库存</a></dd>
                    <dd><a class="href" src="./inc/gems_admin.php" href="#">彩宝库存</a></dd>
                  </dl>
                </li> -->

                <li class="layui-nav-item  auth_hid zocai">
                    <a href="javascript:void(0);">WebAPP</a>
                    <dl class="layui-nav-child">
                        <dd><a class="href" src="./inc/mebers_group.php" href="javascript:void(0);">会员组</a></dd>
                        <dd><a class="href" src="./inc/fx_member.php" href="#">会员</a></dd>
                        <dd><a class="href" src="./inc/fx_member_order.php" href="#">订单</a></dd>
                        <dd><a class="href" src="./inc/app_update.php" href="javascript:void(0);">配置</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item  _auth_hid zocai" style="display: none;">
                    <a href="javascript:void(0);">微信活动</a>
                    <dl class="layui-nav-child">
                        <dd>
                            <a class="href" src="./inc/bargain_list.php" href="javascript:void(0);">砍价活动</a>
                        </dd>
                        <dd>
                            <a class="href" src="./inc/bargain_list_user.php" href="javascript:void(0);">用户的活动</a>
                        </dd>
                        <dd>
                            <a class="href" src="./inc/bargain_template.php" href="javascript:void(0);">砍价活动模板</a>
                        </dd>
                        <dd>
                <li class="layui-nav-item"><a class="href" src="./inc/bargain_admin_addurl.php"
                                              href="javascript:void(0);">分享注册</a></li>
                </dd>

                </dl>
                </li>
                <?php

                if ($row['auth_type'] == 3 || $row['auth_type'] == 1 || $uid == 1) {
                    echo '<dd><li class="layui-nav-item"><a  class="href" src="./inc/gold_income.php?webid=' . $uid . '" href="javascript:void(0);" >金生钱</a></li></dd>
                     ';
                }
                ?>
                <!--佐卡伊培训课程-->
                <li class="layui-nav-item zocai_show" style="display: none">
                    <dd><a  class='href' src='./inc/admin_list.php' href='javascript:void(0);'>管理成员</a></dd>
                    <dd><a  class='href' src='./inc/jewelry_college.php'  href='javascript:void(0);'>培训课程</a></dd>
                </li>
                <!--佐卡伊培训课程-->
                <!-- <dd><li class="layui-nav-item"><a  class="href" src="./inc/add_admin1.php" href="javascript:void(0);" >测试中</a></li></dd> -->
                <li class="layui-nav-item"><a href="./inc/login_out.php">注销管理</a></li>
            </ul>
            <script>
                layui.use(['element', 'layer'], function () {
                    var element = layui.element();
                });

                $(function () {
                    $('.href').click(function () {
                        var url = $(this).attr('src');
                        $('#site-demo-page').attr('src', url);
                        var index = layer.load(0, {shade: false});
                        //加载成功后，关闭加载动画
                        if ($('#site-demo-page').attr('src') == url) {
                            setTimeout(function () {
                                layer.close(index);
                            }, 1000);
                        }
                    });

                    var hid_uid = "<?php  echo $row['auth_type'] ?>";
                    var _uid = "<?php  echo $uid ?>";
                    //只买APP
                    if (hid_uid == 2) {
                        $(".hid").css("display", "none");
                    }
                    //只买设备的
                    if (hid_uid == 1 || hid_uid == 4) {
                        $(".auth_hid").css("display", "none");
                    }
                    if (hid_uid == 5) {
                        $(".auth_hid").css("display", "none");
                        $(".auth_hid5").css("display", "none");
                        $(".hid").css("display", "none");
                    }

                    if (_uid == 1 || _uid == 4) {
                        $("._auth_hid").css("display", "");
                    }
                    // 佐卡伊 培训账号
                    if (_uid == 198) {
                        $(".zocai").css("display", "none");
                        $(".zocai_show").css("display", "");
                    }
                });
            </script>
        </div>
    </div>
    <div class="layui-body site-demo" style="overflow-y:hidden;">
        <?php

        if ($row['auth_type'] == 2) {
            echo '<iframe  src="./inc/goods_category.php"   id="site-demo-page" name="site-demo-page" scrolling="auto" frameborder="0" style="border:none; width:100%; height:100%;"></iframe>';
        } else {
            echo '<iframe  src="./tpl/sys/set.php"   id="site-demo-page" name="site-demo-page" scrolling="auto" frameborder="0" style="border:none; width:100%; height:100%;"></iframe>';
        }

        ?>


    </div>
</div>

<script src="./layui/global.js" charset="utf-8"></script>

</body>
</html>