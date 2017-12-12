<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    include "../layui/phpExcel/Classes/PHPExcel.php";

    //创建对象一个excel对象
    $objPHPExcel = new PHPExcel();
    $bargain_id = $_GET['id'];
    $sql_bargain = "select id,remark from bargain where id={$bargain_id}  ";
    $data_bargain = fetchAll( $sql_bargain );
    $_name = $data_bargain[0]['remark'];
    $name_bool = isset($_name)?$_name:"123123";
    $name = $name_bool.".xls";
    $sql = "select * from bargain_user where bargain_id={$bargain_id}  order by new_price asc ";
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
        $objSheet->setCellValue("A1","电话号码")->setCellValue("B1","姓名")->setCellValue("C1","原价")->setCellValue("D1","底价")->setCellValue("E1","现价")->setCellValue("F1","砍价时间")->setCellValue("G1","是否付款");
        $j=2;
        $data = is_array($data)?$data:array();
        foreach($data as $k => $v ){
            $objSheet->setCellValue("A".$j,$v['phone_number'])->setCellValue("B".$j,$v['username'])->setCellValue("C".$j,$v['original_price'])->setCellValue("D".$j,$v['floor_price'])->setCellValue("E".$j,$v['new_price'])->setCellValue("F".$j,$v['bargain_time'])->setCellValue("G".$j,$v['pay_status']);
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
        browser_export( 'Excel5',$name );//输出到浏览器
        $objWrite=PHPExcel_IOFactory::createWriter( $objPHPExcel,'Excel5' );//生成excel文件
        $objWrite->save('php://output');
    }

?>

