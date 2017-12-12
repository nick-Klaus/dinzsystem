<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];

if( $_POST['image_all'] == 'banner' ){
    $image_logo = json_encode(explode(",",$_POST['image_logo']));
}else{
    $image_logo = $_POST['image_logo'];
}

$array = array(
	'image_logo' => $image_logo,
	'title' => trim($_POST['title']),
    'subtitle' => $_POST['subtitle'],
	'original_price' => $_POST['original_price'],
	'floor_price' => $_POST['floor_price'],
	'bargain_times' => $_POST['bargain_times'],
	'min_sale' => $_POST['min_sale'],
	'max_sale' => $_POST['max_sale'],
    'contact_img' => $_POST['contact_img'],
	'new_gift_quantity' => $_POST['new_gift_quantity'],
	'gift_quantity' => $_POST['gift_quantity'],
	'company_introduction' => trim($_POST['company_introduction']),
	'gift_describe_txt' => trim($_POST['gift_describe_txt']),
	'activity_rules' => trim($_POST['activity_rules']),
	'award_information' => trim($_POST['award_information']),
	'gift_describe' =>json_encode(explode(",",$_POST['gift_describe'])),
	'company_introduction_img' =>json_encode(explode(",",$_POST['company_introduction_img'])),
	'phone_number' => $_POST['phone_number'],
	'pay_deposit' => $_POST['pay_deposit'],
	'start_time' => date("Y/m/d H:i:s",strtotime( $_POST['start_time'] )),
	'end_time' => date("Y/m/d H:i:s",strtotime( $_POST['end_time'] )),
	'remark' => $_POST['remark']
);

$sqluser = "select * from bargain where id='$id'";
$res = fetchOne( $sqluser );

$sql_user = "select * from bargain_user where bargain_id='$id'";
$res_user = fetchAll( $sql_user );

if( $res['floor_price'] != $array['floor_price'] && $res['original_price'] != $array['original_price'] ){
			foreach ($res_user as $k => $v) {
				if( $v['new_price'] >  $array['original_price'] ){
					$arr = array(
						"original_price" => $array['original_price'],
						"floor_price" => $array['floor_price'],
						"new_price" => $array['original_price']
					);
				}else{
					$arr = array(
						"original_price" => $array['original_price'],
						"floor_price" => $array['floor_price']
					);
				}
				update($arr,'bargain_user',"bargain_id='$id'");
			}

		}elseif( $res['floor_price'] != $array['floor_price'] && $res['original_price'] == $array['original_price']){
			$arr = array(
				"floor_price" => $array['floor_price']
			);
			update($arr,'bargain_user',"bargain_id='$id'");
		// 改原价 	
		}elseif( $res['original_price'] != $array['original_price'] ){
			foreach ($res_user as $k => $v) {
				if( $v['new_price'] >  $array['original_price'] ){
					$arr = array(
						"original_price" => $array['original_price'],
						"new_price" => $array['original_price']
					);
				}else{
					$arr = array(
						"original_price" => $array['original_price'],
					);
				}
				update($arr,'bargain_user',"bargain_id='$id'");
			}
		
		}

if( $id ){ 
	if( update($array,'bargain','id='.$id) ){
		echo "go";
	}
 }


?>