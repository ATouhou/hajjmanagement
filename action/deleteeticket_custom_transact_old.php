<?php
include("../common/functions.php");
if($_SESSION['access_right']!=3)
{
	if(isset($_REQUEST['id']))
	{
		$flight_no=base64_decode($_REQUEST['id']);
		$db = new Database();
		$date = split('-',$_REQUEST['date']);
		$month = $arr_month[$date[1]];
		$year = substr($date[0],2,2);
		$new_date = $date[2].'-'.$month.'-'.$year;		
		
		$checkdate1 = strtotime(date('Y-m-d'));
		$checkdate2 = strtotime('2013-09-07');
		
		
		if(($checkdate1-$checkdate2)>0){ 
		echo 'i am inside';
			if($_REQUEST['date'] =='')
			{
					echo 'it will get delete';
					$db->query("DELETE FROM custom_eticket WHERE flight_no='".$flight_no."'");
					exit();
			}else{	
					$db->query("DELETE FROM custom_eticket WHERE flight_no='".$flight_no."' AND flight_date='".$new_date."'");
			}		
		} 
	//	exit();
		notify('success',' All the Etickets and Boarding pass of the flight '.$flight_no.' has been deleted');
	}else{
		notify('fail','Flight No does not exists');	
	}
}else
{
	notify('fail',"You do not have privilage to Moidify the record contact administrator");						
}				

header('Location:'.$_SESSION['basemodule'].'flight.php');
?>