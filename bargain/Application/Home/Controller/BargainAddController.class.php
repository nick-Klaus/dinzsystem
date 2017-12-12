<?php

namespace Home\Controller;

use Think\Controller;

class BargainAddController extends Controller
{
    public function _initialize()
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        header('Access-Control-Allow-Methods: GET, POST, PUT');
    }

    //缩略图   原图  宽度480  高度 新图  文件路径
    public function PicResize($bigName,$maxwidth,$maxheight,$name,$uploaddir)
{
    $bigName = $uploaddir.$bigName;
    $info=getimagesize($bigName);
    switch($info[2])
    {
        case 1:
            $im = imagecreatefromgif($bigName);
            break;
        case 2:
            $im = imagecreatefromjpeg($bigName);
            break;
        case 3:
            $im = imagecreatefrompng($bigName);
            break;
        default:
            $array_error['file_name'] = $bigName;
            $array_error['if_eoor'] = "fail";
            $array_error['file_no'] = $info[2];
            $array_error['file_type'] = $info['mime'];
            return $array_error;
    }
    if(!$im){
        $array_error['file_name'] = $bigName;
        $array_error['if_eoor'] = "fail";
        $array_error['file_no'] = $info[2];
        $array_error['file_type'] = $info['mime'];
        return $array_error;
    }
    $width = imagesx($im);
    $height = imagesy($im);
    if(($maxwidth && $width > $maxwidth) || ($maxheight && $height > $maxheight))
    {
        if($maxwidth && $width > $maxwidth)
        {
            $widthratio = $maxwidth/$width;
            $RESIZEWIDTH=true;
        }
        if($maxheight && $height > $maxheight)
        {
            $heightratio = $maxheight/$height;
            $RESIZEHEIGHT=true;
        }
        if($RESIZEWIDTH && $RESIZEHEIGHT)
        {
            if($widthratio < $heightratio)
            {
                $ratio = $widthratio;
            }
            else
            {
                $ratio = $heightratio;
            }
        }
        elseif($RESIZEWIDTH)
        {
            $ratio = $widthratio;
        }elseif($RESIZEHEIGHT)
        {
            $ratio = $heightratio;
        }
        if($ratio>0)
        {
            $newwidth = $width * $ratio;
            $newheight = $height * $ratio;
        }
        else
        {
            $newwidth =$maxwidth;
            $newheight =$maxheight;
        }
        if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth, $newheight);
            imagecopyresampled($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }
        else
        {
            $newim = imagecreate($newwidth, $newheight);
            imagecopyresized($newim, $im, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
        }

        if($info[2]==1)
            imagegif ($newim,$uploaddir.$name);
        else if($info[2] == 2)
            ImageJpeg ($newim,$uploaddir.$name);
        else if($info[2] == 3)
            Imagepng ($newim,$uploaddir.$name);

        ImageDestroy ($newim);
    }
    else
    {
        if($info["mime"]=="image/gif")
            imagegif ($im,$uploaddir.$name . ".gif");
        elseif($info["mime"] == "image/pjpeg"||$info["mime"]=="image/jpeg")
            ImageJpeg ($im,$uploaddir.$name . ".jpg");
    }
    $array_error['file_name'] = $bigName;
    $array_error['if_eoor'] = "pass";
    $array_error['file_no'] = $info[2];
    $array_error['file_type'] = $info['mime'];
    return $array_error;
    //$name.substr($bigName,-4,4);
}

    // $base64 图片处理
    public function save_image($base64)
    {
        $code = uniqid("IMG");
        $now_ymd = date("Ymd");
        preg_match("/^data:([a-zA-Z]+)\/([a-zA-Z]+);base64,(.*?)$/", $base64, $matches);
        if (count($matches) === 4) {
            list($base64, $i_type, $i_suffix, $i_data) = $matches;
            $filename = $code . "." . $i_suffix;// 文件名
            $filepath = "./Public/Uploads/" . $filename;// 完整路径
            $fileurl = "http://master.echao.com/bargain/Public/Uploads/" . $filename;
            if (!file_exists(dirname($filepath))) {
                return @mkdir(dirname($filepath), 0777, true);
            }
            // 保存图片
            if (@file_put_contents($filepath, base64_decode($i_data))) {
                //return $fileurl;
               return $filename;
            }
            return "图片保存失败";
        }
        return "图片格式错误";
    }

    // 图片上传
    public function uploads()
    {
        $onlyimg = I("post.onlyimg");
        $contact_img = I("post.contact_img");
        $gift_describe = I("post.gift_describe");
        $company_introduction_img = I("post.company_introduction_img");
        if ($onlyimg) {
            $base64 = $onlyimg;
        }
        if ($gift_describe) {
            $base64 = $gift_describe;
        }
        if ($contact_img) {
            $base64 = $contact_img;
        }
        if ($company_introduction_img) {
            $base64 = $company_introduction_img;
        }
        // 旧图片名称
        $img = $this->save_image($base64);
        // 新图片
        $uploaddir = "Public/Uploads/";
        $name = time().substr( $img,strpos($img,"."));
        $new_img = $this->PicResize($img,480,"",$name,$uploaddir);
        // 如果切图成功 则删除旧图片
        if( $new_img['if_eoor'] == 'pass' ){
            unlink("./Public/Uploads/".$img);
        }
        $this->ajaxReturn( "http://master.echao.com/bargain/Public/Uploads/".$name );
    }

    // 添加新的砍价活动
    public function addcontent()
    {
        // 查询出管理员信息
        $adminid = I("post.adminid");
        if ($adminid) {
            $admin_data = M("bargain_admin")->where(array("id" => $adminid))->find();
        }
        $create = array(
            "openid" => I("post.openid"),
            "image_logo" => I("post.onlyimg"),
            "title" => I("post.title"),
            "start_time" => date("Y/m/d H:i:s", strtotime(I("post.start_time"))),
            "end_time" => date("Y/m/d H:i:s", strtotime(I("post.end_time"))),
            "original_price" => I("post.original_price"),
            "floor_price" => I("post.floor_price"),
            "bargain_times" => I("post.bargain_times"),
            "min_sale" => I("post.min_sale"),
            "max_sale" => I("post.max_sale"),
            "new_gift_quantity" => I("post.gift_quantity"),//添加的礼品剩余数量等于
            "gift_quantity" => I("post.gift_quantity"),
            "gift_describe" => json_encode(I("post.arrimg"), true),
            "gift_describe_txt" => I("post.gift_describe_txt"),
            "max_people" => I("post.max_people", "intval"),
            "activity_rules" => I("post.activity_rules"),
            "award_information" => I("post.award_information"),
            "company_introduction" => I("post.company_introduction"),
            "company_introduction_img" => json_encode(I("post.company_introduction_img"), true),
            "phone_number" => I("post.phone_number"),
            "template" => I("post.template"),
            "contact_img" => I("post.contact_img"),
            "admin_id" => $adminid,
            "status" => 0,
            "addtime" => time()
        );
        if ($res = M("Bargain")->add($create)) {
            $create_user = array(
                "openid" => $create['openid'],
                "bargain_id" => $res,
                "phone_number" => $admin_data["phone"],
                "username" => $admin_data["company_name"],
                "original_price" => $create['original_price'],
                "floor_price" => $create['floor_price'],
                "new_price" => $create['original_price'],
                "bargain_type" => 2,
                "bargain_times" => 9999,
                "ip" => get_client_ip(),
                "addtime" => time()
            );
            $row = M("bargain_user")->add($create_user);
            // $this->success('新增成功');
            $this->ajaxReturn(array('res' => $res, "row" => $row));
        } else {
            $this->ajaxReturn('新增失败');
        }
    }

    // 添加新的砍价活动 banner
    public function addcontent_banner()
    {
        // 查询出管理员信息
        $adminid = I("post.adminid");
        if ($adminid) {
            $admin_data = M("bargain_admin")->where(array("id" => $adminid))->find();
        }
        $create = array(
            "openid" => I("post.openid"),
            "image_logo" => json_encode(I("post.index_img"), true),
            "title" => I("post.title"),
            "start_time" => date("Y/m/d H:i:s", strtotime(I("post.start_time"))),
            "end_time" => date("Y/m/d H:i:s", strtotime(I("post.end_time"))),
            "original_price" => I("post.original_price"),
            "floor_price" => I("post.floor_price"),
            "bargain_times" => I("post.bargain_times"),
            "min_sale" => I("post.min_sale"),
            "max_sale" => I("post.max_sale"),
            "new_gift_quantity" => I("post.gift_quantity"),//添加的礼品剩余数量等于
            "gift_quantity" => I("post.gift_quantity"),
            "gift_describe" => json_encode(I("post.arrimg"), true),
            "gift_describe_txt" => I("post.gift_describe_txt"),
            "max_people" => I("post.max_people", "intval"),
            "activity_rules" => I("post.activity_rules"),
            "award_information" => I("post.award_information"),
            "company_introduction" => I("post.company_introduction"),
            "company_introduction_img" => json_encode(I("post.company_introduction_img"), true),
            "phone_number" => I("post.phone_number"),
            "template" => I("post.template"),
            "contact_img" => I("post.contact_img"),
            "admin_id" => $adminid,
            "status" => 0,
            "addtime" => time()
        );
        if ($res = M("Bargain")->add($create)) {
            $create_user = array(
                "openid" => $create['openid'],
                "bargain_id" => $res,
                "phone_number" => $admin_data["phone"],
                "username" => $admin_data["company_name"],
                "original_price" => $create['original_price'],
                "floor_price" => $create['floor_price'],
                "new_price" => $create['original_price'],
                "bargain_type" => 2,
                "bargain_times" => 9999,
                "ip" => get_client_ip(),
                "addtime" => time()
            );
            $row = M("bargain_user")->add($create_user);
            // $this->success('新增成功');
            $this->ajaxReturn(array('res' => $res, "row" => $row));
        } else {
            $this->ajaxReturn('新增失败');
        }
    }
}