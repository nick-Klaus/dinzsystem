<?PHP
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






function show_zk($memberid,$clsid,$domain)
{
    
	   //if($uid!=1) $domain = trim(str_replace('1,','',$domain));
	   
	   if($domain) $uidlist = $domain.$memberid;
	   $zk_othen_num = 1;
	   $sql_zk_othen = "select zk from e_member_zk_othen where uid='$memberid' and clsid='$clsid' order by id desc limit 0,1";
	   //echo $sql_zk_othen;
	   $zk_othen = fetchAll($sql_zk_othen);
	   if($zk_othen)
	   {
	      $uidlist = 1; 
		  $zk_othen_num = $zk_othen[0]['zk']/100;
	   }

	
	//echo 'PATH:'.$uidlist.'<br/>';
	
    if(!$domain)
	{
	     
		// echo $uidlist;
		 
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


function zszk($size,$uid,$domain)
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

	 return(show_zk($uid,$clsid,$domain));
	
}

	
?>