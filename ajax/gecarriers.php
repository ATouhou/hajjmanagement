<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT carriers_id,carriers_name FROM carriers WHERE carriers_status='Active'");
echo '<select name="lga" id="lga" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['carriers_id'].'">'.$row['carriers_name'].'</option>';
}
echo '</select>';
?>