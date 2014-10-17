<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT state_id,state_name FROM state WHERE status='Active'");
echo '<table widh="750"><tr><th>Agency Name</th><td>';
echo '<select name="agency_id" id="agency_id" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['state_id'].'">'.$row['state_name'].'</option>';
}
echo '</select>';
echo '</td></tr>';
echo '<tr><th>Access Right</th><td>';
echo '<select name="access_right" id="access_right" class="input-medium">';
echo '<option value="1">Admin </option>';
echo '<option value="2">Supervisor </option>';
echo '<option value="3">Employee</option>';
echo '</select>';
echo '</td></tr>';
echo '</table>';


//$run = $db->query("SELECT agency_id,agency_name FROM agency WHERE agency_status='Active'");
//echo '<table widh="750"><tr><th>Agency Name</th><td>';
//echo '<select name="agency_id" id="agency_id" class="input-medium">';
//while($row = $db->fetch($run))
//{
//      	echo '<option value="'.$row['agency_id'].'">'.$row['agency_name'].'</option>';
//}
//echo '</select>';
//echo '</td></tr></table>';
?>