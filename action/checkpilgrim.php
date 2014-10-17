<?php
include("../common/functions.php");
$db = new Database();
// CHECK THE EXISTANCE OF THE PILGRIM
$run = $db->query("SELECT pilgrim_id FROM pilgrims WHERE passport_no='".$_POST['passport_no']."' AND state ='".$_SESSION['agency_id']."' AND  status='Active'");
if($db->total()>0)
{
	$row = $db->fetch($run);
	$pilgrim_id = $row['pilgrim_id'];
	$db->query("SELECT * FROM eticket WHERE pilgrim_id='".$pilgrim_id."' AND eticket.status='Active'");
echo $pilgrim_id;
	if($db->total()==0)
	{
		$status='success';
		$message = 'Passport Verified';
		$link = 'book_step1.php';

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

//echo $status;
//echo $message;
notification();





//header('Location:'.$_SESSION['basemodule'].'flights.php?latestid='.$flight_id);
?>