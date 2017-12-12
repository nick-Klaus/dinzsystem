<?php
header('content-type:text/javascript;charset=utf-8');
require_once 'eby_mysql.php';
define('DB_HOST', 'localhost');
define('DB_USER', 'admintest');
define('DB_PWD', 'admintest');
define('DB_CHARSET', 'UTF8');
define('DB_DBNAME', 't_diamondsystem');

$imageserver = "http://imageserver.echao.com/";

if ( !ini_get('register_globals') )
{
    extract($_POST);
    extract($_GET);
    extract($_SERVER);
    extract($_FILES);
    extract($_ENV);
    extract($_COOKIE);
    
    if ( isset($_SESSION) )
    {
        extract($_SESSION);
    }
}

$db=connect2();
require_once 'webapp.fun.php';
$ip = getIP();
$times = time();
?>