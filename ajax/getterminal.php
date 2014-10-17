<?php 
include('../common/functions.php');
$db = new Database();
$data = array();
$run = $db->query("SELECT * FROM terminals WHERE id!='".$_REQUEST['value']."' AND agency_id='".$_SESSION['agency_id']."' AND status='Active'");
echo '<select name="aterminal" id="aterminal" class="input-medium">';
while($row = $db->fetch($run))
{
      	echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
}
echo '</select>';
?>