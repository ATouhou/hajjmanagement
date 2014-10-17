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
			if($db->query("INSERT INTO `flights` (`flight_id` ,`flight_no` ,`aircraft_id` ,`captainname` ,`date1` ,`date2` ,`time1` ,`time2` ,`source` ,`destination` ,`agency_id` ,`createdby` ,`createdon` ,`status` ,`price` ,`crewnumber` ,`gateno`,aterminal,dterminal)VALUES (NULL, '".mysql_real_escape_string($_POST['flightid'])."', '".mysql_real_escape_string($_POST['model'])."', '".mysql_real_escape_string($_POST['captainname'])."', '".$_POST['date1']."', '".$_POST['date2']."', '".$time1."', '".$time2."', '".mysql_real_escape_string($_POST['source'])."', '".mysql_real_escape_string($_POST['destination'])."', '".$_SESSION['agency_id']."', '".$_SESSION['uid']."',CURRENT_TIMESTAMP , 'Active', '".mysql_real_escape_string($_POST['price'])."', '".mysql_real_escape_string($_POST['crewnumber'])."', '".mysql_real_escape_string($_POST['gateno'])."', '".mysql_real_escape_string($_POST['aterminal'])."', '".mysql_real_escape_string($_POST['dterminal'])."')
	")){
				notify('success','Flight has been registered successfully');
				$flight_id = $db->returnid();
			}else{
				notify('fail','Pilgrim cannot able to get registered contact Administrator');	
				$flight_id='';
			}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['flight_no']))
				{
				$time1 = $_POST['h1'].':'.$_POST['m1'];
				$time2 = $_POST['h2'].':'.$_POST['m2'];		
	
				if($db->query("UPDATE `flights` SET `flight_no` = '".mysql_real_escape_string($_POST['flightid'])."',
	`aircraft_id` = '".mysql_real_escape_string($_POST['model'])."',
	`captainname` = '".mysql_real_escape_string($_POST['captainname'])."',
	`date1` = '".$_POST['date1']."',
	`date2` = '".$_POST['date2']."',
	`time1` = '".$time1."',
	`time2` = '".$time2."',
	`price` = '".mysql_real_escape_string($_POST['price'])."',
	`crewnumber` = '".mysql_real_escape_string($_POST['crewnumber'])."',
	`gateno` = '".mysql_real_escape_string($_POST['gateno'])."',
	`aterminal` = '".mysql_real_escape_string($_POST['aterminal'])."',
	`dterminal` = '".mysql_real_escape_string($_POST['dterminal'])."',
	`source` = '".mysql_real_escape_string($_POST['source'])."',
	`destination` = '".mysql_real_escape_string($_POST['destination'])."' WHERE `flights`.`flight_id` =".$_POST['flight_no']." AND agency_id='".$_SESSION['agency_id']."'")){			
				
					notify('success','Flight has been updated successfully');
					$flight_id = $_POST['flight_no'];				
				}else{
					notify('fail','Flight cannot be updated contact Administrator');	
					$flight_id='';
				}
				}else{
					notify('fail','Flight number does not exists cannot be updated contact Administrator');	
					$flight_id='';
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
					$flight_id='';
			}				
	break;
	default:
			echo "default";
	break;
}
}else
{
	notify('fail','Flight cannot be created contant Administrator');		
}
header('Location:'.$_SESSION['basemodule'].'flights.php?latestid='.$flight_id);
?>