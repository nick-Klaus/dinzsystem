<?php
header('content-type:text/html;charset=utf-8');
require_once 'eby_mysql.php';
require_once 'eby_config.php';
require_once 'eby_fun.php';
session_start();
if(!isset($_SESSION['last_access'])||(time()-$_SESSION['last_access'])>60){
    $_SESSION['last_access'] = time();
}
?>