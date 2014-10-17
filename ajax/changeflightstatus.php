<?php
include("../common/functions.php");
//require("../database/db.class.php");

$db = new Database();

if(isset($_REQUEST['action']))
{
	$status =getflightstatus($_REQUEST['flight_id']);
	if($status =='Active')
	{
		$c_status='Deactive';	
		$tooltip = 'icon-3 info-tooltip';
	}else
	{	
		$c_status='Active';	
		$tooltip = 'icon-5 info-tooltip';
	}
	
	
	
	if($db->query("UPDATE flights SET status='".$c_status."' WHERE flight_id='".$_REQUEST['flight_id']."' AND agency_id='".$_SESSION['agency_id']."'"))
	{
//		$db->query("UPDATE subcategory_t SET status='".$c_status."' WHERE category_id='".$_REQUEST['value']."'");
		
		echo '<a href="#"  title="'.$c_status.'" onclick="changeflightstatus(\'status\',\''.$_REQUEST['flight_id'].'\',\''.$c_status.'\'); return false;" class="'.$tooltip.'"></a>';
		
	}else
	{
//		echo '<a href="#" title="'.$user_status_name[$c_status].'" onclick="deleteuser(\'status\','.$_REQUEST['value'].'); return false;" class="'.$tooltip.'"></a>';

	}
}
?>