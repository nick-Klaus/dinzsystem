<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

//ajax传来需要修改的倍率 
$clsid1 = $_POST['clsid'];
$uid1 = $_POST['uid'];
$zk1 = $_POST['zk'];
$where = " clsid='" . $clsid1 . "'  and  uid='" . $uid1 . "'";
$sql = "select * from  e_member_zk where " . $where;
$res = fetchOne($sql);

if ($res) {
    if (update(array("zk" => $zk1), 'e_member_zk', $where) > 0) {
        echo "go";
        // 修改倍率日志
        $array_log = array(
            'macid' => $uid1,
            'pageid' => $clsid1,
            'ip' => $_SERVER["REMOTE_ADDR"],
            'addtime' => time(),
            'post' => $res['zk'] . "-->" . $zk1
        );
        insert($array_log, 'e_mac_log');
    }
} else {
    //如果倍率不存在则新建一个
    $array = array(
        "clsid" => $clsid1,
        "uid" => $uid1,
        "zk" => $zk1,
    );
    if (insert($array, 'e_member_zk') > 0) {
        echo "go";
    }
}


?>