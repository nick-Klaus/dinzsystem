<?php
include "./../fun/eby_admin_api.php";
include "./../fun/phpfile.php";

$delid = $_POST['delid'];

if( $delid ){
	if( delete('soft_version_name','id='.$delid) ){
	    echo "go";
	}
}

?>