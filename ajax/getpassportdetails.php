<?php 
if(!isset($_REQUEST['id'])){ include('../common/functions.php'); }
$db = new Database();
if(isset($_REQUEST['id']))
{
	$run_luggage = $db->query("SELECT * FROM luggage WHERE id='".base64_decode($_REQUEST['id'])."'");
	$row_luggage = $db->fetch($run_luggage);
	$passport_no = $row_luggage['passport_no'];
	$flight_id = $row_luggage['flight_id'];


}else{
	$passport_no = $_REQUEST['value'];
	$flight_id = $_REQUEST['flightid'];
}

$run = $db->query("SELECT * FROM eticket LEFT JOIN pilgrims USING (pilgrim_id) LEFT JOIN agency_seat_allocation using (allocation_id) WHERE pilgrims.passport_no='".$passport_no."' AND agency_seat_allocation.carrier_id='".$_SESSION['agency_id']."' AND agency_seat_allocation.flight_id='$flight_id'");
$row = $db->fetch($run);


if($db->total()>0)
{
$run_flight_info = $db->query("SELECT * FROM flights WHERE flight_id='".$row['flight_id']."'");
$row_flight_info = $db->fetch($run_flight_info);
?>

<table width="840" id="id-form">
  <tr>
    <td>Pilgrim Name</td>
    <td><?php echo $row['full_name']; ?></td>
    <td>Gender</td>
    <td><?php echo $row['sex']; ?></td>
  </tr>
  <tr>
    <td>Passport No</td>
    <td><?php echo $row['passport_no']; ?></td>
    <td>Nationality</td>
    <td><?php echo $row['nationality']; ?></td>
  </tr>
  <tr>
    <td>Flight No</td>
    <td><?php echo $row_flight_info['flight_no']; ?></td>
    <td>Departure From</td>
    <td><?php echo getflightlocationname($row_flight_info['source']); ?></td>
  </tr>
  <tr>
    <td>Departure Date & time</td>
    <td><?php echo $row_flight_info['date1'].'  '.$row_flight_info['time1']; ?></td>
    <td>Departure To</td>
    <td><?php echo getflightlocationname($row_flight_info['destination']); ?></td>
  </tr>
  <tr>
    <td>Arrival Date & time</td>
    <td><?php echo $row_flight_info['date2'].'  '.$row_flight_info['time2']; ?></td>
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

<form name="luggageinformation" method="post" action="../action/luggage_transact.php?action=<?php if(isset($_REQUEST['id'])){ echo "edit";}else { echo "add"; }?>">
<input type="hidden" name="flight_id" value="<?php echo $row['flight_id']; ?>" />
<input type="hidden" name="eticket_id" value="<?php echo $row['id']; ?>" />
<input type="hidden" name="passportno" id="passportno" value="<?php echo $passport_no; ?>" />
<h3>Luggage Information</h3>
<p>&nbsp;</p>
Enter Luggage weight 
<br />
<table id="dataTable" width="450px"  style="padding:10px;" >
<?php if(isset($_REQUEST['id'])){ $total_luggage =0; $luggage = explode('@', $row_luggage['luggage']); for($i=0; $i<count($luggage);$i++){ $total_luggage +=$luggage[$i]; ?>
<input type="hidden" name="luggageid" id="luggageid" value="<?php echo base64_decode($_REQUEST['id']); ?>" />
        <tr style="padding:10px;">
            <td><input type="checkbox" name="chk"/></td>
            <td><input type="text" name="txt[]" class="input-medium" value="<?php echo $luggage[$i]; ?>"/></td>
            <td>Enter Luggage</td>
        </tr>
<?php } }else{ ?>
        <tr style="padding:10px;">
            <td><input type="checkbox" name="chk"/></td>
            <td><input type="text" name="txt[]" class="input-medium" value="0" /></td>
            <td>Enter Luggage</td>
        </tr>
<?php } ?>        
    </table>
 
 
 
  <table id="id-form">
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><input type="button" value="Add Row" onclick="addRow('dataTable')" style="padding:5px;" /></td>
        <td><input type="button" value="Delete Row" onclick="deleteRow('dataTable')" style="padding:5px;" /></td>
        <td><input type="button" value="Total" onclick="totalSum('dataTable')" style="padding:5px;" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Total Luggage</td>
        <td><input type="text" name="sum" id="sum" readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ echo 'value='.$total_luggage; } ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Extra Luggage</td>
        <td><input type="text" name="extraluggage" id="extraluggage" readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ $extra_luggage = ($total_luggage-40) ; if($extra_luggage>40){ echo 'value='.$extra_luggage; }else{ echo 'value=0';}} ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Total Payment</td>
        <td><input type="text" name="payment" id="payment"  readonly="readonly" class="input-medium" <?php if(isset($_REQUEST['id'])){ echo 'value='.$row_luggage['extra_payment']; } ?> /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><div id="disp_button" style="visibility:hidden;"><input type="submit" name="submit" id="submit_button" value="Submit" class="form-submit"  /></div></td>
        <td>&nbsp;</td>
      </tr>
  </table>
</form>
  <?php }else{ ?>
Passport No does not match
<?php } ?>