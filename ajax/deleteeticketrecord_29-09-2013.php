<?php 
include('../common/functions.php');
$db = new Database();
$eno = $_REQUEST['eno'];
/*
$run = $db->query("DELETE FROM eticket WHERE eno='".$eno."'");
if($db->total()>0)
{
$run = $db->query("SELECT * FROM boardingpass WHERE eno='".$eno."'");
$row = $db->fetch($run);

$msg =' Eticket Deleted successfully';

if($db->total()>0)
{
print_r($row);
$allocation_id = $row['allocation_id'];
$seat_no = $row['seat_no'];
$run_seats = $db->query("SELECT seats_no_alloted FROM agency_seat_allocation WHERE allocation_id='".$allocation_id."'");
$row_seats = $db->fetch($run_seats);
$seats_no_alloted = $row_seats['seats_no_alloted'].','.$seat_no;
$db->query("UPDATE agency_seat_allocation SET seats_no_alloted='".$seats_no_alloted."' WHERE allocation_id='".$allocation_id."' ");
$msg =' Eticket and Boarding Pass deleted successfully';

}

}else{ ?>
E-tcket No does not match
<?php } 
*/
?>
