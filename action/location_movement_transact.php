<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT location_id FROM movement_location WHERE location_name='".mysql_real_escape_string($_POST['location_name'])."'");
		if($db->total()==0)
		{
			print_r($_POST);
			if($db->query("INSERT INTO `movement_location` (`location_id` ,`location_name` ,`status` ,`agency_id`)VALUES (NULL , '".mysql_real_escape_string($_POST['location_name'])."', 'Active', '".$_SESSION['agency_id']."')")){
				notify('success','Location has been created successfully');
				exit();
			}else{
				notify('fail','Location not created contact Administrator');	
				$pilgrim_id='';
			}
		}else
		{
			notify('fail','Location Already exists');	
			$pilgrim_id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['location_id']))
				{
					$db->query("SELECT * FROM movement_location WHERE location_name = '".mysql_real_escape_string(trim($_POST['location_name']))."' AND location_id !=('".$_POST['location_id']."')");	
					if($db->total()==0)
					{
						$db->query("UPDATE `movement_location` SET `location_name` = '".mysql_real_escape_string(trim($_POST['location_name']))."' WHERE `location_id` = '".$_POST['location_id']."' ");							
							notify('success', 'Location has been Updated sucessfully');					
					}else
					{
						notify('fail','Location Already exists');
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


}else
{
	notify('fail','Location cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'locations.php?latestid='.$pilgrim_id);
?>