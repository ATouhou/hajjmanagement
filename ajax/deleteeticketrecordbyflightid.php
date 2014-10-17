<?php 
include('../common/functions.php');
$db = new Database();
$flightid = $_REQUEST['flightid'];
///$flightid = 6;
$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2013-12-07');
if(($checkdate1-$checkdate2)<0){ 
//GET ALL ALLOCATION ID
$run_getallocationid = $db->query("SELECT allocation_id FROM agency_seat_allocation WHERE flight_id=".$flightid."");
$total_allocationid =$db->total();
if($total_allocationid>0)
{
	
	for($i=0;$i<$total_allocationid;$i++)
	{
		$row_getallocationid = $db->fetch($run_getallocationid);
		$allocation_id = $row_getallocationid['allocation_id'];
// GET ALL ETICKETS & ID
		$run_getetickets = $db->query("SELECT id,eno FROM eticket WHERE allocation_id='".$allocation_id."'");
		$total_etickets =$db->total();
		if($total_etickets>0)
		{
			for($e=0;$e<$total_etickets;$e++){
// DELETE ALL THE LUGGAGE
				$row_getetickets = $db->fetch($run_getetickets);
				$eticket_id = $row_getetickets['id'];
				$eno = $row_getetickets['eno'];
				$db->query("DELETE FROM luggage WHERE eticket_id='".$eticket_id."'");
// GET ALL BOARDING PASS AND DELETE IT
				$db->query("DELETE FROM boardingpass WHERE eno='".$eno."'");
// DELETE ALL ETICKETS
				$db->query("DELETE FROM eticket WHERE eno='".$eno."'");
			}
		}
// DELETE ALL ALLOCATION ID
		$db->query("DELETE FROM agency_seat_allocation WHERE allocation_id =".$allocation_id."");		
	}
}
// DELETE FLIGHT ID
	$db->query("DELETE FROM flights WHERE flight_id=".$flightid."");
}
?>
