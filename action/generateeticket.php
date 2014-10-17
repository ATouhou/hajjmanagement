<?php
include("../common/functions.php");
$db = new Database();
print_r($_POST);
// CHECK THE EXISTANCE OF THE PILGRIM
$run = $db->query("SELECT pilgrim_id FROM pilgrims WHERE passport_no='".$_POST['passport_no']."' AND agency ='".$_SESSION['agency_id']."' AND  status='Active'");
if($db->total()>0)
{
	$row = $db->fetch($run);
	$pilgrim_id = $row['pilgrim_id'];
	$db->query("SELECT * FROM eticket WHERE pilgrim_id='".$pilgrim_id."' AND eticket.status='Active'");
echo $pilgrim_id;
	if($db->total()==0)
	{
		$eno = rand(100000,999999).rand(100000,999999);
		if($db->query("INSERT INTO `eticket` (`id` ,`eno` ,`pilgrim_id` ,`allocation_id` ,`createdon` ,`status` ,`createdby`)VALUES (NULL , '".$eno."', '".$row['pilgrim_id']."', '".$_POST['allocation_id']."',CURRENT_TIMESTAMP , 'Active', '".$_SESSION['uid']."')"))
		{
			$status ='success';
			$message ='Eticket created successfully';
			$link = 'bookseats.php';	
			
			
		}else
		{
			$status ='fail';
			$message ='Eticket cannot be created. Please try again later';
			$link = 'bookseats.php';	
			
		}
	}else
	{
		$status ='fail';
		$message ='Eticket already exists';
		$link = 'bookseats.php';	
		
	}
	$status ='success';
	$message ='E-ticket Generated';
}else
{
	$status ='fail';
	$message ='Passport No does not exists';
	$link = 'bookseats.php';		
}
notification();

//header('Location:'.$_SESSION['basemodule'].'flights.php?latestid='.$flight_id);
?>