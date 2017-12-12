<?php
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






$sql = "select zk,clsid from e_member_zk where uid in ($cook_admin_domain$cook_admin_uid)";
$rs = fetchAll($sql);
for($i=0;$i<count($rs);$i++)
{
   $zk[$rs[$i][1]][] = $rs[$i][0];
}
?>