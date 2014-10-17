<?php
include("../common/functions.php");
//require("../database/db.class.php");

$db = new Database();

if(isset($_REQUEST['action']))
{
	$status =getmovementcenterstatus($_REQUEST['center_id']);
	if($status =='Active')
	{
		$c_status='Deactive';	
		$tooltip = 'icon-3 info-tooltip';
	}else
	{	
		$c_status='Active';	
		$tooltip = 'icon-5 info-tooltip';
	}
	
	if($db->query("UPDATE movement_center SET status='".$c_status."' WHERE center_id='".$_REQUEST['center_id']."' AND agency_id='".$_SESSION['agency_id']."'"))
	{
//		$db->query("UPDATE subcategory_t SET status='".$c_status."' WHERE category_id='".$_REQUEST['value']."'");
		
		echo '<a href="#"  title="'.$c_status.'" onclick="changemovementcenterstatus(\'status\',\''.$_REQUEST['center_id'].'\',\''.$c_status.'\'); return false;" class="'.$tooltip.'"></a>';
		
	}else
	{
//		echo '<a href="#" title="'.$user_status_name[$c_status].'" onclick="deleteuser(\'status\','.$_REQUEST['value'].'); return false;" class="'.$tooltip.'"></a>';

	}
}
?>