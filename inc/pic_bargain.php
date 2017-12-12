<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
//if(!$c_uid) exit;
$c_uid = $_SESSION['uid'];
$foad = date("Ymd");
$uploadpath = 'D:/wwwpath/imageserver/uploadfile/'.$foad.'/';
$name = $_POST['name'];


if($delid)
{
    mysql_query("delete from web_pic_upload where id=$delid and members = '$c_uid'",$db);
    // delete_file('D:/wwwpath/imageserver/uploadfile/'.$files);
}

?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="format-detection" content="telephone=no">
<meta name="renderer" content="webkit">
<meta http-equiv="Cache-Control" content="no-siteapp" />

<link rel="stylesheet" href="./../layui/css/layui.css?t=1479413779832"  media="all">
<script src="./../layui/jquery.min.js" charset="utf-8"></script>
<script src="./../layui/layui.js" charset="utf-8"></script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--分页的样式-->
<style>
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

</style>
<script language="JavaScript">
    function fCheck(s,a)
    {
        window.top.document.image( s );
    }
</script>
<body style="margin:0;background:#FFF;padding:0">
<?php
//---------------------------------------------------------------------------------------

if(isset($_FILES) && !empty($_FILES['userfile']) && $_FILES['userfile']['size']>0)
{
    //if(!$cook_id) exit;
    // mkdirm($uploadpath);
    // @$filename = $_FILES['userfile']['name'];
    //  @$filenames = time().'.'.end(explode('.', $filename));
    // @$uploadfile = $uploadpath.$filenames;
    // $filetype = $_FILES["userfile"]["type"];


    for ($i = 0; $i < count($_FILES['userfile']['name']); $i++) {
        mkdirm($uploadpath);
        $filename = $_FILES['userfile']['name'][$i];
        $filenames = substr(md5($filename.time()),-10).'.'.substr($filename, -3);
        $uploadfile = $uploadpath.$filenames;
        $filetype = $_FILES["userfile"]["type"][$i];

        // var_dump( $uploadfile );

        if (copy($_FILES['userfile']['tmp_name'][$i], $uploadfile))
        {
            //$uploaddir = 'D:/wwwpath/imageserver/uploadfile/';
            $name = "kj-".$filenames;
            $_filenames = $uploadpath.$filenames;
            //缩略图   原图  宽度480  高度 新图  文件路径
            $new_img = PicResize($_filenames,375,"",$name,$uploadpath);
            // 修改成功后删除原图
            if( $new_img['if_eoor'] == 'pass' ){
                unlink($_filenames);
            }
            $pic_name = $foad."/".$name;
            $pic_size = $_FILES['userfile']['size'][$i];
            $reg_date = date("Y-m-d H:i:s");
            $sql = "insert into web_pic_upload (pic_name,pic_size,pic_type,reg_date,members,filetype,name) values ('$pic_name','$pic_size','1','$reg_date','$c_uid','$filetype','$name')";
            var_dump(mysql_query($sql,$db));

            echo "<script language=\"JavaScript\">  fCheck('".$pic_name."','".$inputname."');</script>";
        }
        else
        {
            echo "Fail<br>"; //24wj_newmember
        }
    }
}


?>


<table  class="am-table" style="background:#FFF;width:100%;">

    <tr>
        <form enctype="multipart/form-data"  method="POST">
            <td colspan="5" bgcolor="#FFFFFF" style="height:40px;text-align:center;font-size:13px;">
                <input name="userfile[]" type="file"  multiple  >
                <input type="text" name="name" placeholder="请输入图片名称" style="height:30px;padding:0 10px;-webkit-box-shadow: 0 0 0px 1000px white inset; border: 1px solid #CCC!important; ">　
                <input type="hidden" name="iname" value="<?=$iname?>">
                <!-- <input type="file" name="file（可随便定义）" class="layui-upload-file"> -->
                <button type="submit" class="layui-btn" style="height:35px;">上 载</button>
            </td>
        </form>
    </tr>
    <tr align=center>
        <form action="pic.php">
            <td colspan="5" height="40"  style="color:#ff0000; font-size:13px;"> *请上载或点击选择一下已经存在的图片*　 <input type="text" name="sou_name" placeholder="请输入图片名称" value="<?php echo $sou_name; ?>" style="height:30px;padding:0 10px;-webkit-box-shadow: 0 0 0px 1000px white inset; border: 1px solid #CCC!important; "> 　<button type="submit" class="layui-btn layui-btn-primary" style="height:35px;">搜 索</button>  </td>
        </form>
        <?php
        $sou_name = $_GET['sou_name'];
        $sql = "select id,pic_name,filetype from web_pic_upload where members='$c_uid'";
        if( $sou_name ){
            $sql.=" and name='$sou_name'";
        }
        $sql.=" order by id desc";
        $num = 0;
        $page_get = 'inputname='.$inputname;;
        pages($sql,$s,$page_get,15);
        while($rs=mysql_fetch_array($results_date))
        {
            if($rs[0] != "")
            {
                if($num%5 == 0) echo "</tr><tr>"
                ?>
                <td width="20%" style="height:99px;" align="center" bgcolor="#FFFFFF"><a href="####" onClick="javascript:fCheck('<?=$rs[1]?>','<?=$inputname?>')">
                        <? if($rs[2]=='video/quicktime'){?>

                            <video id="sampleMovie" src="<?=$imageserver?>/uploadfile/<?=$rs[1]?>"  controls style="width:70px;height:70px"></video>
                        <? }else{?>
                            <img src="<?=$imageserver?>/uploadfile/<?=$rs[1]?>" border="1" style="width:70px;height:70px;background:#ccc;">
                        <? }?>
                    </a> <br>
                    <a href="?delid=<?=$rs[0]?>&files=<?=$rs[1]?>" class="am-close am-close-spin" data-am-modal-close><i class="layui-icon">&#x1006;</i></a>
                </td>
                <?php
                $num++;
            }
        }
        ?>
    </tr>
    <tr><td colspan="5" height="30" style="text-align:center;height:35px;font-size:12px;"><?php echo $pageNavi;  ?></td></tr>
</table>

<script language="javascript">
    //layui.use('upload', function(){
    //  layui.upload(options);
    //});

</script>

</body>

