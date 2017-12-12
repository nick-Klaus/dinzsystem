<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    $c_uid = $_SESSION['uid'];
    //找出分类的数据
    $area = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid='1'");
    $area = isset($area)?$area:array();
    //接收需要编辑数据的id号
    $editid = $_GET['editid'];
    $cuid = $_GET['cuid']? $_GET['cuid'] : 0;
    $rs = fetchOne("select * from e_unified_sylte_new  where id='$editid'");
    $json = json_decode($rs['thumb_url'],true);
    $json = empty($json)?array():$json;
    if( $cuid ){
        $cuid = $cuid;
    }else{
        $cuid = $rs['adduid'];
    }
    if( $rs['best64'] == 1 ){
        $img_url = 'http://imageserver.echao.com/imagespath/';
    }else{
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
    <link rel="stylesheet" href="../layui/css/layui.css"  media="all">
    <style>
        body{
            padding:10px;
        }

    </style>
</head>
<body>

<fieldset class="layui-elem-field layui-field-title" style="margin: 20px;">
    <legend><b>款式编辑</b></legend>
</fieldset>
<form class="layui-form" action="">
    <input type='hidden' name='id' value="<?php  echo $rs['id']?>">
    <input type='hidden' name='uid' value="<?php  echo $cuid?>">
    <table class="layui-table" >
        <tr>
            <td width="148" style="text-align:right;">分类:</td>
            <td colspan="3">
                <div class="layui-input-inline" style='height:40px;'>

                    <select name="cls1"  id='bigname'  lay-filter="top">
                        <option value="">请选择顶级分类</option>
                        <?php
                            $row = fetchOne("select uid,categorytype from e_members  where  uid='$c_uid'");

                            if( $row['categorytype'] == 0 ){
                                $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid='1'");
                            }elseif( $row['categorytype'] == 1 ){
                                $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid in(1,$c_uid) ");
                            }else{
                                $arr1 = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  pid=0 and adduid='$c_uid)'");
                            }

                            foreach ($arr1 as $v) {
                                ?>
                                <option value="<?php echo $v['id'] ?>"  <?php  if( $v['id'] ==  $rs['cls1']){ echo 'selected'; } ?>  ><?php echo $v['catename']; ?></option>
                                <?php
                            }
                        ?>
                    </select>　
                </div>
                <div class="layui-input-inline"  >
                    <select name="cls2" id="smallname">
                        <option value="">请选择子级分类</option>
                        <?php
                            //无限级分类
                            $mid_sql = "select id,pid,catename from e_goods_category where  pid=".$rs['cls1'];
                            $tree    = fetchAll($mid_sql);
                            foreach ($tree as $v) {
                                ?>
                                <option value="<?php echo $v['id'] ?>" <?php  if( $v['id'] ==  $rs['cls2']){ echo 'selected'; } ?>><?php echo $v['catename']; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
            </td>
        </tr>

        <tr>

            <td align="right">品名:</td>
            <td width="300" >
                <input name="style_name" type="text" id="style_name"   value="<?=$rs['style_name']?>" lay-verify="title" autocomplete="off" placeholder="请输入品名" class="layui-input" style='width:200px;' >
            </td>

            <td align="right">款号:</td>
            <td>
                <input name="style_no" type="text" id="style_no"   value="<?=$rs['style_no']?>" lay-verify="title" autocomplete="off" placeholder="请输入款号" class="layui-input" style='width:200px;'>
            </td>
        </tr>

        <tr>

            <td align="right">银版:</td>
            <td width="300" >
                <input type="radio" value="1" name="style_sort" id="style_sort" title="有" <?php  if( $rs['style_sort'] == 1 ){ echo "checked='checked'";  } ?> />
                <input type="radio" value="0" name="style_sort" id="style_sort" title="无"  <?php  if( $rs['style_sort'] == 0 ){ echo "checked='checked'";  } ?> /> </td>

            <td align="right">新款推荐:</td>
            <td><input type="radio" value="1" name="style_new" id="style_new" title="是"  <?php  if( $rs['style_new'] == 1 ){ echo "checked='checked'";  } ?> />
                <input type="radio" value="0" name="style_new" id="style_new" title="否"  <?php  if( $rs['style_new'] == 0 ){ echo "checked='checked'";  } ?> /> </td>
        </tr>

        <tr>

            <td align="right">畅销推荐:</td>
            <td width="200">
                <input type="radio" value="1" name="style_hot" id="style_hot"  title="是" <?php  if( $rs['style_hot'] == 1 ){ echo "checked='checked'";  } ?> />
                <input type="radio" value="0" name="style_hot" id="style_hot" title="否"  <?php  if( $rs['style_hot'] == 0 ){ echo "checked='checked'";  } ?>/>


            </td>

            <td align="right">款式价格:</td>
            <td><input name="MinPrice" type="text" id="MinPrice"  value="<?=$rs['MinPrice']?>" size="10" lay-verify="title" autocomplete="off" placeholder="最低价格" class="layui-input" style='width:150px;float:left'>
                <input name="MaxPrice" type="text" id="MaxPrice"  value="<?=$rs['MaxPrice']?>" size="10" lay-verify="title" autocomplete="off" placeholder="最高价格" class="layui-input" style='width:150px;float:left;margin-left:20px;'></td>
        </tr>
        <tr>

            <td align="right">定制:</td>
            <td width="200" >
                <input type="radio" value="0" name="style_mode" id="style_mode"  title="现货"  <?php  if( $rs['style_mode'] == 0 ){ echo "checked='checked'";  } ?> />
                <input type="radio" value="1" name="style_mode" id="style_mode" title="定制" <?php  if( $rs['style_mode'] == 1 ){ echo "checked='checked'";  } ?> /> <br/>
                <input type="radio" value="2" name="style_mode" id="style_mode"  title="对戒"  <?php  if( $rs['style_mode'] == 2 ){ echo "checked='checked'";  } ?> />
                <input type="radio" value="3" name="style_mode" id="style_mode" title="其它" <?php  if( $rs['style_mode'] == 3 ){ echo "checked='checked'";  } ?> />
            </td>

            <td align="right">空托价格:</td>
            <td>

                <table class="am-table" style="border:0;width:300px;margin:0">
                    <tr>
                        <td>18K</td>
                        <td><input name="price_18K" type="text" id="price_18K"   size="10" lay-verify="title" autocomplete="off" placeholder="请输入18K" class="layui-input" style='width:200px;' value="<?php  echo $rs['price_18K'] ?>" > </td>
                        <td>PT950</td>
                        <td><input name="price_pt" type="text"  id="price_pt"    size="10" lay-verify="title" autocomplete="off" placeholder="请输入8K" class="layui-input" style='width:200px;' value="<?php  echo $rs['price_pt'] ?>" ></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="right">缩略图:</td>
            <td>  <div >
                    <img  id='imgurl' src="<?php  echo $img_url.$rs['style_thumb'] ?>"  style='height:65px;width:65px;border:1px solid #ccc;float:left;'>
                </div>
                <input type="hidden" name="style_thumb" id="style_thumb" value="<?=$rs['style_thumb']?>"  lay-verify="title" autocomplete="off" placeholder="请输点击加入图片" class="layui-input" style='width:200px;margin:30px 0px 0px 20px;' >
                <button type="button" id="style_thumb_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>点击选图</button>
            </td>

            <td align="right">视频实拍:</td>
            <td>  <div class="picbox_2 p_style_video">
                    <video id="sampleMovie" src="http://imageserver.echao.com/imagespath/<?php  echo $rs['style_video'] ?>" style='height:65px;width:65px;border:1px solid #ccc;float:left;' ></video>
                </div>
                <input type="hidden" name="style_video" id="style_video" value="<?=$rs['style_video']?>"  onClick="open_pic_box('style_video')"  lay-verify="title" autocomplete="off" placeholder="点击添加视频" class="layui-input" style='width:200px;margin:30px 0px 0px 20px;' >
                <button type="button" id="style_video_cl" class="layui-btn layui-btn-radius" style='margin-top:30px;'>点击选视频</button>
            </td>
        </tr>

        <tr>
            <td  align="right">库存:</td>
            <td >
                <div style='height:30px;line-height:30px;'>
                    <input name="stocks" type="text" id="stocks"   value="<?php echo $rs['stocks'] ?>" size="10" lay-verify="title" autocomplete="off" placeholder="请输入库存数量" class="layui-input" style='width:200px;float:left' disabled='disabled' >
                    件</div></td>

            <td align="right">供应商:</td>
            <td><input name="factory" type="text" id="factory"   value="<?=$rs['factory']?>" lay-verify="title" autocomplete="off" placeholder="请输入供应商" class="layui-input" style='width:200px;' ></td>
        </tr>
        <tr>
            <td align="right">供应商款号:</td>
            <td><input name="factory_no" type="text" id="factory_no"   value="<?=$rs['factory_no']?>" lay-verify="title" autocomplete="off" placeholder="请输入供应商款号" class="layui-input" style='width:200px;' ></td>

            <td align="right">品牌:</td>
            <td><input name="style_brand" type="text" id="style_brand"   value="<?=$rs['style_brand']?>" lay-verify="title" autocomplete="off" placeholder="请输入款号或款名" class="layui-input" style='width:200px;' ></td>
        </tr>
        <tr><td align="right">图库：<br></td>
            <td colspan="3">
                <div id="thumb_urlshow_pic"></div>
                <input type="hidden" name="thumb_url" id="thumb_url" value="<?php  echo implode(",",$json); ?>"  lay-verify="title" autocomplete="off" placeholder="请输点击加入图片" class="layui-input"  >
                <button type="button" id="thumb_url_cl" class="layui-btn layui-btn-radius" >点击选图（上传多张图片可重复点击）</button>
                <div id='pageall'>
                    <?php

                        $arr=json_decode($rs['thumb_url'],true);
                        $arr = empty($arr)?array():$arr;
                        foreach ($arr as $key => $value) {
                            echo "<div class='divs' style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src=".$img_url.$value." style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>" ;
                        }
                    ?>
                </div>
            </td>
        </tr>

        <tr class='hid'>

            <td align="right">工费:</td>
            <td><input name="worksprice" type="text" id="worksprice"   value="<?=$rs['worksprice']?>" lay-verify="title" autocomplete="off" placeholder="请输入工费" class="layui-input" style='width:200px;' > </td>


            <td align="right">材质:</td>
            <td>

                <input type="checkbox" name="material[18K金]" value="18K金" title="18K金" <?php if( in_array('18K金', explode(',', $rs['material'])) ){ echo "checked='checked'"; } ?> >
                <input type="checkbox" name="material[18K白]" value="18K白" title="18K白" <?php if( in_array('18K白', explode(',', $rs['material'])) ){ echo "checked='checked'"; } ?> >
                <input type="checkbox" name="material[18K红]" value="18K红" title="18K红" <?php if( in_array('18K红', explode(',', $rs['material'])) ){ echo "checked='checked'"; } ?> >
                <input type="checkbox" name="material[18K黄]" value="18K黄" title="18K黄" <?php if( in_array('18K黄', explode(',', $rs['material'])) ){ echo "checked='checked'"; } ?> >
                <input type="checkbox" name="material[PT950]" value="PT950" title="PT950" <?php if( in_array('PT950', explode(',', $rs['material'])) ){ echo "checked='checked'"; } ?> >

            </td>
        </tr>
        <tr class='hid' >

            <td align="right">尺寸:</td>
            <td><input name="GoodsSize" type="text" id="GoodsSize"   value="<?=$rs['GoodsSize']?>" lay-verify="title" autocomplete="off" placeholder="请输入尺寸" class="layui-input" style='width:200px;' > </td>


            <td align="right">金重:</td>
            <td>
                <table class="am-table" style="border:0;width:400px;margin:0">
                    <tr>
                        <td ><div style='width:60px'>18K金重</div></td>
                        <td><div style='width:200px;height:40px;line-height:40px;' ><input name="goldWeight_18K" type="text" id="goldWeight_18K" value="<?=$rs['goldWeight_18K']?>" size="5" lay-verify="title" autocomplete="off" placeholder="请输入18K金重" class="layui-input" style='width:120px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（g/克）</span></div></td>
                        <td><div style='width:80px'>PT950金重</div></td>
                        <td>
                            <div style='width:200px;height:40px;line-height:40px;' ><input name="goldWeight_pt950" type="text" id="goldWeight_pt950" value="<?=$rs['goldWeight_pt950']?>" size="5" lay-verify="title" autocomplete="off" placeholder="请输入PT950金重" class="layui-input" style='width:120px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（g/克）</span></div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr class='hid'>

            <td align="right">主石形状:</td>
            <td>
                <div class="layui-input-inline"  >
                    <select name="StoneType" >
                        <option value="1" <?php if( $rs['StoneType'] == 1 ){ echo "selected='selected'"; } ?> > 圆形 </option>
                        <option value="2" <?php if( $rs['StoneType'] == 2 ){ echo "selected='selected'"; } ?> > 梨形 </option>
                        <option value="3" <?php if( $rs['StoneType'] == 3 ){ echo "selected='selected'"; } ?> > 心形 </option>
                        <option value="4" <?php if( $rs['StoneType'] == 4 ){ echo "selected='selected'"; } ?> > 椭圆形 </option>
                        <option value="5" <?php if( $rs['StoneType'] == 5 ){ echo "selected='selected'"; } ?> > 橄榄形 </option>
                        <option value="6" <?php if( $rs['StoneType'] == 6 ){ echo "selected='selected'"; } ?> > 枕形 </option>
                        <option value="7" <?php if( $rs['StoneType'] == 7 ){ echo "selected='selected'"; } ?> > 祖母绿形 </option>
                        <option value="8" <?php if( $rs['StoneType'] == 8 ){ echo "selected='selected'"; } ?> > 三角形 </option>
                        <option value="9" <?php if( $rs['StoneType'] == 9 ){ echo "selected='selected'"; } ?> > 公主方形 </option>
                        <option value="10" <?php if( $rs['StoneType'] == 10 ){ echo "selected='selected'"; } ?> > 雷蒂恩形 </option>
                    </select>
                </div>
                <!-- <input name="StoneType" type="text" id="StoneType"   value="<?=$rs['StoneType']?>" required lay-verify="title" autocomplete="off" placeholder="请输入主石类型" class="layui-input" style='width:200px;'  >  -->
            </td>


            <td align="right" style="color:">主石价格:</td>
            <td><input name="StonePrice" type="text" id="StonePrice"   value="<?=$rs['StonePrice']?>" lay-verify="title" autocomplete="off" placeholder="请输入主石价格" class="layui-input" style='width:200px;' > </td>
        </tr>


        <tr>

            <td align="right">主石类型:</td>
            <td><input name="StoneShape" type="text" value="<?=$rs['StoneShape']?>"  lay-verify="title" autocomplete="off" placeholder="请输入主石类型" class="layui-input" style='width:200px;' > </td>
            <td align="right" width='100'>主石数量:</td>
            <td>
                <div style='width:400px;height:40px;line-height:40px;' ><input name="StoneNum" type="text" value="<?=$rs['StoneNum']?>"  size="5" lay-verify="title" autocomplete="off" placeholder="请输入主石数量" class="layui-input" style='width:200px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>颗</span></div>

            </td>
        </tr>

        <tr class='hid'>
            <td align="right">主石描述:</td>
            <td><input name="StoneTxt" type="text" id="StoneTxt" value="<?=$rs['StoneTxt']?>" lay-verify="title" autocomplete="off" placeholder="请输入主石描述" class="layui-input" style='width:200px;' > </td>


            <td align="right" width='100' >主石/镶口:</td>
            <td>
                <div style='width:400px;height:40px;line-height:40px;' ><input name="S_Weight" type="text" id="MinStoneWeight" value="<?=$rs['S_Weight']?>" size="5" lay-verify="title" autocomplete="off" placeholder="请输入主石/镶口" class="layui-input" style='width:200px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div>
                <span style="font-size:10px;color:#33AB9F">多个镶口用","隔开,例如 0.3,0.5,1</span>
            </td>
        </tr>

        <tr class='hid'>

            <td align="right" style="color:">主石颜色:</td>
            <td><input name="Color" type="text" id="Color"   value="<?=$rs['Color']?>" lay-verify="title" autocomplete="off" placeholder="请输入主石颜色" class="layui-input" style='width:200px;' > </td>


            <td align="right" style="color:">主石净度:</td>
            <td><input name="Clarity" type="text" id="Clarity"   value="<?=$rs['Clarity']?>" lay-verify="title" autocomplete="off" placeholder="请输入主石净度" class="layui-input" style='width:200px;' > </td>
        </tr>
        <tr class='hid'>
            <td align="right">副石数量:</td>
            <td ><input name="DeStoneNum" type="text" id="DeStoneNum"   value="<?=$rs['DeStoneNum']?>" lay-verify="title" autocomplete="off" placeholder="请输入副石数量" class="layui-input" style='width:200px;' ></td>


            <td align="right">副石重量:</td>
            <td><!-- <input name="MinDeStoneWeight" type="text" id="MinDeStoneWeight"   value="<?=$rs['MinDeStoneWeight']?>" size="10" lay-verify="title" autocomplete="off" placeholder="请输入副石重量" class="layui-input" style='width:200px;' >   -->
                <!-- <input name="MaxDeStoneWeight"  type="hidden" id="MaxDeStoneWeight"   value="<?=$rs['MaxDeStoneWeight']?>" size="10" lay-verify="title" autocomplete="off" placeholder="请输入款号或款名" class="layui-input" style='width:200px;' > -->
                <div style='width:400px;height:40px;line-height:40px;' ><input name="MinDeStoneWeight" type="text" id="MinDeStoneWeight" value="<?=$rs['MinDeStoneWeight']?>" size="5" lay-verify="title" autocomplete="off" placeholder="请输入副石重量" class="layui-input" style='width:200px;float:left;' > <span style='color:#019F95;font-size:12px;margin-left:5px;'>（ct/克拉）</span></div>
            </td>
        </tr>
        <tr><td align="right">关键字:</td>
            <td colspan="3"> <!-- <textarea class="doc_ta" rows="5"  id="content" style="width:100%" ><?=$rs['content']?> -->
                <input type="text" name="keyword" lay-verify="title" autocomplete="off" value="<?php echo $rs['keyword'] ?>" placeholder="请输入关键字" class="layui-input">
            </td>
        </tr>

        <tr><td align="right">描述:</td>
            <td colspan="3"> <!-- <textarea class="doc_ta" rows="5"  id="content" style="width:100%" ><?=$rs['content']?> -->
                <textarea placeholder="请输入描述内容" class="layui-textarea" name="content" ><?php echo $rs['content'] ?></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="4" align="center">
                <button class="layui-btn" lay-submit="" lay-filter="demo1" >　提交　</button>
            </td>
        </tr>
    </table>

</form>

<script src="../layui/jquery.min.js" charset="utf-8"></script>
<script src="../layui/layui.js" charset="utf-8"></script>
<script>
    var inputObj = document.getElementById('thumb_url');
    var mycars = inputObj.value.split(",");//表单内原有的图片地址变为数组
    var parentObj = document.getElementById('pageall');
    var chil1 = parentObj.getElementsByTagName("div");
    function delpage(){
        for (var i = 0; i < chil1.length; i++) {
            chil1[i].index = i;
            chil1[i].onclick=function(){
                var j = this.index;
                parentObj.removeChild(chil1[j]);//清除点击当前的图片
                mycars.splice(j,1);//清除图片地址在数组中的位置
                inputObj.value=mycars.join(",");//从新把数组符给表单
            };
        }
    }
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form()
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
        var adminurl="./editpro_style_yb.php";
        //创建一个编辑器
        var editIndex = layedit.build('LAY_demo_editor');
        //点击出现弹出层
        $('#style_thumb_cl').on('click',function(){
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function(src){
                var img=document.getElementById('imgurl');
                var input=document.getElementById('style_thumb');
                img.src='http://imageserver.echao.com/uploadfile/'+src;
                input.value = "/uploadfile/"+src;
                layer.close(index);
            }
        });
        //点击出现弹出层
        $('#style_video_cl').on('click',function(){
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function(src){
                var img=document.getElementById('sampleMovie');
                var input=document.getElementById('style_video');
                img.src='http://imageserver.echao.com/uploadfile/'+src;
                input.value = "/uploadfile/"+src;
                layer.close(index);
            }
        });
        //点击添加多张图片
        $('#thumb_url_cl').on('click',function(){
            var index = layer.open({
                type: 2,
                title: '我的图片库',
                shadeClose: true,
                shade: 0.8,
                area: ['65%', '70%'],
                content: './pic.php',//iframe的url
            });
            //抓取子窗口img的src，加入父窗口中
            window.top.document.image = function(src){
                // var img=document.getElementById('imgurl');
                var input=document.getElementById('thumb_url');
                // img.src='../images/'+src;
                mycars.push("/uploadfile/"+src);
                input.value =mycars;
                $("#pageall").append("<div style='border:#ddd 1px solid;margin:3px;padding:3px;width:103px;float:left'><img src='http://imageserver.echao.com/uploadfile/"+src+"' style='height:100px;width:100px;border:#ddd 1px solid;'><br><a  onclick='delpage()' href='Javascript: void(0)'   >&times;</a></div>");
                layer.close(index);
            }
        });
        //监听提交
        form.on('submit(demo1)', function(data){
            //console.log(data);
            $.post(adminurl,data.field,function( json ){
                console.log(json);
                if( json == 'go' ){
                    layer.msg('编辑成功');
                    //关闭子页面
                    parent.location.reload();
                }else{
                    layer.msg('编辑失败', function(){
                    });
                }
            });
            return false;
        });
        //ajax传输顶级分类的id到style_ajax.php
        function getSelectVal(data){
            var defval = data;
            $.getJSON("style_ajax.php",{bigname:defval},function(json){
                //清空原有的选项
                if(jQuery.isEmptyObject(json)){
                    $("#smallname  option").remove();
                    var option = "<option  value=''></option>";
                    $("#smallname").append(option);
                    form.render('select');
                }else{
                    $("#smallname  option").remove();
                    $.each(json,function(index,array){
                        //将返回的子级数据加入到子级分类的框中
                        var option = "<option   value='"+array['id']+"'>"+array['catename']+"</option>";
                        //console.log(option);
                        $("#smallname").append(option);
                        form.render('select'); //刷新select选择框渲染
                    });
                }
            });
        }
        // 表单两级联动
        getSelectVal();
        form.on('select(top)', function(data){
            var data = data['value'];
            getSelectVal( data );
        });
    });
</script>

</body>
</html>