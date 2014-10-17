<?php 
include('../common/functions.php');
$db = new Database();
$data = array();

$run = $db->query("SELECT * FROM agency_seat_allocation LEFT JOIN flights USING (flight_id) WHERE allocation_id='".$_REQUEST['id']."'");
$row = $db->fetch($run);

?>

<table width="840">
  <tr>
    <td>Flight No</td>
    <td><?php echo $row['flight_no']; ?></td>
    <td>Departure From</td>
    <td><?php echo getflightlocationname($row['source']); ?></td>
  </tr>
  <tr>
    <td>Departure Date & time</td>
    <td><?php echo $row['date1'].'  '.$row['time1']; ?></td>
    <td>Departure To</td>
    <td><?php echo getflightlocationname($row['destination']); ?></td>
  </tr>
  <tr>
    <td>Arrival Date & time</td>
    <td><?php echo $row['date2'].'  '.$row['time2']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
