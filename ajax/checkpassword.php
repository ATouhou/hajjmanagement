<?php
include("../common/functions.php");

$db = new Database();
$db->query("SELECT * FROM users WHERE uid='".$_SESSION['uid']."' AND password =SHA1('".$_REQUEST['value']."')");
if($db->total()>0)
{
	echo '1';
}else
{
	echo '0';
}




?>