<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT * FROM lga WHERE state_id='".$_REQUEST['value']."'");
echo '<select name="lga" id="lga" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['lga_id'].'">'.$row['lga_name'].'</option>';
}
echo '</select>';
?>