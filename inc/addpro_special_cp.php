<?php
    include "./../fun/eby_admin_api.php";
    include "./../fun/phpfile.php";

    $ztid = $_POST[ 'ztid' ];
    $adduid = $_POST[ 'adduid' ];
    $style_no = trim ( $_POST[ 'style_no' ] );
    $times = time ();
    if ( $style_no ) {
        $sql = "select id from e_goods_sylte where style_no='$style_no'";
        //echo $sql;
        $rs = fetchAll ( $sql );
        //print_r($rs);
        if ( $rs ) {
            $sql = "select id from e_user_zt_goods where ztid='$ztid' and style_no='$style_no'";
            $rs = fetchAll ( $sql );
            if ( ! $rs ) {
                $row = mysql_query ( "insert into e_user_zt_goods (ztid,style_no,adduid,times) values ('$ztid','$style_no','$adduid','$times')" );
                if ( $row ) {
                    echo "go";
                }
            }
        }
    }


?>