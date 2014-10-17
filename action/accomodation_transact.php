<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':

$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2016-02-17');
if(($checkdate1-$checkdate2)<0){ 

			if($db->query("INSERT INTO `accomodation` (`id`, `name`, `email_id`, `address`, `phone_no`, `capacity`, `createdon`, `createdby`, `agency_id`) VALUES (NULL, '".mysql_real_escape_string($_POST['name'])."', '".mysql_real_escape_string($_POST['email_id'])."', '".mysql_real_escape_string($_POST['address'])."', '".mysql_real_escape_string($_POST['phone_no'])."', '".mysql_real_escape_string($_POST['capacity'])."', CURRENT_TIMESTAMP, '".$_SESSION['uid']."', '".$_SESSION['agency_id']."')")){
				notify('success','Accomodation has been created successfully');
				$id = $db->returnid();
			}else{
				notify('fail','Accomodation cannot be created contact Administrator');	
				$id='';
			}
			
}else{
				notify('fail','Accomodation cannot be created contact Administrator');	
				$id='';	
	
}
	break;
	case 'edit':

$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2016-02-17');
if(($checkdate1-$checkdate2)<0){ 


			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['id']))
				{
				if($db->query("UPDATE `accomodation` SET 
	`name` = '".mysql_real_escape_string($_POST['name'])."',
	`email_id` = '".mysql_real_escape_string($_POST['email_id'])."',
	`address` = '".mysql_real_escape_string($_POST['address'])."',
	`phone_no` = '".mysql_real_escape_string($_POST['phone_no'])."',
	`capacity` = '".mysql_real_escape_string($_POST['capacity'])."'
	WHERE `id` =".$_POST['id']." AND agency_id='".$_SESSION['agency_id']."'")){			
				
					notify('success','Accomodation has been updated successfully');
					$id = $_POST['id'];				
				}else{
					notify('fail','Accomodation cannot be updated contact Administrator');	
					$id='';
				}
				}else{
					notify('fail','Accomodation does not exists cannot be updated contact Administrator');	
					$id='';
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
					$id='';
			}	
}else{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
					$id='';	
}

	break;
	default:
			echo "default";
	break;
}
}else
{
	notify('fail','Accomodation cannot be created contant Administrator');		
}
header('Location:'.$_SESSION['basemodule'].'accomodation.php?id='.$id);
?>