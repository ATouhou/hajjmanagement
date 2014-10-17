<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$flight_id = $_REQUEST['flight_id'];
//echo $flight_id;
$run = $db->query("SELECT DISTINCT(`agency_id`) agency_id FROM `agency_seat_allocation` LEFT JOIN boardingpass USING(allocation_id) WHERE flight_id= $flight_id AND bconfirmation='Yes'");
echo '<select name="agency_id" id="agency_id" class="input-medium" onchange="getagencyreport();">';
      	echo '<option value="">Choose Agency</option>';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['agency_id'].'">'.getstatename($row['agency_id']).'</option>';
}
echo '</select>';

?>