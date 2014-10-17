<?php
include("../common/functions.php");
//require("../database/db.class.php");
//require('../imagelibrary/Zebra_Image.php');
//$image_status=0;

$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
//	print_r($_POST);
		$db->query("SELECT id FROM luggage WHERE eticket_id='".mysql_real_escape_string($_POST['eticket_id'])."' AND flight_id='".mysql_real_escape_string($_POST['flight_id'])."'");
		if($db->total()==0)
		{
//			print_r($_POST);
			$max_run = $db->query("SELECT  CONCAT('MAS',LPAD(COALESCE(MAX(SUBSTR(1,3,reciept_no))+1,1),5,'0' ))recieptno FROM `luggage`");
			$max_row = $db->fetch($max_run);
			$reciept_no = $max_row['recieptno'];
			$total_luggage = count($_POST['txt']);
			$luggage = implode('@',$_POST['txt']);
			$total_luggage_weight = $_POST['sum'];
			$payment = $_POST['payment'];
			
			if($db->query("INSERT INTO `luggage` (`id`, `eticket_id`, `luggage`, `extra_payment`, `createdon`, `createdby`, `status`, `flight_id`,passport_no,reciept_no) VALUES (NULL, '".mysql_real_escape_string($_POST['eticket_id'])."', '".$luggage."', '".mysql_real_escape_string($_POST['payment'])."', CURRENT_TIMESTAMP, '".$_SESSION['user_id']."', 'Active', '".mysql_real_escape_string($_POST['flight_id'])."','".$_POST['passportno']."','".$reciept_no."')")){
				$id = base64_encode($db->returnid());
				notify('success','Luggage Added successfully');
			}else{
				notify('fail','Lugggage cannot be registered contact Administrator');	
			}
		}else
		{
			notify('fail','Passport Already exists');	
		}
			$link = $_SESSION['basemodule'].'registeredluggage.php?id='.$id.'&reciept';
		
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['luggageid']))
				{					
						$luggage = implode('@',$_POST['txt']);
						$db->query("UPDATE `luggage` SET  `luggage` =  '".$luggage."',
	`extra_payment` =  '".mysql_real_escape_string($_POST['payment'])."' WHERE  `luggage`.`id` ='".$_POST['luggageid']."'");							
							notify('success', 'Luggage has been Updated sucessfully');
							$id = base64_encode($_REQUEST['luggageid']);
				}else
				{
					notify('fail',"Cannnot be updated contact administrator");	
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");	
					$id = base64_encode($_REQUEST['luggageid']);
					
			}
			$link = $_SESSION['basemodule'].'registeredluggage.php?id='.$id.'&reciept';
			
	break;
	case 'delete':
			if($_SESSION['access_right']!=3)
			{
				if($db->query("DELETE FROM luggage WHERE id='".$_REQUEST['id']."'"))
				{
					notify('success','Luggage Record deleted successfully');
										
				}else
				{
					notify('fail','Luggage Record cannot be deleted successfully');
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
			}				
			$link = $_SESSION['basemodule'].'luggage.php';
			
	break;
	default:
			echo "default";
	break;
}


}else
{
	notify('fail','user cannot able to get registered contant Administrator');	

}
header('Location:'.$link);
?>