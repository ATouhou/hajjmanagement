<?php
include("../common/functions.php");
$db = new Database();
if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
			$time1 = $_POST['h1'].':'.$_POST['m1'];
			$time2 = $_POST['h2'].':'.$_POST['m2'];

			if($db->query("INSERT INTO `vehicle` (`vehicle_id`, `vehicle_no`, `vehicle_type`, `source`, `destination`, `createdon`, `status`, `createdby`, `agency_id`,departure_date,arrival_date,capacity,center_id,dtime,atime) VALUES (NULL, '".mysql_real_escape_string($_POST['vehicle_no'])."', '".mysql_real_escape_string($_POST['vehicle_type'])."', '".mysql_real_escape_string($_POST['source'])."', '".mysql_real_escape_string($_POST['destination'])."', CURRENT_TIMESTAMP, 'Active', '".$_SESSION['uid']."', '".$_SESSION['agency_id']."','".$_POST['departure_date']."','".$_POST['arrival_date']."',".$_POST['capacity'].",".$_POST['center'].",'".$time1."','".$time2."')")){
				notify('success','Vehicle has been registered successfully');
				$vehicle_id = $db->returnid();
			}else{
				notify('fail','Vehicle cannot able to get registered contact Administrator');	
				$vehicle_id='';
			}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['vehicle_id']))
				{
	
				$time1 = $_POST['h1'].':'.$_POST['m1'];
				$time2 = $_POST['h2'].':'.$_POST['m2'];
				if($db->query("UPDATE `vehicle` SET `vehicle_no` = '".mysql_real_escape_string($_POST['vehicle_no'])."',
	`vehicle_type` = '".mysql_real_escape_string($_POST['vehicle_type'])."',
	`source` = '".mysql_real_escape_string($_POST['source'])."',
	`destination` = '".mysql_real_escape_string($_POST['destination'])."',
	`departure_date` = '".$_POST['departure_date']."',
	`arrival_date` = '".$_POST['arrival_date']."',
	`capacity` = '".$_POST['capacity']."',
	`center_id` = '".$_POST['center']."',
	`dtime` = '".$time1."',
	`atime` = '".$time2."'
	 WHERE `vehicle_id` =".$_POST['vehicle_id']." AND agency_id='".$_SESSION['agency_id']."'")){			
				
					notify('success','Vehicle has been updated successfully');
					$vehicle_id = $_POST['vehicle_id'];				
				}else{
					notify('fail','Flight cannot be updated contact Administrator');	
					$vehicle_id='';
				}
				}else{
					notify('fail','Flight number does not exists cannot be updated contact Administrator');	
					$vehicle_id='';
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
					$vehicle_id='';
			}				
	break;
	default:
			echo "default";
	break;
}
}else
{
	notify('fail','Vehicle cannot be created contant Administrator');		
}
header('Location:'.$_SESSION['basemodule'].'vehicle.php?id='.$vehicle_id);
?>