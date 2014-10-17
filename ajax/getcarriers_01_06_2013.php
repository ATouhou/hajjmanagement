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
echo '</td></tr></table>';
?>