<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT * FROM carriers_location WHERE location_id!='".$_REQUEST['value']."' AND agency_id='".$_SESSION['agency_id']."' AND status='Active'");
echo '<select name="destination" id="destination" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
}
echo '</select>';
?>