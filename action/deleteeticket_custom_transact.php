<?php
include("../common/functions.php");
//echo 'hello';
//echo $_SESSION['access_right'];
if($_SESSION['access_right']!=3)
{
	if(isset($_REQUEST['id']))
	{
		$flight_no=base64_decode($_REQUEST['id']);
		$db = new Database();
		if($_REQUEST['date']!='')
		{
			$date = split('-',$_REQUEST['date']);
			echo $date;
			$month = $arr_month[$date[1]];
			if(count($date[0])==2)
			{
				$year = '20'.$date[0];
			}else{
				$year =$date[0];
			}
//				$year = substr($date[0],2,2);
//			echo 'The year is '.$year;
			
			$new_date = $date[2].'-'.$month.'-'.$year;		
//			echo 'the new date is '.$new_date;
			
		}
		$checkdate1 = strtotime(date('Y-m-d'));
		$checkdate2 = strtotime('2016-09-07');
		if(($checkdate1-$checkdate2)<0){ 
			if($_REQUEST['date']=='')
			{
					$db->query("DELETE FROM custom_eticket WHERE flight_no='".$flight_no."'");
					echo "DELETE FROM custom_eticket WHERE flight_no='".$flight_no."'";
					
					
			}else{	
					$db->query("DELETE FROM custom_eticket WHERE flight_no='".$flight_no."' AND flight_date='".$new_date."'");
					echo "DELETE FROM custom_eticket WHERE flight_no='".$flight_no."' AND flight_date='".$new_date."'";
			}	
		} 
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