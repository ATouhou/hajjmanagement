<?php
include("../common/functions.php");
$db = new Database();

	if($db->query("UPDATE boardingpass SET bconfirmation='Yes' WHERE bno='".$_REQUEST['bno']."'")){
			notify('success','Passenger is confirmed successfully');			
	}else{
			notify('fail','Cannot able to confirm passenger');	
	}
header('Location:'.$_SESSION['basemodule'].'bconfirmation.php');
?>