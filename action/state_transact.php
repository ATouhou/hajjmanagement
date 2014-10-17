<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT state_id FROM state WHERE state_name='".mysql_real_escape_string($_POST['state_name'])."'");
		if($db->total()==0)
		{
			if($db->query("INSERT INTO `state` (`state_id` ,`state_name` ,`status`)VALUES (NULL , '".mysql_real_escape_string($_POST['state_name'])."', 'Active')")){
				notify('success','State has been created successfully');
				
			}else{
				notify('fail','State not created contact Administrator');	
				$state_id='';
			}
		}else
		{
			notify('fail','State Already exists');	
			$pilgrim_id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['state_id']))
				{
					$db->query("SELECT * FROM state WHERE state_name = '".mysql_real_escape_string(trim($_POST['state_name']))."' AND state_id !=('".$_POST['state_id']."')");	
					if($db->total()==0)
					{								
						$db->query("UPDATE `state` SET `state_name` = '".mysql_real_escape_string(trim($_POST['state_name']))."' WHERE `state_id` = '".$_POST['state_id']."' ");
								
							notify('success', 'state has been Updated sucessfully');						
					}else
					{
						notify('fail','state Already exists');
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
	notify('fail','State cannot be created, contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'state.php');
?>