<?php
include("../common/functions.php");
//require("../database/db.class.php");
require('../imagelibrary/Zebra_Image.php');
$image_status=0;

$db = new Database();
// $_SERVER['HTTP_REFERER'];
//exit();
if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		
$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2016-02-17');
if(($checkdate1-$checkdate2)<0){ 

		$db->query("SELECT manifest_id FROM vehicle_manifest WHERE vehicle_id='".mysql_real_escape_string($_POST['vehicle_id'])."' AND pilgrim_id='".mysql_real_escape_string($_POST['pilgrim_id'])."'");
		if($db->total()==0)
		{
			$db->query("SELECT manifest_id FROM vehicle_manifest WHERE vehicle_id='".$_POST['vehicle_id']."'");
			$total = $db->total();
			$num = $_POST['capacity'] - $total;
			if($num>0){
			
			
			if($db->query("INSERT INTO `vehicle_manifest` (`manifest_id`, `vehicle_id`, `pilgrim_id`, `created_on`, `createdby`, `agency_id`) VALUES (NULL, '".$_POST['vehicle_id']."', '".$_POST['pilgrim_id']."', CURRENT_TIMESTAMP, '".$_SESSION['uid']."', '".$_SESSION['agency_id']."')"))
			{				
				notify('success','Pilgrim has been registered successfully');
				$manifest_id = $db->returnid();
	
				
			}else{
				notify('fail','Pilgrim cannot able to get registered contact Administrator');	
				$manifest_id=0;
			}
			}else{
				notify('fail','No seats Available');	
				$manifest_id=0;				
			}
		}else
		{
			notify('fail','Pilgrim Already Register');	
			$manifest_id=0;
			
		}
		
}else{
			notify('fail','Pilgrim Already Register');	
			$manifest_id=0;
	
}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{	
				if(isset($_POST['maninfest_id']))
				{
					$db->query("SELECT * FROM agency WHERE agency_name = '".mysql_real_escape_string(trim($_POST['agency_name']))."' AND agency_id !=('".$_POST['agency_id']."')");	
					if($db->total()==0)
					{
	
								
						$db->query("UPDATE `agency` SET `agency_name` = '".mysql_real_escape_string(trim($_POST['agency_name']))."',
	`agency_adminname` = '".mysql_real_escape_string(trim($_POST['admin_name']))."',
	`agency_address` = '".mysql_real_escape_string(trim($_POST['address']))."',
	`agency_phoneno` = '".mysql_real_escape_string(trim($_POST['mno']))."',
	`agency_url` = '".mysql_real_escape_string(trim($_POST['url']))."'
	 WHERE `agency_id` = '".$_POST['agency_id']."' ");
							notify('success', 'Agency has been Updated sucessfully');
							$agency_id = $_POST['agency_id'];
							$image_status = 1;
					}else
					{
						notify('fail','Agency Already exists');
					}
				}else
				{
					notify('fail',"Cannnot be updated contact administrator");	
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
			}							
	break;
	default:
			echo "default";
	break;
}



/*********** END OF SCRIPT TO UPLOAD IMAGES********/

}else
{
	notify('fail','Manifest cannot able to get registered contant Administrator');	

}
header('Location:'.$_SERVER['HTTP_REFERER']);
?>