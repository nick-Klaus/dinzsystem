<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$apicode = $_GET['apicode'];
$uid = $_GET['uid'];
if( !$uid ){
    echo 'uid不存在！';
    exit;
}
$sql_member = "select * from e_members  where uid='$uid'";
$rs = fetchOne($sql_member);
$_domain = $rs['domain'];
$new_domain = substr($_domain, 2);
$new_domain = $new_domain?','.$new_domain:'';
$datatype = $rs['datatype'];

/**
 * Created by Administrator on 2017/11/21.
 * 款式分类的获取
 * http://master.echao.com/inc/partner_api.php?&apicode=GetGoodsCategory&uid=1
 */
if ($apicode == 'GetGoodsCategory') {
    header("Access-Control-Allow-Origin:*");
    $data = fetchAll("select id,catename,webid,pid,adduid,box_default_ico from e_goods_category  where  adduid=".$uid);
    echo json_encode($data);
    exit;
}

/**
 * Created by Administrator on 2017/11/21.
 * 成品款式的获取
 * http://master.echao.com/inc/partner_api.php?&apicode=GetGoodsStyle&cls1=&cls2=&style_no=&uid=50&fnum=2&num=0
 */
if ($apicode == 'GetGoodsStyle') {
    header("Access-Control-Allow-Origin:*");
    $cls1 = intval($_GET['cls1']);
    $cls2 = intval($_GET['cls2']);
    $style_no = trim($_GET['style_no']);
    $fnum = intval($_GET['fnum']); // 每页显示条数
    $num = intval($_GET['num']);// 起始页
    if($cls1){
        $sqlwhere.=" and cls1='$cls1' ";
    }
    if($cls2){
        $sqlwhere.=" and cls2='$cls2' ";
    }
    if($style_no){
        $sqlwhere.=" and (style_no like '$style_no%' or factory_no like '$style_no%') and displays = 0 ";
    }
    $sqlwhere.= "  and ( style_mode=0 or style_mode=2 ) order by style_new desc,id desc";
    // 0系统数据 1全部数据 2出系统外的 3自有数据
    if ($datatype == 0) {
        $sql = "select * from e_goods_sylte where displays = 0 and qdz_type=0 and adduid=1 " . $sqlwhere;
    } elseif ($datatype == 1) {
        $sql = "select * from e_goods_sylte where displays = 0 and qdz_type=0 and  adduid in($_domain$uid)  " . $sqlwhere;
    } elseif ($datatype == 2) {
        $sql = "select * from e_goods_sylte where displays = 0 and qdz_type=0 and adduid in($uid$new_domain) " . $sqlwhere;
    }else{
        $sql = "select * from e_goods_sylte where displays = 0 and qdz_type=0 and adduid='$uid' " . $sqlwhere;
    }
    $totle = getTotalRows($sql); // 总共多少数据
    $pagenum = ceil(intval($totle) / $fnum); // 总共多少页
    $sql.= " limit ".$num.",".$fnum;
    $data = fetchAll($sql);

    for ($i = 0; $i < count($data); $i++) {
        $data[$i]['MinPrice'] = round($data[$i]['MinPrice'] * show_zk($uid, 'p' . $data[$i]['cls2'], $_domain));
        $data[$i]['MaxPrice'] = round($data[$i]['MaxPrice'] * show_zk($uid, 'p' . $data[$i]['cls2'], $_domain));
        $data[$i]['price_18K'] = round($data[$i]['price_18K'] * show_zk($uid, 'p' . $data[$i]['cls2'], $_domain));
        $data[$i]['price_pt'] = round($data[$i]['price_pt'] * show_zk($uid, 'p' . $data[$i]['cls2'], $_domain));
    }
    $arr = array(
        "data" => $data,
        "page" => array(
            "totle" => $totle,
            "pagenum" => $pagenum,
            "num" => $num,
            "fnum" => $fnum
        )
    );
    //@file_put_contents(dirname(__FILE__).'/logs.txt', json_encode([$_GET,$_POST]) );
    echo json_encode($arr);
    exit;
}