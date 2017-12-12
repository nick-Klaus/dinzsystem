<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

    unset($_SESSION['uid']);
    header("Location:http://master.echao.com/login.php");
    exit;

?>