<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$agency_id = $_REQUEST['id'];

// COLLECT ALL THE FLIGHT IDS HAVING SEATS GREATOR THAN ZERO
// GET ALL THE FLIGHTS

$flight_data = array();
$time1= date("H:i");

$sql ="SELECT allocation_id,seat_allocated, flight_no FROM agency_seat_allocation asa LEFT JOIN flights USING(flight_id) WHERE asa.agency_id='".$agency_id."' AND date1 >='".date('Y-m-d')."' AND carrier_id='".$_SESSION['agency_id']."'";
$run_flight =$db->query("SELECT allocation_id,seat_allocated, flight_no FROM agency_seat_allocation asa LEFT JOIN flights USING(flight_id) WHERE asa.agency_id='".$agency_id."' AND date1 >='".date('Y-m-d')."' AND carrier_id='".$_SESSION['agency_id']."'");
while($row_flight = $db->fetch($run_flight))
{
	$db->query("SELECT id FROM eticket WHERE allocation_id ='".$row_flight['allocation_id']."'");
	
	if(($row_flight['seat_allocated']-$db->total())>0)
	{	
		$flight_data[]	= $row_flight;
	}
}
?>
      <label>
        <select name="allocation1" id="allocation1" onchange="getdetails(this.value,1); return false;" class="input-medium" >
        <option value="">Choose Flight</option>
        <?php foreach($flight_data as $val){ ?>
        <option value="<?php echo $val['allocation_id']; ?>"><?php echo $val['flight_no']; ?></option>
        <?php } ?>
        </select>
      </label>
