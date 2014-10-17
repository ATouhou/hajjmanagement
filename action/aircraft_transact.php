<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT aircraft_id FROM aircraft WHERE model='".mysql_real_escape_string($_POST['model'])."'");
		if($db->total()==0)
		{
			if($db->query("INSERT INTO `aircraft` (`aircraft_id` ,`agency_id` ,`manufacturer` ,`model` ,`nor` ,`noc` ,`seats` ,`status`)VALUES (NULL , '".$_SESSION['agency_id']."', '".mysql_real_escape_string($_POST['manufacturer'])."', '".mysql_real_escape_string($_POST['model'])."', '".mysql_real_escape_string($_POST['nor'])."', '".mysql_real_escape_string($_POST['noc'])."', NULL , 'Active');")){
				notify('success','Aircraft has been created successfully');
				$aircraft_id = $db->returnid();
				$link = 'aircraftseatallocation.php?latestid='.$aircraft_id;
				
			}else{
				notify('fail','Aircraft not created contact Administrator');	
				$aircraft_id='';
				$link = 'aircraft.php';
			}
		}else
		{
			notify('fail','Aircraft Already exists');	
			$aircraft_id='';		
			$link = 'aircraft.php';			
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
				if(isset($_POST['aircraft_id']))
				{
					$db->query("SELECT * FROM aircraft WHERE model = '".mysql_real_escape_string(trim($_POST['model']))."' AND aircraft_id !=('".$_POST['aircraft_id']."')");	
					if($db->total()==0)
					{
							$db->query("UPDATE `aircraft` SET `model` = '".mysql_real_escape_string(trim($_POST['model']))."',`manufacturer` = '".mysql_real_escape_string(trim($_POST['manufacturer']))."',`nor` = '".mysql_real_escape_string(trim($_POST['nor']))."',`noc` = '".mysql_real_escape_string(trim($_POST['noc']))."' WHERE `aircraft_id` = '".$_POST['aircraft_id']."' ");
								
							notify('success', 'Aircraft has been Updated sucessfully');
							$link = 'aircraft.php';					
							
					}else
					{
						notify('fail','aircraft Already exists');
						$link = 'aircraft.php';					
					}
				}else
				{
					notify('fail',"Cannnot be updated contact administrator");	
					$link = 'aircraft.php';
				}
			}else
			{
					notify('fail',"You do not have privilage to Moidify the record contact administrator");						
					$link = 'aircraft.php';
			}				
	break;
	default:
			echo "default";
	break;
}


}else
{
	notify('fail','Aircraft cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].$link);
?>