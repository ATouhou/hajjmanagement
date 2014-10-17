<?php
include("../common/functions.php");
$db= new Database();
$db->query("UPDATE `users` SET `password` = SHA1( '".$_POST['npassword']."' ) WHERE `uid` =".$_SESSION['uid']."");
notify('success','Password has been changed successfully');
header('Location:'.BASEURL.'common/cpasswd.php');



?>