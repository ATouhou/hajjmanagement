<?php
include("../common/functions.php");
$db = new Database();

if(isset($_REQUEST['action']))
{
switch($_REQUEST['action'])
{
	case 'add':
		$db->query("SELECT id FROM terminals WHERE name='".mysql_real_escape_string($_POST['name'])."' AND agency_id='".$_SESSION['agency_id']."'");
		if($db->total()==0)
		{
			if($db->query("INSERT INTO `terminals` (`id` ,`name` ,`status` ,`agency_id`)VALUES (NULL , '".mysql_real_escape_string($_POST['name'])."', 'Active', '".$_SESSION['agency_id']."')")){
				notify('success','Terminal has been created successfully');
				
			}else{
				notify('fail','Terminal not created contact Administrator');	
				$id='';
			}
		}else
		{
			notify('fail','Terminal Already exists');	
			$id='';		
		}
	break;
	case 'edit':
			if($_SESSION['access_right']!=3)
			{	
				if(isset($_POST['id']))
				{
					$db->query("SELECT * FROM terminals WHERE name = '".mysql_real_escape_string(trim($_POST['name']))."' AND id ='".$_POST['id']."'");	
					if($db->total()==0)
					{								
						$db->query("UPDATE `terminals` SET `name` = '".mysql_real_escape_string(trim($_POST['name']))."' WHERE `id` = '".$_POST['id']."' ");							
						notify('success', 'Terminal has been Updated sucessfully');					
					}else
					{
						notify('fail','Terminal Already exists');
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
	notify('fail','Terminal cannot able to get registered contant Administrator');	

}
header('Location:'.$_SESSION['basemodule'].'terminals.php?latestid='.$id);
?>