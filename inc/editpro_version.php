<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$id = $_POST['id'];
$arr = array(
    'version_name' => $_POST['version_name'],
    'version_folder' => $_POST['version_folder'],
    'addtime' => time()
);

    if( update($arr,'soft_version_name','id='.$id) > 0 ){
        echo 'go';
    }

?>