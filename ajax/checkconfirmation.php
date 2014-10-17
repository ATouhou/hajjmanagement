<?php
if(isset($_REQUEST['val'])){ include("../common/functions.php");  }
$db = new Database();
$bno = $_REQUEST['val'];


$run_disp = $db->query("SELECT SQL_CALC_FOUND_ROWS * FROM boardingpass b LEFT JOIN agency_seat_allocation asa USING(allocation_id) WHERE b.bno='".$bno."' AND asa.carrier_id='".$_SESSION['agency_id']."'");
$num_disp = $db->total();
$run_total = $db->query("SELECT FOUND_ROWS() num;");
$row_total = $db->fetch($run_total);
$total_val = $row_total['num'];

if($total_val!=0)
{
	$row_disp = $db->fetch($run_disp);
	if($row_disp['bconfirmation']=='No')
	{
?>		

<form  name="regisfrm" method="post" enctype="multipart/form-data" action="../action/bconfirmation_transact.php" id="regisfrm"  >
<input type="hidden" name="bno" id="bno" value="<?php echo $row_disp['bno']; ?>" />
<table id="id-form" width="100%">
  <tr>
    <td>Passenger Name</td>
    <td>&nbsp;</td>
    <td>Eticket No</td>
    <td><?php echo $row_disp['eno']; ?></td>
  </tr>
  <tr>
    <td>Passport No</td>
    <td>&nbsp;</td>
    <td>Boarding Pass No</td>
    <td><?php echo $row_disp['bno']; ?></td>
  </tr>
  <tr>
    <td>Flight Id</td>
    <td><?php echo getflightno($row_disp['flight_id']); ?></td>
    <td>Nationality</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Seat No</td>
    <td><?php echo $row_disp['seat_no']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><label>
      <input type="submit" name="confirm" id="confirm" value="Confirm" style="padding:5px;" />
    </label></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

</form>

<?php		
	}else{
		$msg =  'The Passenger is already confirmed';
		echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"green-left\">
".$msg."</td>
					<td class=\"green-right\"><a class=\"close-green\"><img src=\"../images/table/icon_close_green.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";
		
		
		
	}
}else
{
	$msg = 'The E-ticket No Does not exists';	
			echo "<table border=\"0\" width=\"100%\" cellpadding=\"0\" cellspacing=\"0\">
				<tr><td class=\"red-left\">
".$msg."</td>
					<td class=\"red-right\"><a class=\"close-red\"><img src=\"../images/table/icon_close_red.gif\"   alt=\"\" /></a></td>
				</tr>
				</table>";
	
}

?>
