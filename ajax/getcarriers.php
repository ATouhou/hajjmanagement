<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT carriers_id,carriers_name FROM carriers WHERE carriers_status='Active'");
echo '<table widh="750"><tr><th>Carriers Name</th><td>';
echo '<select name="agency_id" id="agency_id" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['carriers_id'].'">'.$row['carriers_name'].'</option>';
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
?>