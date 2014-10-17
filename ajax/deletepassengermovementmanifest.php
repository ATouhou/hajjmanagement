<?php 
include('../common/functions.php');
$db = new Database();
$manifestId = $_REQUEST['manifestId'];

$checkdate1 = strtotime(date('Y-m-d'));
$checkdate2 = strtotime('2015-12-07');
if(($checkdate1-$checkdate2)<0){ 
	$db->query("DELETE FROM vehicle_manifest WHERE manifest_id=".$manifestId."");
}

?>
