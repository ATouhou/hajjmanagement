<?php
include("../common/functions.php");
$db = new Database();
if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT * FROM aircraft WHERE aircraft_id='".mysql_real_escape_string($_POST['aircraft_id'])."'");
		if($db->total()>0)
		{
			$seat = implode(',',$_POST['seats']);			
			
			if($db->query("UPDATE `aircraft` SET seats = '".$seat."' WHERE aircraft_id='".$_POST['aircraft_id']."'")){
				notify('success','Aircraft has been created successfully');
			}else{
				notify('fail','Aircraft not created contact Administrator');	
			}
		}else
		{
			notify('fail','Aircraft Already exists');	
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
	
				if(isset($_POST['aircraft_id']))
				{
					$db->query("SELECT * FROM carriers_aircraft WHERE aircraft_name = '".mysql_real_escape_string(trim($_POST['aircraft_name']))."' AND aircraft_id !=('".$_POST['aircraft_id']."')");	
					if($db->total()==0)
					{
						$db->query("UPDATE `carriers_aircraft` SET `aircraft_name` = '".mysql_real_escape_string(trim($_POST['aircraft_name']))."' WHERE `aircraft_id` = '".$_POST['aircraft_id']."' ");
							notify('success', 'aircraft has been Updated sucessfully');
					}else
					{
						notify('fail','aircraft Already exists');
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
	notify('fail','Aircraft cannot able to get registered contant Administrator');	
}

header('Location:'.$_SESSION['basemodule'].'aircraft.php');
?>