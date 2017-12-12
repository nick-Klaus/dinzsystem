<?php
include "./../fun/eby_admin_api.php";
$times = time();

if($act == 'loginyes')
{
    
    $sql = "select * from e_members where username='$admin_user' and password='$admin_pwd'";
	$rs = fetchOne($sql);
	if($rs)
	{
	   cook('c_uid',$rs['uid']);
	   cook('c_domain',$rs['domain']);
	   cook('c_username',$rs['username']);
	   topgo('../default.php');
	}
	else
	{
        
	   pop('登录错误','请检查用户名或密码是否正确');
	}
}


if($act == 'update_style_one')
{
   $sql = "update e_goods_sylte set $name = '$val' where id='$id'";
   mysql_query($sql,$db) or db_error();
   echo 'ok';
   exit;
}


if($act == 'add_box')
{
   
   if($uid)
   {
	   $openid = md5($times.$uid);
	   $array = array(
		  'openid' => $openid,
		  'uid' => $uid
	   );
	   insert($array,'e_mac_code');
   }
   header("Location:http://api.echao.com/master/?a=boxlist");
    exit;
}


if($act == 'add_cls')
{
   $sql = "insert into e_goods_category (catename,pid,webid,adduid,times) values ('$catename','$pid','0','$c_uid','$times')";

   mysql_query($sql,$db) or db_error();
   echo 'ok';	
}

if($act == 'updateclsname')
{
   $val = trim($val);
   $sql = "update e_goods_category set catename = '$val' where id='$id' and adduid = '$c_uid'";
   mysql_query($sql,$db) or db_error();
   echo 'ok';
}

if($act == 'upd_box_pic')
{
   $val = trim($val);
   $sql = "update e_goods_category set box_default_ico = '$val' where id='$id' and adduid = '$c_uid'";
   mysql_query($sql,$db) or db_error();
   echo 'ok';
}


if($act == 'update_order')
{
   $array = array(
     'pay_id' => $pay_id,
	 'rmb2' => $rmb2,
	 'lxr' => $lxr,
	 'mob' => $mob,
	 'addr' => $addr,
	 'email' => $email
   );
   update($array,'e_order','order_no='.$order_no);
   header("Location:http://api.echao.com/master/?a=ordershow&&order_no=".$order_no);
    exit;
}

if($act == 'add_order_log')
{
	$array = array(
		 'order_no' => $order_no,
		 'times' => $times,
		 'logty' => $logty,
		 'logtyname' => $logtyname,
		 'diatxt' => $diatxt,
		 'ip' => $ip
	   );
	   
	   insert($array,'e_order_log');
	      header("Location:http://api.echao.com/master/?a=ordershow&&order_no=".$order_no);
    exit;
}

		
if($act == 'clsjson')
{
  
  $addsql = strsplit($c_domain,$c_uid,0);
  $sql = "select categorytype from e_members where uid='$c_uid'";
  $categorytype = fetchOne($sql)['categorytype'];
     if($categorytype == 1)
	 $sql = "select * from e_goods_category where pid=0 and adduid = '$c_uid'  order by times desc ";
	else
	 $sql = "select * from e_goods_category where pid=0 and $addsql  order by times desc ";
  
   //$sql = "select * from e_goods_category where pid = 0  order by times desc";
   $arr = fetchAll($sql);
   for($i=0;$i<count($arr);$i++)
   {
      
	  
	  
	   $sql = "select * from e_goods_category where pid = '".$arr[$i]['id']."'  order by times desc";
       $arrlist = fetchAll($sql);
	   for($v=0;$v<count($arrlist);$v++)
	   {
		   $json_arr[$i][$v] = array(
			   "v" => $arrlist[$v]['id'],
			   "n" => $arrlist[$v]['catename'],
			   "s" => ''
		   );
	   }
	   
	   
	   $json[$i] = array(
	       "v" => $arr[$i]['id'],
	       "n" => $arr[$i]['catename'],
	       "s" => $json_arr[$i]
       );
   }
   
   
    echo json_encode($json);
   
   exit;
  
}


if($act == 'admin_member_set')
{
     $array = array
	 (
	    'username' => $username,
		'password' => $password,
		'member_name' => $member_name,
		'member_phone'=> $member_phone,
		'datatype' => $datatype,
		'categorytype' => $categorytype,
		'diamond_data_typ' => $diamond_data_typ,
		'g_18' => $g_18,
		'g_pt' => $g_pt,
		'huilv' => $huilv,
		'style_thumb' => $style_thumb
	 );
	 
	if($uid)
	print_r(update($array,'e_members','uid='.$uid));
	else
	print_r(insert($array,'e_members'));
	
	
	header("Location:http://api.echao.com/master/?a=memberUpdate");
    exit;
}

if($act == 'add_admin_user')
{
     
	 
	 $arr = fetchOne("select domain from e_members where uid = '$cuid'");
	 if($arr) $domain = $arr['domain'].$cuid.',';
	 $array = array
	 (
	    'username' => $username,
		'password' => $password,
		'user_bz' => $user_bz,
		'domain' => $domain,
		'cuid'=> $cuid,
		'datatype' => $datatype,
		'diamond_data_typ' => $diamond_data_typ,
		'categorytype'=> $categorytype,
		'regdate' => $times
	 );
	 
	// print_r($array);
	 
	 
	if($uid)
	 update($array,'e_members','uid='.$uid);
	else
	 insert($array,'e_members');
	
	//echo $sql;
	header("Location:http://api.echao.com/master/?a=admin_list");
    exit;
}



if($act == 'add_fx_admin_user')
{
     $array = array
	 (
	    'username' => $username,
		'userpwd' => $userpwd,
		'user_bz' => $user_bz,
		'usertyp' => 1,
		'webid'=> $webid
	 );
	 
	 print_r($array);
	 
	 
	if($uid)
	 update($array,'e_fx_members','uid='.$uid);
	else
	 insert($array,'e_fx_members');
	
	//echo $sql;
	header("Location:http://api.echao.com/master/?a=fx_member");
    exit;
}

if($act == 'add_gems')
{
   $array = array
   (
      'Ref' => $Ref,
	  'pic' => $pic,
	  'category' => $category,
	  'Shape' => $Shape,
	  'style' => $style,
	  'Grade' => $Grade,
	  'Size' => $Size,
	  'spe' => $spe,
	  'Rate' => $Rate,
	  'Bz' => $Bz,
   );
   if($id)
	print_r(update($array,'e_gems','id='.$id));
	else
	print_r(insert($array,'e_gems'));
	
	
	header("Location:http://api.echao.com/master/?a=gems_admin");
    exit;
}

if($act == 'add_goods_list')
{
    $array = array
	(
		'style_no' => $style_no,
		'goods_no' => $goods_no,
		'goods_name' => $goods_name,
		'goods_thumb' => $goods_thumb,
		'goods_video' => $goods_video,
		'Price' => $Price,
		'material' => $material,
		'GoodsSize' => $GoodsSize,
		'goldWeight' => $goldWeight,
		'StoneType' => $StoneType,
		'StonePrice' => $StonePrice,
		'StoneTxt' => $StoneTxt,
		'Color' => $Color,
		'Clarity' => $Clarity,
		'StoneWeight' => $StoneWeight,
		'DeStoneNum' => $DeStoneNum,
		'DeStoneWeight' => $DeStoneWeight
	);
	if($id)
	print_r(update($array,'e_goods_list','id='.$id));
	else
	print_r(insert($array,'e_goods_list'));
	
	
	header("Location:http://api.echao.com/master/?a=add_goods&style_no=".$style_no);
    exit;
}

if($act == 'add_style')
{


  // print_r($_POST);
  if(!$stocks) $stocks = 1;
	$array = array
	(
	
	 'style_no'=>$style_no,
	 'style_name'=>$style_name,
	 'style_thumb'=>$style_thumb,
	 'style_video'=>$style_video,
	 'style_mode'=>$style_mode,
	 'style_sort'=>$style_sort,
	 'style_new'=>$style_new,
	 'style_hot'=>$style_hot,
	 'times'=>$times,
	 'factory'=>$factory,
	 'factory_no'=>$factory_no,
	 'style_brand'=>$style_brand,
	 'adduid'=>$adduid,
	 'cls1'=>$cls1,
	 'cls2'=>$cls2,
	 'cls3'=>$cls3,
	 'MinPrice'=>$MinPrice,
	 'MaxPrice'=>$MaxPrice,
	 'material'=>$material,
	 'GoodsSize'=>$GoodsSize,
	 'StoneType'=>$StoneType,
	 'StonePrice'=>$StonePrice,
	 'StoneTxt'=>$StoneTxt,
	 'goldWeight'=>$goldWeight,
	 'StoneNum'=>$StoneNum,
	 'MinStoneWeight'=>$MinStoneWeight,
	 'MaxStoneWeight'=>$MaxStoneWeight,
	 'DeStoneNum'=>$DeStoneNum,
	 'MinDeStoneWeight'=>$MinDeStoneWeight,
	 'MaxDeStoneWeight'=>$MaxDeStoneWeight,
	 'Color'=>$Color,
	 'Clarity'=>$Clarity,
	 'worksprice'=>$worksprice,
	 'thumb_url'=>$thumb_url,
	 'content'=>$content,
	 'price_18K'=>$price_18K,
	 'price_pt'=>$price_pt,
	 'goldWeight_18K'=>$goldWeight_18K,
	 'goldWeight_pt950'=>$goldWeight_pt950,
	 'stocks' => $stocks
	
	/*
		'cls1' => $cls1,
		'cls2' => $cls2,
		'cls3' => $cls3,
		'style_no' => $style_no,
		'style_name' => $style_name,
		'style_thumb' => $style_thumb,
		'style_video' => $style_video,
		'stocks' => $stocks,
		'factory' => $factory,
		'factory_no' => $factory_no,
		'style_brand' => $style_brand,
		'thumb_url' => $thumb_url,
		'worksprice' => $worksprice,
		'material' => $material,
		'GoodsSize' => $GoodsSize,
		'goldWeight' => $goldWeight,
		'StoneType' => $StoneType,
		'StonePrice' => $StonePrice,
		'StoneTxt' => $StoneTxt,
		'Color' => $Color,
		'Clarity' => $Clarity,
		'MinStoneWeight' => $MinStoneWeight,
		'MaxStoneWeight' => $MaxStoneWeight,
		'DeStoneNum' => $DeStoneNum,
		'MinDeStoneWeight' => $MinDeStoneWeight,
		'MaxDeStoneWeight' => $MaxDeStoneWeight,
		'content' => $content,
		'adduid' => $adduid,
		'style_new' => $style_new,
		'style_hot' => $style_hot,
		'style_mode' => $style_mode,
		'style_sort' => $style_sort,
		'goldWeight_pt950' => $goldWeight_pt950,
		'times' => $times 
	 */	
	);
	
//print_r($array);	
   if($id)
   update($array,'e_goods_sylte','id='.$id);
   else	   
   insert($array,'e_goods_sylte');
   
   header("Location:http://api.echao.com/master/?a=style_list");
   exit;
}


if($act == 'add_stu_cp')
{
    $arr = array(
	  'stu_id'=>$stu_id,
	  'stu_tit'=>$stu_tit,
	  'stu_pic'=>$stu_pic,
	  'stu_txt'=>$stu_txt,
	  'stu_type'=>$stu_type,
	  'thumb_url'=>$thumb_url,
	  'times'=>$times,
	  'video_url'=>$video_url,
	  'adduid'=>$adduid
	);
	if($id)
	  update($arr,'e_user_stu_list','id='.$id);
	else
	  insert($arr,'e_user_stu_list');
	 
	 
	//print_r($arr);  
	header("Location:http://api.echao.com/master/?a=add_stu_list&stu_id=".$stu_id);
}


if($act == 'admin_box_set')
{
    $arr = array(
	  'macpic'=>$macpic,
	  'mac_tit'=>$mac_tit,
	  'mac_logo'=>$mac_logo,
	  'mac_lxr'=>$mac_lxr,
	  'web_phone'=>$web_phone,
	  'thumb_url'=>$thumb_url,
	  'index_cid'=>$index_cid?join(',',$index_cid):'',
	  'uid'=>$uid,
	  'macid'=>$macid,
	  'jj'=>json_encode($jj)
	);
	if($id)
	  update($arr,'e_mac_set','id='.$id);
	else
	  insert($arr,'e_mac_set');
	  
	if($id && $uid)
	{
	
		$arr = array(
		'uid'=>$uid
		);
		update($arr,'e_mac_code','id='.$macid);
	}
	header("Location:http://api.echao.com/master/?a=boxlist");
}

if($act == 'admin_brand_set')
{
   $arr = array(
	  'brand'=>$thumb_url
	);
	if($id)
	  update($arr,'e_mac_set','id='.$id);
	else
	  insert($arr,'e_mac_set');
	
	header("Location:http://api.echao.com/master/?a=boxlist");  
}

if($act == 'admin_box_service')
{
    $arr = array(
	 'service_tit'=>$service_tit,
	 'service_logo'=>$service_logo,
	 'service_url'=>urlencode($service_url),
	 'uid'=>$uid
	);
	
	if($id)
	  update($arr,'e_mac_service','id='.$id);
	else
	  insert($arr,'e_mac_service');
	  
	header("Location:http://api.echao.com/master/?a=service&uid=".$uid);
}

if($act == 'add_ztlist')
{
   $arr = array(
	 'zt_name'=>$zt_name,
	 'zt_logo'=>$zt_logo,
	 'zt_benner'=>$zt_benner,
	 'zt_txt' => $zt_txt,
	 'times'=>time(),
	 'adduid'=>$adduid
	);
	
	if($id)
	  update($arr,'e_user_zt','id='.$id);
	else
	  insert($arr,'e_user_zt');
	  
	header("Location:http://api.echao.com/master/?a=ztlist&uid=".$adduid);
}


if($act == 'add_stulist')
{
   $arr = array(
	 'stu_name'=>$stu_name,
	 'stu_logo'=>$stu_logo,
	 'stu_txt' => $stu_txt,
	 'video_url' => $video_url,
	 'times'=>time(),
	 'adduid'=>$adduid
	);
	
	if($id)
	  update($arr,'e_user_stu','id='.$id);
	else
	  insert($arr,'e_user_stu');
	  
	header("Location:http://api.echao.com/master/?a=stu&uid=".$adduid);
}



if($act == 'add_zt_cp')
{
   if($style_no)
   {
   
   $sql = "select id from e_goods_sylte where style_no='$style_no'";
   //echo $sql;
   $rs = fetchAll($sql);
   //print_r($rs);
   if($rs)
   {
	   $sql = "select id from e_user_zt_goods where ztid='$ztid' and style_no='$style_no'";
	   $rs = fetchAll($sql);
	   if(!$rs) mysql_query("insert into e_user_zt_goods (ztid,style_no,adduid,times) values ('$ztid','$style_no','$adduid','$times')",$db) or db_error();  
   }
   }
   header("Location:http://api.echao.com/master/?a=add_zt_cp&ztid=".$ztid);
}

if($act == 'updatazk_user')
{
   $zk = trim($val);
   $sql = "select * from e_member_zk where uid='$uuid' and clsid='$id'";
   $rs = fetchAll($sql);
   if($rs)
   {
      mysql_query("update e_member_zk set zk='$zk' where clsid='$id' and uid='$uuid'",$db) or db_error();
   }
   else
   {
      mysql_query("insert into e_member_zk (zk,uid,clsid) values ('$zk','$uuid','$id')",$db) or db_error();
	   if($id == 'p0')
	  {
	       
		   
			
			for($i=1;$i<=4;$i++)
			{
			     $sqls = "select * from e_member_zk where uid='$uuid' and clsid='p0".$i."'";
				 if(!fetchAll($sqls)) mysql_query("insert into e_member_zk (zk,uid,clsid) values ('$zk','$uuid','p0".$i."')",$db) or db_error();
			}
	  }
   }
   echo 'ok';
}

if($act == 'updatazk_user_othen')
{
   $zk = trim($val);
   $sql = "select * from e_member_zk_othen where uid='$uuid' and clsid='$id'";
   $rs = fetchAll($sql);
   if($rs)
   {
      mysql_query("update e_member_zk_othen set zk='$zk' where clsid='$id' and uid='$uuid'",$db) or db_error();
   }
   else
   {
      mysql_query("insert into e_member_zk_othen (zk,uid,clsid) values ('$zk','$uuid','$id')",$db) or db_error();
	   if($id == 'p0')
	  {
	       
		   
			
			for($i=1;$i<=4;$i++)
			{
			     $sqls = "select * from e_member_zk_othen where uid='$uuid' and clsid='p0".$i."'";
				 if(!fetchAll($sqls)) mysql_query("insert into e_member_zk_othen (zk,uid,clsid) values ('$zk','$uuid','p0".$i."')",$db) or db_error();
			}
	  }
   }
   echo 'ok';
}
?>