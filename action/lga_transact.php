<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT lga_id FROM lga WHERE lga_name='".mysql_real_escape_string($_POST['lga_name'])."'");
		if($db->total()==0)
		{
			if($db->query("INSERT INTO `lga` (`lga_id` ,`lga_name` ,`state_id`,status)VALUES (NULL , '".mysql_real_escape_string($_POST['lga_name'])."' , '".mysql_real_escape_string($_POST['state'])."', 'Active')")){
				notify('success','Lga has been created successfully');
				
			}else{
				notify('fail','Lga not created contact Administrator');	
				$state_id='';
			}
		}else
		{
			notify('fail','Lga Already exists');	
			$pilgrim_id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{
	
				if(isset($_POST['lga_id']))
				{
					$db->query("SELECT * FROM lga WHERE lga_name = '".mysql_real_escape_string(trim($_POST['lga_name']))."' AND lga_id !=('".$_POST['lga_id']."')");	
					if($db->total()==0)
					{						
						$db->query("UPDATE `lga` SET `lga_name` = '".mysql_real_escape_string(trim($_POST['lga_name']))."' WHERE `lga_id` = '".$_POST['lga_id']."' ");						
						notify('success', 'Lga has been Updated sucessfully');
					}else
					{
						notify('fail','Lga Already exists');
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
	notify('fail','Lga cannot be created, contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'lga.php');
?>