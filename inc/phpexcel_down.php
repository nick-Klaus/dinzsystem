<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";
include "../layui/phpExcel/Classes/PHPExcel.php";

//创建对象一个excel对象
$objPHPExcel = new PHPExcel();
$c_uid = $_SESSION['uid'];
$c_domain = $_SESSION['ch_domain'];
$sql = "select a.*,b.username,b.nickname,b.mobile_phone  from e_order a,e_fx_members b where (a.uid in (select c.uid from e_members c where c.domain like '$c_domain$c_uid,%') or a.uid='$c_uid') and  a.fxuid =b.uid ";
//搜索下单人
$username = trim($_GET['username']);
if( $username ){
  $sql.= " and  b.username='$username'";
  $page_get.="&a=".$a."&cls1=".$cls1."&cls2=".$cls2."&cls3=".$cls3."&username=".$username;
}else{
  $page_get.="&a=".$a;
}

$sql.= " order by a.id desc";
$data = fetchAll( $sql );
if( !is_array($data) ){
  $url = $_SERVER['HTTP_REFERER'];
  header("location:$url");
  exit;
}

for($i=1;$i<=3;$i++){

  if( $i>1 ){
    $objPHPExcel->createSheet();//创建新的内置表
  }
  $objPHPExcel->setActiveSheetIndex($i-1);
  $objSheet=$objPHPExcel->getActiveSheet();
  $objSheet->setCellValue("A1","状态")->setCellValue("B1","订单号")->setCellValue("C1","金额")->setCellValue("D1","下单时间")->setCellValue("E1","下单会员")->setCellValue("F1","联系人")->setCellValue("G1","联系电话");
  $j=2;
  $data = is_array($data)?$data:array();
  foreach($data as $k => $v ){
    switch ($v['pay_id']) {
      case '0':
        $pay_id="待处理";
      break;
      case '1':
        $pay_id="已经确认";
      break;
      case '2':
        $pay_id="确认付款";
      break;
      case '3':
        $pay_id="确认发货";
      break;
      case '4':
        $pay_id="确认收货";
      break;  
      case '5':
        $pay_id="订单完成";
      break; 
      default:
        $pay_id="订单取消";
        break;       
    }
    
    $objSheet->setCellValue("A".$j,$pay_id)->setCellValue("B".$j,$v['order_no'])->setCellValue("C".$j,$v['rmb'])->setCellValue("D".$j,date("Y-m-d H:i:s", $v['times']))->setCellValue("E".$j,$v['username'])->setCellValue("F".$j,$v['nickname'])->setCellValue("G".$j,$v['mobile_phone']);
  $j++;
  }

  function browser_export( $type,$filename ){
    if( $type == "Excel5" ){
      header('Content-Type: application/vnd.ms-excel');//告诉浏览器将要输出browser_excel0.xls文件
    }else{
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }     
    header('Content-Disposition: attachment;filename="'.$filename.'"');//告诉浏览器输出的文件的名称
    header('Cache-Control: max-age=0');//禁止缓存

  }
  browser_export( 'Excel5','browser_excel0.xls' );//输出到浏览器
  $objWrite=PHPExcel_IOFactory::createWriter( $objPHPExcel,'Excel5' );//生成excel文件
  $objWrite->save('php://output');

}


?>

