<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT center_id FROM movement_center WHERE center_name='".mysql_real_escape_string($_POST['center_name'])."'");
		if($db->total()==0)
		{
	//		print_r($_POST);
			if($db->query("INSERT INTO `movement_center` (`center_id` ,`center_name` ,`status` ,`agency_id`)VALUES (NULL , '".mysql_real_escape_string($_POST['center_name'])."', 'Active', '".$_SESSION['agency_id']."')")){
				notify('success','Center has been created successfully');
	//			exit();
			}else{
				notify('fail','Center not created contact Administrator');	
				$pilgrim_id='';
			}
		}else
		{
			notify('fail','Center Already exists');	
			$pilgrim_id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['center_id']))
				{
					$db->query("SELECT * FROM movement_center WHERE center_name = '".mysql_real_escape_string(trim($_POST['center_name']))."' AND center_id !=('".$_POST['center_id']."')");	
					if($db->total()==0)
					{
						$db->query("UPDATE `movement_center` SET `center_name` = '".mysql_real_escape_string(trim($_POST['center_name']))."' WHERE `center_id` = '".$_POST['center_id']."' ");							
							notify('success', 'Center has been Updated sucessfully');					
					}else
					{
						notify('fail','Center Already exists');
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
	notify('fail','center cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'center.php?latestid='.$pilgrim_id);
?>