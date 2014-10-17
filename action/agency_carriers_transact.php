<?php
include("../common/functions.php");
$db = new Database();
//print_r($_SESSION);
//print_r($_POST);
if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
			$seat = implode(',',$_POST['seats']);	
			$run = $db->query("SELECT allocation_id,seats,seat_allocated FROM agency_seat_allocation WHERE flight_id='".$_SESSION['flight_id']."' AND agency_id='".$_SESSION['agency']."' AND carrier_id='".$_SESSION['agency_id']."'");
			if($db->total()>0)
			{	$row = $db->fetch($run);
				print_r($row);
				$allocation_id = $row['allocation_id'];
				$totalseats = $row['seats'].','.$seat;
				$total_seat_allocated = $row['seat_allocated']+$_POST['seats_count'];			
				$db->query("UPDATE agency_seat_allocation SET seats= '".$totalseats."', seat_allocated='".$total_seat_allocated."' WHERE allocation_id='".$allocation_id."'");
				notify('success','Seats has been Allocated successfully');
			}else
			{
			
				if($db->query("INSERT INTO `agency_seat_allocation` (`allocation_id` ,`flight_id` ,`agency_id` ,`carrier_id` ,`seat_allocated` ,`seats` ,`createdby` ,`createdon` ,`status`,seats_no_alloted,seat_left)VALUES (NULL , '".$_SESSION['flight_id']."', '".$_SESSION['agency']."', '".$_SESSION['agency_id']."', '".$_POST['seats_count']."', '".$seat."', '".$_SESSION['uid']."',CURRENT_TIMESTAMP , 'Active','','0')")){
					notify('success','Seats has been Allocated successfully');
					
				}else{
					notify('fail','Seats cannot be allocated contanct Administrator');	
					$pilgrim_id='';
				}
			
			}
			$link = $_SESSION['basemodule'].'agency.php';
	break;
	case 'remove':
			if($_SESSION['access_right']!=3)
			{
				$seat_no_allocated = array();
				$run = $db->query("SELECT * FROM agency_seat_allocation WHERE allocation_id ='".$_REQUEST['allocation_id']."'");
				$row = $db->fetch($run);
				$seats_remaining = $row['seat_allocated']- $_REQUEST['seats'];
				$seat_no = explode(',',$row['seats']);
				$seat_no_allocated = explode(',',$row['seats_no_alloted']);
				
				$remaining_seats = implode(',',array_diff($seat_no,array_slice(array_diff($seat_no,$seat_no_allocated),0,$_POST['seats'])));
				if($db->query("UPDATE agency_seat_allocation SET seats='".$remaining_seats."',seat_allocated='".$seats_remaining."' WHERE allocation_id='".$_REQUEST['allocation_id']."'"))
				{
					notify('success', 'Seats has been Updated sucessfully');
				}else
				{
					notify('fail','Seats cannot be modified');
				}
				
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
			}	
			
			$link = $_SESSION['basemodule'].'editseatallocation.php?id='.$_REQUEST['allocation_id'].'&flightid='.$_REQUEST['flightid'].'';
	break;
	default:
			echo "default";
	break;
}


}else
{
	notify('fail','Location cannot able to get registered contant Administrator');	

}

//notificaton();
header('Location:'.$link);
?>