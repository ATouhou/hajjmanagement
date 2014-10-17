<?php
include("../common/functions.php");
//require("../database/db.class.php");

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

		$id= $_REQUEST['id'];

		$db->query("SELECT manifest_id FROM accomodation_manifest WHERE accomodation_id='".mysql_real_escape_string($_POST['id'])."' AND pilgrim_id='".mysql_real_escape_string($_POST['pilgrim_id'])."'");
		if($db->total()==0)
		{
			$db->query("SELECT manifest_id FROM accomodation_manifest WHERE accomodation_id='".$_POST['id']."'");
			$total = $db->total();
			$num = $_POST['capacity'] - $total;
			if($num>0){
			
			
			if($db->query("INSERT INTO `accomodation_manifest` (`manifest_id`, `accomodation_id`, `pilgrim_id`, `created_on`, `createdby`, `agency_id`,bed_no) VALUES (NULL, '".$_POST['id']."', '".$_POST['pilgrim_id']."', CURRENT_TIMESTAMP, '".$_SESSION['uid']."', '".$_SESSION['agency_id']."','".$_POST['bed_no']."')"))
			{				
				notify('success','Pilgrim has been registered successfully');
				$manifest_id = $db->returnid();
	
				$link = 'addpilgrimaccomodation.php?id='.base64_encode($_POST['id']).'&mid='.base64_encode($manifest_id);
				
			}else{
				notify('fail','Pilgrim cannot able to get registered contact Administrator');	
				$link = 'addpilgrimaccomodation.php?id='.base64_encode($_POST['id']);
			}
			}else{
				notify('fail','No seats Available');	
				$link = 'addpilgrimaccomodation.php?id='.base64_encode($_POST['id']);
			}
		}else
		{
			notify('fail','Pilgrim Already Register');	
			$link = 'addpilgrimaccomodation.php?id='.base64_encode($_POST['id']);
			
		}
		
		
}else{
				notify('fail','Accomodation cannot be created contact Administrator');	
				$link = 'addpilgrimaccomodation.php?id='.base64_encode($_POST['id']);
	
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

header('Location:'.$_SESSION['basemodule'].$link);
?>