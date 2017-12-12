<?php

session_start();
if(!isset( $_SESSION['username']) && !isset( $_SESSION['uid'] ) ){
        header("Location:http://master.echao.com/login.php");
        exit('你无权访问');
    }   

//创建文件夹
function mkdirm($path) 
{ 
	if (!file_exists($path)) 
	{ 
		mkdirm(dirname($path)); 
		mkdir($path, 0777); 
	} 
} 

//删除文件夹及其文件夹下所有文件
function removeDir($dirName) 
{ 
    if(!is_dir($dirName)) 
    { 
   @unlink($dirName);
        return false; 
    } 
    $handle = @opendir($dirName); 
    while(($file = @readdir($handle)) !== false) 
    { 
        if($file != '.' && $file != '..') 
        { 
            $dir = $dirName . '/' . $file; 
            is_dir($dir) ? removeDir($dir) : @unlink($dir); 
        } 
    } 
    closedir($handle); 
     
    return rmdir($dirName) ; 
} 



//写文件
function WriteFile($s_FileName,$s_Text)
{
	if (!$handle = fopen($s_FileName, 'w')) 
	{
	   exit;
	}
	if (fwrite($handle, $s_Text) === FALSE) 
	{
	   exit;
	}
	fclose($handle);
}
//删除文件

function delete_file($file){
      $delete = @unlink($file);
      clearstatcache();
      if(@file_exists($file)){
        $filesys = eregi_replace("/","\\",$file);
        $delete = @system("del $filesys");
        clearstatcache();
        if(@file_exists($file)){
            $delete = @chmod ($file, 0777);
            $delete = @unlink($file);
            $delete = @system("del $filesys");
        }
      }
      clearstatcache();
      if(@file_exists($file)){
        return false;
      }else{
        return true;
      }
}

//缩略图
function PicResize($bigName,$maxwidth,$maxheight,$name,$uploaddir) 
{ 
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



//水印

function imageWaterMark($groundImage,$waterPos=6,$waterImage="",$waterText="",$textFont=5,$textColor="#FF0000") 
{ 
    $isWaterImage = FALSE; 
    $formatMsg = "<SCRIPT language=javascript>alert('只能是gif,jpg,png图片！返回!');history.go(-1);</SCRIPT>"; 

    //读取水印文件 
    if(!empty($waterImage) && file_exists($waterImage)) 
    { 
        $isWaterImage = TRUE; 
        $water_info = getimagesize($waterImage); 
        $water_w    = $water_info[0];//取得水印图片的宽 
        $water_h    = $water_info[1];//取得水印图片的高 

        switch($water_info[2])//取得水印图片的格式 
        { 
            case 1:$water_im = imagecreatefromgif($waterImage);break; 
            case 2:$water_im = imagecreatefromjpeg($waterImage);break; 
            case 3:$water_im = imagecreatefrompng($waterImage);break; 
            default:die($formatMsg); 
        } 
    } 

    //读取背景图片 
    if(!empty($groundImage) && file_exists($groundImage)) 
    { 
        $ground_info = getimagesize($groundImage); 
        $ground_w    = $ground_info[0];//取得背景图片的宽 
        $ground_h    = $ground_info[1];//取得背景图片的高 

        switch($ground_info[2])//取得背景图片的格式 
        { 
            case 1:$ground_im = imagecreatefromgif($groundImage);break; 
            case 2:$ground_im = imagecreatefromjpeg($groundImage);break; 
            case 3:$ground_im = imagecreatefrompng($groundImage);break; 
            default:die($formatMsg); 
        } 
    } 
    else 
    { 
        die("需要加水印的图片不存在！"); 
    } 

    //水印位置 
    if($isWaterImage)//图片水印 
    { 
        $w = $water_w; 
        $h = $water_h; 
        $label = "图片的"; 
    } 
    else//文字水印 
    { 
        $temp = imagettfbbox(ceil($textFont*2.5),0,"./cour.ttf",$waterText);//取得使用 TrueType 字体的文本的范围 
        $w = $temp[2] - $temp[6]; 
        $h = $temp[3] - $temp[7]; 
        unset($temp); 
        $label = "文字区域"; 
    } 
    if( ($ground_w<$w) || ($ground_h<$h) ) 
    { 
        echo "需要加水印的图片的长度或宽度比水印".$label."还小，无法生成水印！"; 
        return; 
    } 
    switch($waterPos) 
    { 
        case 0://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break; 
        case 1://1为顶端居左 
            $posX = 0; 
            $posY = 0; 
            break; 
        case 2://2为顶端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = 0; 
            break; 
        case 3://3为顶端居右 
            $posX = $ground_w - $w; 
            $posY = 0; 
            break; 
        case 4://4为中部居左 
            $posX = 0; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 5://5为中部居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 6://6为中部居右 
            $posX = $ground_w - $w; 
            $posY = ($ground_h - $h) / 2; 
            break; 
        case 7://7为底端居左 
            $posX = 0; 
            $posY = $ground_h - $h; 
            break; 
        case 8://8为底端居中 
            $posX = ($ground_w - $w) / 2; 
            $posY = $ground_h - $h; 
            break; 
        case 9://9为底端居右 
            $posX = $ground_w - $w; 
            $posY = $ground_h - $h; 
            break; 
        default://随机 
            $posX = rand(0,($ground_w - $w)); 
            $posY = rand(0,($ground_h - $h)); 
            break;     
    } 

    //设定图像的混色模式 
    imagealphablending($ground_im, true); 

    if($isWaterImage)//图片水印 
    { 
        imagecopy($ground_im, $water_im, $posX, $posY, 0, 0, $water_w,$water_h);//拷贝水印到目标文件         
    } 
    else//文字水印 
    { 
        if( !empty($textColor) && (strlen($textColor)==7) ) 
        { 
            $R = hexdec(substr($textColor,1,2)); 
            $G = hexdec(substr($textColor,3,2)); 
            $B = hexdec(substr($textColor,5)); 
        } 
        else 
        { 
            die("水印文字颜色格式不正确！"); 
        } 
        imagestring ( $ground_im, $textFont, $posX, $posY, $waterText, imagecolorallocate($ground_im, $R, $G, $B));         
    } 

    //生成水印后的图片 
    @unlink($groundImage); 
    switch($ground_info[2])//取得背景图片的格式 
    { 
        case 1:imagegif($ground_im,$groundImage);break; 
        case 2:imagejpeg($ground_im,$groundImage);break; 
        case 3:imagepng($ground_im,$groundImage);break; 
        default:die($errorMsg); 
    } 

    //释放内存 
    if(isset($water_info)) unset($water_info); 
    if(isset($water_im)) imagedestroy($water_im); 
    unset($ground_info); 
    imagedestroy($ground_im); 
} 







function wfile($file,$str,$mode='w')
{
    $oldmask = @umask(0);
    $fp = @fopen($file,$mode);
    @flock($fp, 3);
    if(!$fp)
    {
        Return false;
    }
    else
    {
        @fwrite($fp,$str);
        @fclose($fp);
        @umask($oldmask);
        Return true;
    }
}

function savetofile($path_get,$path_save)
{
        @$hdl_read = fopen($path_get,'rb');
        if($hdl_read == false)
        {
                echo("<span style='color:red'>$path_get can not get</span>");
                Return ;
        }
        if($hdl_read)
        {
                @$hdl_write = fopen($path_save,'wb');
                if($hdl_write)
                {
                        while(!feof($hdl_read))
                        {
                                fwrite($hdl_write,fread($hdl_read,8192));
                        }
                        fclose($hdl_write);
                        fclose($hdl_read);
                        return 1;
                }
                else
                        return 0;
        }
        else
                return -1;
}

function getExt($path)
{
        $path = pathinfo($path);
        return strtolower($path['extension']);
}

/**
* 按指定路径生成目录
*
* @param    string     $path    路径
*/
function mkDirs($path)
{
    $adir = explode('/',$path);
    $dirlist = '';
    $rootdir = array_shift($adir);
    if(($rootdir!='.'||$rootdir!='..')&&!file_exists($rootdir))
    {
        @mkdir($rootdir);
    }
    foreach($adir as $key=>$val)
    {
        if($val!='.'&&$val!='..')
        {
            $dirlist .= "/".$val;
            $dirpath = $rootdir.$dirlist;
            if(!file_exists($dirpath))
            {
                @mkdir($dirpath);
                @chmod($dirpath,0777);
            }
        }
    }
}

function remote_filesize($url_file){ 
    if (!remote_file_exists($url_file)) return false; 
    $headInf = get_headers($url_file,1); 
    return $headInf['Content-Length']; 
} 
// CHECK REMOTE FILE LAST MODIFIED TIME (RETURN UNIX TIMESTAMP) 
function remote_filectime($url_file){ 
    if (!remote_file_exists($url_file)) return false; 
    $headInf = get_headers($url_file,1); 
    return strtotime($headInf['Last-Modified']); 
} 

function remote_file_exists($url_file){ 
    $url_file = trim($url_file); 
    if (empty($url_file)) return false; 
    $url_arr = parse_url($url_file); 
    if (!is_array($url_arr) || empty($url_arr)) return false; 
    $host = $url_arr['host']; 
    $path = $url_arr['path'] ."?".$url_arr['query']; 
    $port = isset($url_arr['port']) ?$url_arr['port'] : "80"; 
    $fp = fsockopen($host, $port, $err_no, $err_str,30); 
    if (!$fp) return false; 
    $request_str = "GET ".$path." HTTP/1.1\r\n"; 
    $request_str .= "Host:".$host."\r\n"; 
    $request_str .= "Connection:Close\r\n\r\n"; 
    fwrite($fp,$request_str); 
    //fread replace fgets 
    $first_header = fread($fp, 128); 
    fclose($fp); 
    if (trim($first_header) == "") return false; 
    //check $url_file "Content-Location" 
    if (!preg_match("/200/", $first_header) || preg_match("/Location:/", $first_header)) return false; 
    return true; 
} 







?>