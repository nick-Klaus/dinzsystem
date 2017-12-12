<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";
    $delid = intval($_POST['delid']);
    $uid = $_SESSION['uid'];
    $array = array(
        "displays"=>1
    );
    if( $delid ){
        if (update($array, 'e_unified_sylte_new', 'id=' . $delid) > 0) {
            echo 'go';
            exit;
        }else{
            echo $delid;
        }
    }
?>