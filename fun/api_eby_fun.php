<?php

function strsplit($c_domain,$c_uid,$datatype)
{
   if($datatype == 1)
   {
       return(" adduid = '$c_uid' ");
   }
   else
   {
	   if($c_domain)
	   {
		  $c_arr = explode(',',$c_domain);
		  $c_arr_len = count($c_arr)-1;
	
			  for($c=0;$c<$c_arr_len;$c++)
			  {
				  if($c>0) $addstr = ' or ';
				  $addtxt.= $addstr." adduid = '".$c_arr[$c]."' ";	
				  $addstr = '';	  
			  }
			  
			 $addtxt.= " or adduid = '$c_uid'";
			 return('('.$addtxt.')');
	   }
	   else
	   {
		   return(" adduid = '$c_uid' ");
	   }
   }
}






    function getIP() 
	{
		if (isset($_SERVER)) 
		{
				if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) 
				{
					 $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
				} 
				elseif (isset($_SERVER["HTTP_CLIENT_IP"])) 
				{
					 $realip = $_SERVER["HTTP_CLIENT_IP"];
				} 
				else 
				{
					 $realip = $_SERVER["REMOTE_ADDR"];
				}
		} 
		else 
		{
				if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) 
				{
					 $realip = getenv( 'HTTP_X_FORWARDED_FOR' );
				} 
				elseif ( getenv( 'HTTP_CLIENT_IP' ) ) 
				{
					 $realip = getenv( 'HTTP_CLIENT_IP' );
				} 
				else 
				{
					 $realip = getenv( 'REMOTE_ADDR' );
				}
		}
		return $realip;
	}

   function cook($cookname,$cookvalue,$time=0)
	{
		if($time)
		setcookie($cookname,$cookvalue,time()+3600*24*$time,'/','.echao.com');
		else
		setcookie($cookname,$cookvalue,0,'/','.echao.com');
	} 
	
	function uncook($cookname)
	{
		setcookie($cookname,'',0,'/','.echao.com');
	} 



function get_member_zk($clsid,$val)
{
	$zk_val = 100;	
	for($i=0;$i< count($val[$clsid]);$i++)
	{
	   $zk_val = $zk_val/100 * $val[$clsid][$i];
	   //echo $i."----".$val[$clsid][$i]."<br/>";
	}
	return($zk_val/100); 	
}


function show_zk($memberid,$clsid,$domain)
{
    
	   //if($uid!=1) $domain = trim(str_replace('1,','',$domain));
	  // echo $domain;
	   if($domain) $uidlist = $domain.$memberid;
	   $zk_othen_num = 1;
	   $sql_zk_othen = "select zk from e_member_zk_othen where uid='$memberid' and clsid='$clsid' order by id desc limit 0,1";
	  // echo $sql_zk_othen;
	   $zk_othen = fetchAll($sql_zk_othen);
	   if($zk_othen)
	   {
	      $uidlist = 1; 
		  $zk_othen_num = $zk_othen[0]['zk']/100;
	   }

	
	//echo 'PATH:'.$uidlist.'<br/>';
	
    if(!$domain)
	{
	     
		 //echo $uidlist;
		 
		 if($uidlist == 1)
		 {
		     return($zk_othen_num);
		 }
		 else
		 {
			 $sql_zk = "select zk from e_member_zk where uid='$memberid' and clsid='$clsid' order by id desc limit 0,1";
		     $zk = fetchAll($sql_zk);
			 if($zk)
			 {
				return($zk[0]['zk']/100);
			 }
			 else
			 {
				return(1);
			 }
			 
			  
		 }
	}
	else
	{
	  
	 
	   
		   $sql_zk = "select zk from e_member_zk where uid in ($uidlist) and clsid='$clsid'";
		   //echo $sql_zk;
		   $zk = fetchAll($sql_zk);
		   $zk_arr = 1;
		   for($zki=0;$zki<count($zk);$zki++)
		   {
			  if($zk[$zki]['zk']>0) $zk_arr = $zk_arr*$zk[$zki]['zk']/100;
		   }
	       
		   //print_r($zk_arr);
		   
	       return($zk_arr*$zk_othen_num);
	}
	//return($sql_zk);
}



function show_zk_s($memberid,$clsid,$domain)
{
    //echo 'PATH:'.$domain;
	//if($memberid!=1) $domain = trim(str_replace('1,','',$domain));
    if(!$domain)
	{
	     $sql_zk = "select zk from e_member_zk where uid='$memberid' and clsid='$clsid' order by id desc limit 0,1";
		 //echo $sql_zk;
		 $zk = fetchAll($sql_zk);
		 if($zk)
		 {
		    return($zk[0]['zk']/100);
			//return($sql_zk);
		 }
		 else
		 {
		    return(1);
			//return($sql_zk);
		 }
	}
	else
	{
	   $uidlist = $domain.$uid;
	   $zk_othen_num = 1;
	   
	   
		   $sql_zk = "select zk from e_member_zk where uid in ($uidlist) and clsid='$clsid'";
		   $zk = fetchAll($sql_zk);
		   $zk_arr = 1;
		   for($zki=0;$zki<count($zk);$zki++)
		   {
			  if($zk[$zki]['zk']>0) $zk_arr = $zk_arr*$zk[$zki]['zk']/100;
		   }
	  
	   return($zk_arr*$zk_othen_num);
	}
	//print_r($sql_zk);
	//echo $sql_zk;
	//return($sql_zk);
}



function zszk($size,$uid,$domain,$Disc,$Disc1,$Rap,$ty)
{
    $clsid = 'p0';

	
	
	 if($size*1 < 0.3) $clsid = 'p01';

	 
	 if($size*1 >= 0.3 && $size*1 < 0.39) $clsid = 'p02';	 
	 if($size*1 >= 0.4 && $size*1 < 0.49) $clsid = 'p03';
	 if($size*1 >= 0.5 && $size*1 < 0.59) $clsid = 'p04';
	 if($size*1 >= 0.6 && $size*1 < 0.69) $clsid = 'p05';
	 if($size*1 >= 0.7 && $size*1 < 0.79) $clsid = 'p06';
	 if($size*1 >= 0.8 && $size*1 < 0.89) $clsid = 'p07';
	 if($size*1 >= 0.9 && $size*1 < 0.99) $clsid = 'p08';
	 if($size*1 >= 1 && $size*1 < 1.99) $clsid = 'p09';
	 //if($size*1 >= 0.3 && $size*1 < 0.39) $clsid = 'p02';

	 
	 if($size*1 >= 2)  $clsid = 'p10';
     
	 if($ty==1)
	 {
	    $zk = show_zk($uid,$clsid,$domain)*100-100;
		$nowzk = 100-$Disc+$Disc1+$zk;
		$price = $Rap*$nowzk/100*$size;
		return($price);
	 }
	 else
	 {
	
	    return(show_zk($uid,$clsid,$domain));
	 }
	
}

function go($url)
	{
	   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8\" />";
	   echo "<script language=\"javascript\">\n";
	   echo "window.location='$url';\n";
	   echo "</script>";
	   exit;
	}

//网络图片本地化
function get_http_file($contents)
{
     preg_match_all('/<IMG.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $contents, $strResult);
	 for($i = 0; $i < count($strResult[1]); $i++)
	 {
		 // printf("%d %s \n", $i, $strResult[1][$i], $strResult[2][$i]);
			 $str = str_replace("\\","",$strResult[1][$i]);
			 $str = str_replace('"','',$str);
			  //echo $str."<br>";
			  //echo strpos($str,"://")."<bt/>";
			 if(strpos($str,"://") && !strpos($str,"192.168.31.102:82"))
			 {
				 $now_time = date("Ymd",time());
				 $save_url = "./../../uploadfile/httpxml/".$now_time."/";
				  mkdirm($save_url);
				 $isfile = remote_filesize($str);
				 $fileext = getExt($str);
				 if($fileext) 
				    $fileext = ".".getExt($str);
				 else
				     $fileext = ".jpg";	
				 $file = $save_url.date("His",time())."_".$i.$fileext;
				 savetofile($str,$file);
				 $newsurl = str_replace("./../../","http://192.168.31.102:82/",$file);
				 $contents = str_replace($str,$newsurl,$contents);
			 }
	}
	return($contents);
}





		
	function pages($sql_date,$s,$page_get,$pl_item_total=10,$self_tmp='')
	{
		global $pageNavi;
		global $show_page;
		global $numrows_date;
		global $results_date;
	
		$results_date=mysql_query($sql_date);
		$numrows_date=mysql_num_rows($results_date);
		if(!$s) $s=0;
		$limit=$pl_item_total; 
		$sql_date.= " limit $s,$limit";
		//echo $sql_date;
		$results_date = mysql_query($sql_date) or die("error" .mysql_error());
		if($numrows_date!=0)
		{
			$currPage = (($s/$limit) + 1);
			$a = $s + ($limit) ;
			if($a > $numrows_date) 
				$a = $numrows_date ; 
			$b = $s + 1 ;
			//$show_page = "<p>显示结果: $b-$a / $numrows_date</p>";
			$show_page = $numrows_date;
			if ($s>=1) { // bypass PREV link if s is 0
				$prevs=($s-$limit);
				if($s > 1)
				{
					$pageNavi.="<a href='$self_tmp?s=0&$page_get' target='_self'  >首页</a>&nbsp&nbsp; ";
					$pageNavi.="<a href='$self_tmp?s=$prevs&$page_get' target='_self'   >上一页</a>&nbsp&nbsp; ";
				}
				else
				{
					$pageNavi.="<a href=\"javascript:\" target='_self'  >首页</a>&nbsp&nbsp; ";
					$pageNavi.="<a href=\"javascript:\" target='_self'  >上一页</a>&nbsp&nbsp; ";
				}
			}

			$pages=intval($numrows_date/$limit);
			if($numrows_date%$limit) 
				$pages++;
			 
			//for testing
			$tmp_page=(($s+$limit)/$limit);
			//echo "Page#: $tmp_page<br>"; 
			
				if($pages>1)
				{
					   $news=$s+$limit;  
					   for($c=1;$c<=$pages;$c++)
					   {
							if($c==1)
							{
							  $s_tmp=0;									  
							}
							else
							{
							  $n=($c-1)*$limit;
							  $s_tmp=$n;									  
							}
						
							if($tmp_page==$c)
							{
								$pageNavi_f="<font color=red ><b>";
								$pageNavi_b="</b></font>&nbsp;&nbsp;";
							}else{
								$pageNavi_f="<a href='$self_tmp?s=$s_tmp&$page_get' target='_self'>";
								$pageNavi_b="</a>&nbsp;&nbsp;";
							}
						
							if(($c>($tmp_page-5))&&($c<($tmp_page+5)))
							{
								$pageNavi.=$pageNavi_f." $c ".$pageNavi_b; 	
							} 	
						
					   }//for
				   
				  
				   
					   $last_tmp=$pages; 
					   $last_tmp=$last_tmp-1;
					   $s_tmp=$limit*$last_tmp;
				  
					   if(!((($s+$limit)/$limit)==$pages) && $pages!=1)
					   {  
						  $pageNavi.="<a href='$self_tmp?s=$news&$page_get' target='_self'>下一页</a>&nbsp;&nbsp;";
						  $pageNavi.="<a href='$self_tmp?s=$s_tmp&$page_get' target='_self'>尾页</a>";
					   }
					   else
					   {
					      $pageNavi.="<a href=\"javascript:\" target='_self'>下一页</a>&nbsp;&nbsp;";
						  $pageNavi.="<a href=\"javascript:\" target='_self'>尾页</a>";
					   }
				
					   //$pageNavi.="<br><br>";
				}
									
		   }
	}
	
	





function check_login()
{
    if(!$_COOKIE['c_uid'])
	{
	    Header("Location: ./login.html");
	    exit;
	}
}


function topgo($url)
	{
	   echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf8\" />";
	   echo "<script language=\"javascript\">\n";
	   echo "parent.window.location='$url';\n";
	   echo "</script>";
	   exit;
	}

	function pop($tit,$text,$url)
	{
		echo "
		<script>
		parent.$('#my-modal-loading').modal('close');
		parent.$('#errortit').html('".$tit."');
		parent.$('#errorcode').html('".$text."');
		parent.$('#my-alert').modal();
		";
		if($url)
		{
		   echo "parent.$('.popsubmit').click(function(){parent.window.location='".$url."'})";
		}
		echo"
		</script>
		";	
		exit;
	}

function add_style($id)
{
    $array = array(
	   'style_no' =>$_POST['style_no'],
	   'style_name'	 =>$_POST['style_name'],
	   'style_s_pic' =>$_POST['style_s_pic'],	
	   'style_mode' =>$_POST['style_mode'],	
	   'style_sort' =>$_POST['style_sort'],	
	   'times' =>$_POST['times'],	
	   'factory' =>$_POST['factory'],	
	   'factory_no' =>$_POST['factory_no'],	
	   'style_brand' =>$_POST['style_brand'],
	   'adduid' =>$_POST['adduid'],	
	   'cls1' =>$_POST['cls1'],	
	   'cls2' =>$_POST['cls2'],	
	   'cls3' =>$_POST['cls3'],
	);
	
	if($id)
	{
	   update($array, $table,'id=$id');
	}
	else
	{
	   $res=insert($array, $table);
	}
}




function ktjg($cz,$jz,$fs,$fsz,$s)
{

   global $g_18;
   global $g_pt;
   if(strstr($cz,'18K')) $cz = '18K';
   if(strstr($cz,'PT950')) $cz = 'PT950';

   if(!$cz) $cz = '18K';

    if($cz == 'PT950')
	{
	     if($s == 'f') $gf = 300;
		 if($s == 'm') $gf = 120;
		 $sh = 1.18;
		 $jg = $g_pt;
		 $bz = 1;
	}
	
	if($cz == '18K')
	{
	     if($s == 'f') $gf = 280;
		 if($s == 'm') $gf = 100;
		 $sh = 1.15;
		 $jg = $g_18;
		 $bz = 1;
	} 
	$$cpjz_t = 0;
	$ls = 3800; //厘石费
	$xsf = 0;
	$lsf = 0;
	if($fs) $xsf = $fs*5;//+镶嵌费
	if($fsz) $lsf = $ls*$fsz;//+厘石费
	$cpjz_t = ($jz*$bz*$sh*$jg) + $gf + $xsf + $lsf; //+工费
	$cpjz_t = floor($cpjz_t);
	return($cpjz_t);
}


?>